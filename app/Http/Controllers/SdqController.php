<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\HasilSdq;
use App\Support\TahunAjaran;

class SdqController extends Controller
{
    /**
     * URL Flask Naive Bayes
     *
     * Di .env (satu baris, tanpa mengulang nama variabel):
     * FLASK_SDQ_URL=http://127.0.0.1:5000/sdq
     *
     * Jika .env tidak mengisinya, dipakai Flask lokal di bawah ini.
     */
    private function flaskUrl()
    {
        // Lewat config (bukan env() langsung) supaya tetap terbaca
        // setelah "php artisan config:cache" di server produksi.
        return config(
            'services.flask.sdq_url',
            'http://127.0.0.1:5000/sdq'
        );
    }


    /**
     * =========================================================
     * HASIL SDQ TERAKHIR MILIK USER
     * =========================================================
     *
     * Dicari lewat user_id (bukan nama + kelas), supaya tidak
     * tertukar kalau ada siswa dengan nama sama atau nama diubah.
     */
    private function hasilTerakhir($user)
    {
        return HasilSdq::where('user_id', $user->id)
            ->latest()
            ->first();
    }


    /**
     * =========================================================
     * HALAMAN KUESIONER SDQ
     * =========================================================
     */
    public function index()
    {
        $user = Auth::user();

        $terakhir = $this->hasilTerakhir($user);

        if ($terakhir) {
            $bolehIsiLagiPada = $terakhir->created_at
                ->copy()
                ->addWeek();

            if (now()->lt($bolehIsiLagiPada)) {
                $sisaHari = now()->diffInDays(
                    $bolehIsiLagiPada,
                    false
                );

                $sisaHari = max(1, ceil($sisaHari));

                return redirect('/dashboard-siswa')->with(
                    'info',
                    "Kamu sudah mengisi kuesioner SDQ minggu ini. Kamu bisa mengisi lagi dalam {$sisaHari} hari."
                );
            }
        }

        return view('sdq');
    }


    /**
     * =========================================================
     * SUBMIT KUESIONER SDQ
     * =========================================================
     *
     * Pola Post/Redirect/Get:
     * setelah POST selesai, siswa DIARAHKAN (redirect) ke
     * GET /sdq/hasil. Halaman hasil tidak lagi dirender langsung
     * dari POST, jadi refresh / tombol back / pemulihan tab tidak
     * lagi memunculkan error "GET method is not supported for
     * route sdq/submit", dan tidak ada risiko kirim ulang form.
     *
     * Pengaman submit ganda:
     *
     * 1. LOCK per siswa. Kalau tombol diklik dua kali, atau halaman
     *    di-refresh saat proses masih berjalan (Flask bisa sampai
     *    15 detik), request kedua ditolak.
     *
     * 2. CEK 1 MINGGU. Aturan yang sama dengan index(), tapi
     *    dicek juga di sini. Sebelumnya hanya dicek saat halaman
     *    dibuka, sehingga refresh / kirim ulang bisa menyimpan
     *    hasil lagi. Kalau sudah mengisi minggu ini, yang ditampilkan
     *    adalah hasil yang sudah ada dan TIDAK disimpan lagi.
     */
    public function submit(Request $request)
    {
        $user = Auth::user();

        // 25 jawaban wajib ada dan hanya bernilai 0, 1, atau 2.
        // Tanpa ini, nilai di luar rentang (mis. 99 atau -5) bisa dikirim
        // manual dan merusak skor, dan jawaban kosong diam-diam dianggap 0.
        $aturan = [];
        for ($i = 1; $i <= 25; $i++) {
            $aturan["sdq$i"] = ['required', 'integer', 'in:0,1,2'];
        }

        $validator = Validator::make($request->all(), $aturan);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Semua 25 pernyataan wajib dijawab.');
        }

        $lock = Cache::lock('sdq_submit_' . $user->id, 30);

        if (!$lock->get()) {
            return redirect('/dashboard-siswa')->with(
                'info',
                'Jawabanmu sedang diproses. Mohon tunggu sebentar.'
            );
        }

        try {
            $terakhir = $this->hasilTerakhir($user);

            if (
                $terakhir &&
                now()->lt($terakhir->created_at->copy()->addWeek())
            ) {
                // Sudah mengisi minggu ini: tampilkan hasil yang ada.
                return redirect('/sdq/hasil');
            }

            $this->prosesSubmit($request, $user);

            return redirect('/sdq/hasil');
        } finally {
            $lock->release();
        }
    }


    /**
     * =========================================================
     * PROSES HITUNG + SIMPAN SDQ
     * =========================================================
     *
     * Hanya menghitung dan menyimpan. Halaman hasil ditampilkan
     * oleh hasil() lewat redirect dari submit().
     */
    private function prosesSubmit(Request $request, $user): void
    {
        /*
         * Ambil 25 jawaban
         */
        $jawaban = [];

        for ($i = 1; $i <= 25; $i++) {
            $jawaban[$i] = (int) $request->input(
                "sdq$i",
                0
            );
        }


        /*
         * =====================================================
         * REVERSE SCORING
         * =====================================================
         */
        $reverse = [
            7,
            11,
            14,
            21,
            25
        ];

        foreach ($reverse as $r) {
            $jawaban[$r] = 2 - $jawaban[$r];
        }


        /*
         * =====================================================
         * HITUNG SUBSKALA SDQ
         * =====================================================
         */

        $emotional =
            $jawaban[1] +
            $jawaban[3] +
            $jawaban[13] +
            $jawaban[16] +
            $jawaban[24];

        $conduct =
            $jawaban[5] +
            $jawaban[7] +
            $jawaban[12] +
            $jawaban[18] +
            $jawaban[22];

        $hyperactivity =
            $jawaban[2] +
            $jawaban[10] +
            $jawaban[15] +
            $jawaban[21] +
            $jawaban[25];

        $peer =
            $jawaban[6] +
            $jawaban[8] +
            $jawaban[11] +
            $jawaban[14] +
            $jawaban[19];

        $prosocial =
            $jawaban[4] +
            $jawaban[9] +
            $jawaban[17] +
            $jawaban[20] +
            $jawaban[23];


        /*
         * Total kesulitan
         *
         * Prosocial TIDAK dimasukkan.
         */
        $total =
            $emotional +
            $conduct +
            $hyperactivity +
            $peer;


        /*
         * =====================================================
         * KLASIFIKASI SDQ BAKU
         * =====================================================
         */

        if ($total <= 15) {
            $label = 'Normal';
        } elseif ($total <= 19) {
            $label = 'Borderline';
        } else {
            $label = 'Abnormal';
        }


        /*
         * =====================================================
         * COBA PANGGIL NAIVE BAYES
         * =====================================================
         *
         * Kalau Flask berhasil:
         *     hasil NB langsung disimpan.
         *
         * Kalau Flask gagal:
         *     data SDQ tetap disimpan.
         *     hasil NB dibuat "Tidak tersedia".
         *
         * Nantinya method hasil() akan mencoba lagi
         * ketika halaman hasil di-refresh.
         */
        $nbResult = $this->requestNaiveBayes(
            $emotional,
            $hyperactivity,
            $conduct,
            $peer,
            $prosocial
        );


        /*
         * =====================================================
         * SIAPKAN DATA DATABASE
         * =====================================================
         */

        $data = [
            'nama'  => $user->name,
            'kelas' => $user->kelas,
        ];


        /*
         * Simpan jawaban 1-25
         */
        for ($i = 1; $i <= 25; $i++) {
            $data["sdq$i"] = $jawaban[$i];
        }


        /*
         * Simpan skor subskala
         */
        $data['skor_emotional'] =
            $emotional;

        $data['skor_conduct'] =
            $conduct;

        $data['skor_hyperactivity'] =
            $hyperactivity;

        $data['skor_peer'] =
            $peer;

        $data['skor_prosocial'] =
            $prosocial;

        $data['total_kesulitan'] =
            $total;

        $data['hasil_label'] =
            $label;


        /*
         * =====================================================
         * HASIL NAIVE BAYES
         * =====================================================
         */

        $data['hasil_naive_bayes'] =
            $nbResult['hasil_naive_bayes'] ?? 'Tidak tersedia';

        $data['prob_normal'] =
            $nbResult['probabilitas']['Normal'] ?? null;

        $data['prob_borderline'] =
            $nbResult['probabilitas']['Borderline'] ?? null;

        $data['prob_high_risk'] =
            $nbResult['probabilitas']['High Risk'] ?? null;

        $data['keputusan_akhir'] =
            $nbResult['keputusan_akhir'] ?? null;

        $data['tindakan'] =
            $nbResult['tindakan'] ?? null;

        $data['akurasi_model'] =
            $nbResult['akurasi_model'] ?? null;

        $data['cv_score'] =
            $nbResult['cv_score'] ?? null;


        /*
         * =====================================================
         * KOMPATIBILITAS SISTEM
         * =====================================================
         */

        $hasilNb = $data['hasil_naive_bayes'];

        $data['risiko_ai'] =
            in_array(
                $hasilNb,
                [
                    'Borderline',
                    'High Risk'
                ]
            )
                ? 'YES'
                : 'NO';


        $data['prob_berisiko'] =
            (float) (
                ($data['prob_borderline'] ?? 0) +
                ($data['prob_high_risk'] ?? 0)
            );


        /*
         * =====================================================
         * SIMPAN KE DATABASE
         * =====================================================
         *
         * user_id diisi langsung (tidak lewat $fillable), supaya
         * hasil SELALU terhubung ke akun siswa. Sebelumnya user_id
         * tidak pernah diisi di sini, sehingga hasil tersimpan
         * tanpa akun dan tidak ikut terhapus saat akun dihapus.
         *
         * tahun_ajaran juga diisi langsung (snapshot saat skrining
         * diisi, mis. 2026/2027) dan tidak berubah walau siswa
         * naik kelas. Tidak lewat $fillable, jadi model HasilSdq
         * tidak perlu diubah.
         */

        $hasil = new HasilSdq();
        $hasil->user_id = $user->id;
        $hasil->tahun_ajaran = TahunAjaran::sekarang();
        $hasil->fill($data);
        $hasil->save();
    }


    /**
     * =========================================================
     * REQUEST KE FLASK NAIVE BAYES
     * =========================================================
     *
     * Setiap kegagalan sekarang DICATAT ke storage/logs/laravel.log
     * (diawali "Naive Bayes:"), supaya penyebabnya terlihat.
     * Perilaku untuk siswa tidak berubah: SDQ tetap tersimpan dan
     * hasil NB dibuat "Tidak tersedia" bila Flask gagal.
     */
    private function requestNaiveBayes(
        $emotional,
        $hyperactivity,
        $conduct,
        $peer,
        $prosocial
    ) {
        $url = $this->flaskUrl();

        try {
            $response = Http::timeout(15)->post(
                $url,
                [
                    'emotional' =>
                        $emotional,

                    'hyperactivity' =>
                        $hyperactivity,

                    'conduct' =>
                        $conduct,

                    'peer' =>
                        $peer,

                    'prosocial' =>
                        $prosocial,
                ]
            );


            /*
             * HTTP berhasil
             */
            if ($response->successful()) {
                $result = $response->json();


                /*
                 * Pastikan Flask memberikan hasil Naive Bayes yang
                 * benar-benar terhitung. "Tidak tersedia" dari Flask
                 * (model belum termuat di server Flask) dianggap gagal.
                 */
                if (
                    is_array($result) &&
                    !empty($result['hasil_naive_bayes']) &&
                    $result['hasil_naive_bayes'] !== 'Tidak tersedia'
                ) {
                    return $result;
                }

                Log::warning('Naive Bayes: Flask menjawab, tetapi hasil NB tidak tersedia', [
                    'url'    => $url,
                    'status' => $response->status(),
                    'body'   => mb_substr($response->body(), 0, 500),
                ]);
            } else {
                Log::warning('Naive Bayes: Flask membalas error HTTP', [
                    'url'    => $url,
                    'status' => $response->status(),
                    'body'   => mb_substr($response->body(), 0, 500),
                ]);
            }

        } catch (\Throwable $e) {
            /*
             * Flask gagal dihubungi.
             *
             * Jangan menggagalkan penyimpanan SDQ.
             */
            Log::warning('Naive Bayes: gagal menghubungi Flask', [
                'url'   => $url,
                'error' => get_class($e) . ': ' . $e->getMessage(),
            ]);
        }


        /*
         * =====================================================
         * FALLBACK
         * =====================================================
         *
         * Hasil SDQ tetap tersimpan.
         * Naive Bayes akan dicoba lagi ketika
         * halaman hasil di-refresh.
         */
        return [
            'hasil_naive_bayes' =>
                'Tidak tersedia',

            'probabilitas' => [
                'Normal' =>
                    0.0,

                'Borderline' =>
                    0.0,

                'High Risk' =>
                    0.0,
            ],

            'keputusan_akhir' =>
                null,

            'tindakan' =>
                null,

            'akurasi_model' =>
                null,

            'cv_score' =>
                null,
        ];
    }


    /**
     * =========================================================
     * HALAMAN HASIL SDQ
     * =========================================================
     *
     * Dibuka lewat GET /sdq/hasil (tujuan redirect dari submit()).
     * Karena ini route GET biasa, aman di-refresh kapan saja.
     *
     * INI JUGA YANG MEMBUAT AUTO-RECOUNT.
     *
     * Setiap kali halaman hasil dibuka / di-refresh:
     *
     * 1. Ambil hasil SDQ terakhir.
     * 2. Cek hasil Naive Bayes.
     * 3. Kalau sudah tersedia → langsung tampilkan.
     * 4. Kalau belum tersedia → panggil Flask lagi.
     * 5. Kalau Flask berhasil → update database.
     * 6. Tampilkan hasil terbaru.
     */
    public function hasil()
    {
        $user = Auth::user();


        /*
         * Ambil hasil SDQ terakhir
         * milik siswa yang sedang login.
         */
        $hasil = $this->hasilTerakhir($user);


        /*
         * Belum ada hasil SDQ.
         */
        if (!$hasil) {
            return redirect('/dashboard-siswa')->with(
                'error',
                'Belum ada hasil SDQ.'
            );
        }


        /*
         * =====================================================
         * CEK APAKAH NAIVE BAYES SUDAH TERSEDIA
         * =====================================================
         */

        $nbTersedia =
            !empty($hasil->hasil_naive_bayes) &&
            $hasil->hasil_naive_bayes !== 'Tidak tersedia';


        /*
         * Kalau NB belum tersedia,
         * coba hitung ulang.
         */
        if (!$nbTersedia) {

            $nbResult = $this->requestNaiveBayes(
                (int) $hasil->skor_emotional,
                (int) $hasil->skor_hyperactivity,
                (int) $hasil->skor_conduct,
                (int) $hasil->skor_peer,
                (int) $hasil->skor_prosocial
            );


            /*
             * Cek apakah percobaan ulang berhasil.
             */
            if (
                !empty(
                    $nbResult['hasil_naive_bayes']
                ) &&
                $nbResult['hasil_naive_bayes'] !==
                    'Tidak tersedia'
            ) {

                /*
                 * =============================================
                 * UPDATE HASIL NAIVE BAYES
                 * =============================================
                 */

                $hasil->hasil_naive_bayes =
                    $nbResult['hasil_naive_bayes']
                    ?? null;

                $hasil->prob_normal =
                    $nbResult['probabilitas']['Normal']
                    ?? null;

                $hasil->prob_borderline =
                    $nbResult['probabilitas']['Borderline']
                    ?? null;

                $hasil->prob_high_risk =
                    $nbResult['probabilitas']['High Risk']
                    ?? null;

                $hasil->keputusan_akhir =
                    $nbResult['keputusan_akhir']
                    ?? null;

                $hasil->tindakan =
                    $nbResult['tindakan']
                    ?? null;

                $hasil->akurasi_model =
                    $nbResult['akurasi_model']
                    ?? null;

                $hasil->cv_score =
                    $nbResult['cv_score']
                    ?? null;


                /*
                 * =============================================
                 * UPDATE KOMPATIBILITAS SISTEM
                 * =============================================
                 */

                $hasil->risiko_ai =
                    in_array(
                        $hasil->hasil_naive_bayes,
                        [
                            'Borderline',
                            'High Risk'
                        ]
                    )
                        ? 'YES'
                        : 'NO';


                $hasil->prob_berisiko =
                    (float) (
                        ($hasil->prob_borderline ?? 0) +
                        ($hasil->prob_high_risk ?? 0)
                    );


                /*
                 * Simpan perubahan
                 */
                $hasil->save();
            }
        }


        /*
         * Tampilkan hasil.
         */
        return $this->showResult($hasil);
    }


    /**
     * =========================================================
     * TAMPILKAN HASIL SDQ
     * =========================================================
     */
    private function showResult($hasil)
    {
        /*
         * Data SDQ
         */
        $label =
            $hasil->hasil_label;

        $total =
            $hasil->total_kesulitan;

        $emotional =
            $hasil->skor_emotional;

        $conduct =
            $hasil->skor_conduct;

        $hyperactivity =
            $hasil->skor_hyperactivity;

        $peer =
            $hasil->skor_peer;

        $prosocial =
            $hasil->skor_prosocial;


        /*
         * =====================================================
         * DATA NAIVE BAYES UNTUK VIEW
         * =====================================================
         */

        $nb = [
            'prediksi_nb' =>
                $hasil->hasil_naive_bayes
                ?? 'Tidak tersedia',

            'prob_normal' =>
                $hasil->prob_normal
                ?? 0,

            'prob_borderline' =>
                $hasil->prob_borderline
                ?? 0,

            'prob_high_risk' =>
                $hasil->prob_high_risk
                ?? 0,

            'prob_tertinggi' =>
                max(
                    $hasil->prob_normal ?? 0,
                    $hasil->prob_borderline ?? 0,
                    $hasil->prob_high_risk ?? 0
                ),

            'tindakan' =>
                $hasil->tindakan
                ?? '',

            'risiko_ai' =>
                $hasil->risiko_ai
                ?? 'NO',
        ];


        return view(
            'hasil_sdq',
            compact(
                'label',
                'total',
                'emotional',
                'conduct',
                'hyperactivity',
                'peer',
                'prosocial',
                'nb'
            )
        );
    }
}