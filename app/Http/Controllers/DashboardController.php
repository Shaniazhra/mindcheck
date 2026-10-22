<?php

namespace App\Http\Controllers;

use App\Models\HasilSdq;
use App\Models\LaporanBk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman utama dashboard.
     */
    public function index()
    {
        // with('user') supaya NIS bisa ditampilkan tanpa query berulang.
        $hasilSdq = HasilSdq::with('user')->latest()->get();

        return view('dashboard_gurubk', compact('hasilSdq'));
    }

    /**
     * Tampilkan dashboard khusus untuk siswa.
     *
     * Dashboard siswa hanya menampilkan hasil TERBARU dan pengingat
     * pengisian berikutnya. Perkembangan dan riwayat pengisian dilihat
     * Guru BK lewat halaman detail riwayat siswa.
     *
     * - $hasilTerakhir : hasil terbaru milik siswa ini
     * - $riwayat       : semua hasil milik siswa ini (terbaru di atas),
     *                    dipakai untuk menghitung pengingat isi ulang
     */
    public function siswa(Request $request)
    {
        $user = Auth::user();

        $riwayat = HasilSdq::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $hasilTerakhir = $riwayat->first();

        return view('dashboard_siswa', compact(
            'hasilTerakhir',
            'riwayat'
        ));
    }

    /**
     * Halaman hasil skrining lengkap milik siswa (terpisah dari Beranda).
     */
    public function hasilSkrining(Request $request)
    {
        $user = Auth::user();

        $riwayat = HasilSdq::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $hasilTerakhir = $riwayat->first();

        return view('hasil_siswa', compact('hasilTerakhir', 'riwayat'));
    }

    /**
     * Tampilkan daftar riwayat hasil SDQ beserta filter pencarian.
     */
    public function riwayat(Request $request)
    {
        // Input filter harus teks biasa. Tanpa ini, ?nama[]=x membuat trim()
        // melempar error 500.
        $request->validate([
            'nama'         => 'nullable|string|max:100',
            'kelas'        => 'nullable|string|max:20',
            'tahun_ajaran' => 'nullable|string|max:20',
            'status'       => 'nullable|string|max:30',
            'risiko_ai'    => 'nullable|string|max:10',
        ]);

        $query = HasilSdq::with('user')->latest();

        if ($request->filled('nama')) {
            $query->where(
                'nama',
                'like',
                '%' . trim($request->nama) . '%'
            );
        }

        if ($request->filled('kelas')) {
            $kelas = trim($request->kelas);

            $query->whereRaw(
                'TRIM(kelas) = ?',
                [$kelas]
            );
        }

        if ($request->filled('tahun_ajaran')) {
            $query->where(
                'tahun_ajaran',
                trim($request->tahun_ajaran)
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'hasil_label',
                trim($request->status)
            );
        }

        if ($request->filled('risiko_ai')) {
            $query->where(
                'risiko_ai',
                trim($request->risiko_ai)
            );
        }

        $hasilSdq = $query
            ->paginate(10)
            ->withQueryString();

        $daftarKelas = HasilSdq::selectRaw(
                'TRIM(kelas) as kelas, COUNT(*) as jumlah_siswa'
            )
            ->whereNotNull('kelas')
            ->whereRaw("TRIM(kelas) != ''")
            ->groupBy('kelas')
            ->orderBy('kelas')
            ->get();

        // Pilihan filter tahun ajaran (snapshot di hasil_sdq), terbaru di atas.
        $daftarTahunAjaran = HasilSdq::whereNotNull('tahun_ajaran')
            ->distinct()
            ->orderByDesc('tahun_ajaran')
            ->pluck('tahun_ajaran');

        return view('riwayat', compact(
            'hasilSdq',
            'daftarKelas',
            'daftarTahunAjaran'
        ));
    }

    /**
     * Tampilkan detail hasil SDQ untuk satu siswa.
     *
     * - $s            : hasil yang sedang dibuka
     * - $riwayatSiswa : semua hasil milik siswa yang sama (terbaru di atas),
     *                   dipakai untuk grafik perkembangan, perubahan tiap
     *                   aspek, riwayat pengisian, dan pengingat isi ulang.
     */
    public function detail($id)
    {
        $s = HasilSdq::with('user')->findOrFail($id);

        // Dicocokkan lewat user_id supaya siswa dengan nama kembar tidak tercampur.
        // Skrining tanpa user_id: riwayat hanya berisi hasil ini saja.
        $riwayatSiswa = $s->user_id
            ? HasilSdq::where('user_id', $s->user_id)
                ->orderBy('created_at', 'desc')
                ->get()
            : collect([$s]);

        return view('riwayat_detail', compact('s', 'riwayatSiswa'));
    }

    /**
     * Ubah nomor HP siswa dari halaman detail riwayat (oleh Guru BK).
     *
     * Nomor disimpan di akun siswa (users.no_telp), jadi berlaku untuk
     * semua riwayat skrining siswa tersebut. Kosongkan untuk menghapus nomor.
     */
    public function updateNoTelp(Request $request, $id)
    {
        $s = HasilSdq::with('user')->findOrFail($id);

        if (!$s->user) {
            return redirect("/riwayat/{$id}")
                ->withErrors([
                    'no_telp' => 'Data ini tidak terhubung ke akun siswa, jadi nomor HP tidak dapat diubah.',
                ]);
        }

        $data = $request->validate([
            'no_telp' => ['nullable', 'string', 'max:20', 'regex:/^\+?[0-9\s\-]{8,20}$/'],
        ], [
            'no_telp.regex' => 'Format nomor HP tidak valid. Gunakan angka saja, contoh: 081234567890.',
        ]);

        $nomor = trim($data['no_telp'] ?? '');

        // Diisi langsung (bukan mass assignment) supaya tidak bergantung pada $fillable.
        $s->user->no_telp = $nomor !== '' ? $nomor : null;
        $s->user->save();

        return redirect("/riwayat/{$id}")
            ->with('success', $nomor !== ''
                ? 'Nomor HP siswa berhasil diperbarui.'
                : 'Nomor HP siswa dihapus.');
    }

    /**
     * Tampilkan form laporan BK untuk satu hasil skrining.
     *
     * Tidak membuat data apa pun di database. Baris laporan baru dibuat
     * saat Guru BK menekan tombol simpan.
     */
    public function laporanForm($id)
    {
        $s = HasilSdq::findOrFail($id);

        $laporan = LaporanBk::where('hasil_sdq_id', $id)->first()
            ?? new LaporanBk([
                'tanggal_laporan' => now('Asia/Jakarta')
            ]);

        // Riwayat: semua laporan siswa ini (lintas skrining) yang sudah terisi.
        // Dicocokkan lewat user_id supaya siswa dengan nama kembar tidak tercampur.
        $riwayatLaporan = LaporanBk::whereHas('hasilSdq', function ($q) use ($s) {
                if ($s->user_id) {
                    $q->where('user_id', $s->user_id);
                } else {
                    // Skrining tanpa user_id: tampilkan hanya laporan skrining ini.
                    $q->where('id', $s->id);
                }
            })
            ->whereNotNull('rekomendasi')
            ->where('rekomendasi', '!=', '')
            ->orderByDesc('tanggal_laporan')
            ->orderByDesc('id')
            ->get();

        // Saran sistem berdasarkan hasil skrining.
        // Ditampilkan sebagai referensi bagi Guru BK.
        // Rekomendasi resmi tetap ditulis oleh Guru BK.
        $rekomendasiOtomatis = $this->generateRekomendasiOtomatis($s);

        return view('Laporan_bk', compact(
            's',
            'laporan',
            'riwayatLaporan',
            'rekomendasiOtomatis'
        ));
    }

    /**
     * Simpan atau update laporan BK.
     *
     * Yang digunakan dalam laporan:
     * - tanggal laporan
     * - observasi Guru BK
     * - rekomendasi Guru BK
     *
     * Laporan bisa diedit ulang kapan saja (satu skrining = satu laporan).
     * Export PDF dilakukan dari Riwayat Laporan, bukan dari tombol simpan.
     */
    public function laporanSimpan(Request $request, $id)
    {
        $s = HasilSdq::findOrFail($id);

        $data = $request->validate([
            'rekomendasi'     => 'required|string|min:10|max:5000',
            'observasi'       => 'nullable|string|max:5000',
            'tanggal_laporan' => 'nullable|date',
        ], [
            'rekomendasi.required' => 'Rekomendasi Guru BK wajib diisi.',
            'rekomendasi.min'      => 'Rekomendasi Guru BK terlalu singkat.',
            'rekomendasi.max'      => 'Rekomendasi Guru BK terlalu panjang (maks. 5000 karakter).',
        ]);

        $data['tanggal_laporan'] = $data['tanggal_laporan']
            ?? now('Asia/Jakarta')->toDateString();

        /*
         * Rekomendasi sistem disimpan terpisah sebagai arsip
         * hasil analisis sistem.
         *
         * Rekomendasi resmi tetap berasal dari Guru BK.
         */
        $data['rekomendasi_sistem'] = $this->generateRekomendasiOtomatis($s);
        $data['guru_bk_id']         = Auth::id();

        $laporan = LaporanBk::updateOrCreate(
            ['hasil_sdq_id' => $id],
            $data
        );

        // Laporan yang sama bisa diedit berkali-kali (mis. memperbaiki typo).
        // Setiap simpan langsung tampil di Riwayat Laporan; export PDF
        // dilakukan dari riwayat tersebut.
        $pesan = $laporan->wasRecentlyCreated
            ? 'Laporan BK berhasil disimpan dan masuk ke riwayat.'
            : 'Perubahan laporan BK berhasil disimpan.';

        return redirect("/riwayat/{$id}/laporan#riwayat-laporan")
            ->with('info', $pesan);
    }

    /**
     * Tampilkan form untuk mengedit SATU laporan BK tertentu
     * (dipilih dari Riwayat Laporan, bisa dari skrining siswa yang sama).
     *
     * Memakai view yang sama dengan form laporan. $modeEdit = true
     * menandai bahwa laporan yang dibuka sudah ada.
     */
    public function laporanEdit($id, $laporan_id)
    {
        [$s, $laporan] = $this->laporanMilikSiswa($id, $laporan_id);

        // $s = skrining yang menjadi dasar laporan ini.
        $s = $laporan->hasilSdq;

        $riwayatLaporan = LaporanBk::whereHas('hasilSdq', function ($q) use ($s) {
                if ($s->user_id) {
                    $q->where('user_id', $s->user_id);
                } else {
                    $q->where('id', $s->id);
                }
            })
            ->whereNotNull('rekomendasi')
            ->where('rekomendasi', '!=', '')
            ->orderByDesc('tanggal_laporan')
            ->orderByDesc('id')
            ->get();

        $rekomendasiOtomatis = $this->generateRekomendasiOtomatis($s);
        $modeEdit            = true;

        return view('Laporan_bk', compact(
            's',
            'laporan',
            'riwayatLaporan',
            'rekomendasiOtomatis',
            'modeEdit'
        ));
    }

    /**
     * Simpan perubahan satu laporan BK yang sudah ada.
     */
    public function laporanUpdate(Request $request, $id, $laporan_id)
    {
        [, $laporan] = $this->laporanMilikSiswa($id, $laporan_id);

        $data = $request->validate([
            'rekomendasi'     => 'required|string|min:10|max:5000',
            'observasi'       => 'nullable|string|max:5000',
            'tanggal_laporan' => 'nullable|date',
        ], [
            'rekomendasi.required' => 'Rekomendasi Guru BK wajib diisi.',
            'rekomendasi.min'      => 'Rekomendasi Guru BK terlalu singkat.',
            'rekomendasi.max'      => 'Rekomendasi Guru BK terlalu panjang (maks. 5000 karakter).',
        ]);

        $data['tanggal_laporan'] = $data['tanggal_laporan']
            ?? now('Asia/Jakarta')->toDateString();

        // Sama seperti laporanSimpan(): arsip saran sistem diperbarui
        // dan guru yang menyimpan terakhir menjadi penanda tangan.
        $data['rekomendasi_sistem'] = $this->generateRekomendasiOtomatis($laporan->hasilSdq);
        $data['guru_bk_id']         = Auth::id();

        $laporan->update($data);

        return redirect("/riwayat/{$laporan->hasil_sdq_id}/laporan#riwayat-laporan")
            ->with('info', 'Perubahan laporan BK berhasil disimpan.');
    }

    /**
     * Ambil skrining + laporan, dan pastikan laporan itu milik siswa yang sama
     * dengan skrining di URL (dicocokkan lewat user_id), supaya laporan siswa
     * lain tidak bisa dibuka atau diubah dengan menebak ID.
     *
     * @return array{0: HasilSdq, 1: LaporanBk}
     */
    private function laporanMilikSiswa($id, $laporan_id): array
    {
        $s       = HasilSdq::findOrFail($id);
        $laporan = LaporanBk::with('hasilSdq')->findOrFail($laporan_id);
        $hasil   = $laporan->hasilSdq;

        $sama = $hasil && (
            (int) $hasil->id === (int) $s->id
            || ($s->user_id && (int) $hasil->user_id === (int) $s->user_id)
        );

        abort_unless($sama, 404);

        return [$s, $laporan];
    }

    /**
     * Export / Cetak laporan BK ke format PDF.
     *
     * Dipanggil dari tombol Export PDF di Riwayat Laporan.
     * PDF selalu dibuat dari data terbaru di database, jadi hasil edit
     * langsung ikut terbaca.
     */
    public function laporanPdf($id)
    {
        $s = HasilSdq::findOrFail($id);

        $laporan = LaporanBk::with('guruBk')
            ->where('hasil_sdq_id', $id)
            ->first();

        /*
         * PDF tidak dapat dibuat jika rekomendasi Guru BK
         * belum diisi dan disimpan.
         */
        if (!$laporan || blank($laporan->rekomendasi)) {
            return redirect("/riwayat/{$id}/laporan")
                ->with(
                    'info',
                    'Isi dan simpan rekomendasi terlebih dahulu sebelum export PDF.'
                );
        }

        // Tanda tangan = guru yang menyimpan laporan,
        // bukan yang kebetulan login saat mencetak.
        $guruNama = $laporan->guruBk->name ?? Auth::user()->name;
        $guruNip  = $laporan->guruBk->nip ?? Auth::user()->nip ?? null;

        $pdf = Pdf::loadView(
            'LaporanBK_pdf',
            compact(
                's',
                'laporan',
                'guruNama',
                'guruNip'
            )
        )
            ->setOption([
                'isRemoteEnabled'      => false,
                'isHtml5ParserEnabled' => true,
            ])
            ->setPaper('a4', 'portrait');

        // Render dulu supaya jumlah halaman diketahui,
        // lalu gambar tanda tangan di dasar HALAMAN TERAKHIR.
        $pdf->output();
        $this->gambarTandaTangan($pdf, $guruNama, $guruNip);

        $namaFile = 'Laporan-BK-' .
            Str::slug($s->nama ?: 'siswa') .
            '.pdf';

        return $pdf->stream($namaFile);
    }

    /**
     * Gambar blok tanda tangan Guru BK (tanggal, jabatan, QR, nama, NIP)
     * di dasar halaman terakhir, tepat di atas footer.
     * Posisi dihitung dari ukuran halaman, jadi otomatis ke bawah
     * baik laporan 1 halaman maupun lebih.
     */
    private function gambarTandaTangan(
        $pdf,
        string $guruNama,
        ?string $guruNip
    ): void {
        $canvas  = $pdf->getDomPDF()->getCanvas();
        $qrPath  = public_path('qrcode.jpeg');
        $tanggal = 'Jakarta, ' . now()->translatedFormat('j F Y');
        $nip     = 'NIP. ' . ($guruNip ?: '-');

        $canvas->page_script(
            function (
                $pageNumber,
                $pageCount,
                $canvas,
                $fontMetrics
            ) use (
                $qrPath,
                $tanggal,
                $guruNama,
                $nip
            ) {

                // Hanya di halaman terakhir.
                if ($pageNumber !== $pageCount) {
                    return;
                }

                $reguler = $fontMetrics->getFont('Helvetica');
                $tebal   = $fontMetrics->getFont('Helvetica', 'bold');
                $gelap   = [0.07, 0.09, 0.15];
                $abu     = [0.29, 0.33, 0.39];

                $lebar  = $canvas->get_width();
                $tinggi = $canvas->get_height();

                // Margin sama dengan @page di blade
                // (kanan 2,2 cm; bawah 2,4 cm).
                $marginKanan = 2.2 * 28.3465;
                $marginBawah = 2.4 * 28.3465;

                $pusatX = $lebar - $marginKanan - 100;
                $y      = $tinggi - $marginBawah - 79;

                $tengah = function (
                    string $teks,
                    string $font,
                    float $ukuran,
                    float $yPos,
                    array $warna
                ) use (
                    $canvas,
                    $fontMetrics,
                    $pusatX
                ) {
                    $w = $fontMetrics->getTextWidth(
                        $teks,
                        $font,
                        $ukuran
                    );

                    $canvas->text(
                        $pusatX - $w / 2,
                        $yPos,
                        $teks,
                        $font,
                        $ukuran,
                        $warna
                    );

                    return $w;
                };

                $tengah(
                    $tanggal,
                    $reguler,
                    7.5,
                    $y,
                    $gelap
                );

                $tengah(
                    'Guru Bimbingan Konseling',
                    $tebal,
                    7.5,
                    $y + 10,
                    $gelap
                );

                if (file_exists($qrPath)) {
                    $canvas->image(
                        $qrPath,
                        $pusatX - 20,
                        $y + 22,
                        40,
                        40
                    );
                }

                $wNama = $tengah(
                    $guruNama,
                    $tebal,
                    7.5,
                    $y + 66,
                    $gelap
                );

                // Garis bawah nama
                $canvas->line(
                    $pusatX - $wNama / 2,
                    $y + 75,
                    $pusatX + $wNama / 2,
                    $y + 75,
                    $gelap,
                    0.6
                );

                $tengah(
                    $nip,
                    $reguler,
                    6,
                    $y + 79,
                    $abu
                );
            }
        );
    }

    /**
     * Tampilkan daftar semua kelas beserta jumlah siswa AKTIF.
     *
     * Siswa yang sudah lulus tidak lagi ditampilkan di Data per Kelas.
     * Mereka dipindahkan secara tampilan ke Riwayat Angkatan.
     */
    public function kelasIndex()
    {
        $daftarKelas = User::where('role', 'siswa')
            ->where('status', 'aktif')
            ->whereNotNull('kelas')
            ->selectRaw(
                'TRIM(kelas) as kelas, COUNT(*) as jumlah_siswa'
            )
            ->groupBy('kelas')
            ->orderBy('kelas')
            ->get();

        return view(
            'kelas.index',
            compact('daftarKelas')
        );
    }

    /**
     * Tampilkan daftar siswa AKTIF dalam satu kelas
     * beserta hasil SDQ terakhir masing-masing.
     */
    public function kelasDetail($kode)
    {
        $siswaList = User::where('role', 'siswa')
            ->where('status', 'aktif')
            ->whereRaw(
                'TRIM(kelas) = ?',
                [trim($kode)]
            )
            ->orderBy('name')
            ->get()
            ->map(function ($siswa) {

                // Dicari lewat user_id, bukan nama + kelas.
                $siswa->hasil_terakhir = HasilSdq::where(
                        'user_id',
                        $siswa->id
                    )
                    ->latest()
                    ->first();

                return $siswa;
            });

        return view(
            'kelas.detail',
            compact(
                'siswaList',
                'kode'
            )
        );
    }

    /**
     * Tampilkan daftar ANGKATAN yang sudah memiliki siswa LULUS.
     *
     * Angkatan = tahun masuk siswa (users.angkatan), mis. 2023
     * berarti masuk kelas 7 pada 2023 dan lulus 2026.
     */
    public function riwayatAngkatan()
    {
        $riwayat = User::where('role', 'siswa')
            ->where('status', 'lulus')
            ->whereNotNull('angkatan')
            ->selectRaw('angkatan, COUNT(*) as jumlah_siswa')
            ->groupBy('angkatan')
            ->orderByDesc('angkatan')
            ->get();

        return view('riwayat_angkatan.index', compact('riwayat'));
    }

    /**
     * Tampilkan siswa yang sudah lulus pada satu angkatan.
     *
     * Contoh: 2023 -> hanya siswa berstatus lulus dengan angkatan 2023.
     */
    public function riwayatAngkatanDetail($angkatan)
    {
        $siswaList = User::where('role', 'siswa')
            ->where('status', 'lulus')
            ->where('angkatan', $angkatan)
            ->orderBy('kelas')
            ->orderBy('name')
            ->get()
            ->map(function ($siswa) {
                $siswa->hasil_terakhir = HasilSdq::where('user_id', $siswa->id)
                    ->latest()
                    ->first();

                return $siswa;
            });

        return view('riwayat_angkatan.detail', compact('siswaList', 'angkatan'));
    }

    /* =====================================================================
     | SARAN SISTEM
     | Disusun berdasarkan subskala SDQ, ditulis dalam kalimat naratif
     | (bukan perintah) supaya natural saat disalin ke rekomendasi.
     ===================================================================== */

    /**
     * Susun teks saran sistem:
     * ringkasan kondisi + uraian singkat tiap subskala yang perlu perhatian.
     *
     * Saran ini hanya menjadi referensi Guru BK.
     */
    private function generateRekomendasiOtomatis(HasilSdq $s): string
    {
        $blok = [];

        // Nama panggilan (kata pertama) supaya kalimat terdengar natural.
        $panggilan = trim(
            explode(
                ' ',
                trim((string) $s->nama)
            )[0] ?? ''
        );

        $panggilan = $panggilan !== ''
            ? $panggilan
            : 'siswa';

        // Ringkasan kondisi umum
        $isRisikoAI = ($s->risiko_ai ?? '') === 'YES';

        $keputusan =
            $s->keputusan_akhir ??
            $s->hasil_label;

        $ringkas =
            "Secara umum, total skor kesulitan {$panggilan} adalah "
            . "{$s->total_kesulitan}/40 dengan kategori {$s->hasil_label}.";

        if (
            $isRisikoAI &&
            $s->hasil_label === 'Normal'
        ) {

            $ringkas .=
                ' Meskipun skor total tergolong Normal, model AI menandai '
                . 'adanya pola risiko pada kombinasi subskalanya, sehingga '
                . 'hal ini perlu dikonfirmasi melalui wawancara individual.';

        } elseif (
            in_array(
                $keputusan,
                ['High Risk', 'Abnormal'],
                true
            )
        ) {

            $ringkas .=
                ' Kondisi ini termasuk prioritas penanganan segera. '
                . 'Rujukan ke psikolog sekolah atau puskesmas dapat '
                . 'dipertimbangkan apabila keluhan menetap.';

        } elseif (
            $keputusan === 'Borderline' ||
            $isRisikoAI
        ) {

            $ringkas .=
                ' Kondisi ini berada pada zona waspada, sehingga '
                . 'penanganan preventif dinilai perlu agar tidak '
                . 'berkembang lebih lanjut.';

        } else {

            $ringkas .=
                ' Tidak terdapat indikasi risiko saat ini, sehingga '
                . 'pemantauan rutin dinilai cukup.';
        }

        $blok[] = $ringkas;

        // Uraian per subskala
        $subskala = [

            [
                'Emosional',
                (int) $s->skor_emotional,
                [6, 7],
                false
            ],

            [
                'Perilaku',
                (int) $s->skor_conduct,
                [4, 5],
                false
            ],

            [
                'Hiperaktivitas',
                (int) $s->skor_hyperactivity,
                [6, 7],
                false
            ],

            [
                'Teman Sebaya',
                (int) $s->skor_peer,
                [4, 6],
                false
            ],

            [
                'Prososial',
                (int) $s->skor_prosocial,
                [5, 4],
                true
            ],
        ];

        foreach (
            $subskala as [
                $nama,
                $skor,
                $ambang,
                $dibalik
            ]
        ) {

            $kategori = $this->kategoriSubskala(
                $skor,
                $ambang,
                $dibalik
            );

            // Jika sehat, tidak perlu ditampilkan panjang.
            if ($kategori === 'baik') {
                continue;
            }

            $kalimat = $this->saranSubskala(
                $nama,
                $kategori,
                $panggilan
            );

            if (empty($kalimat)) {
                continue;
            }

            $label = $kategori === 'perhatian'
                ? (
                    $dibalik
                        ? 'rendah'
                        : 'tinggi'
                )
                : (
                    $dibalik
                        ? 'cukup rendah'
                        : 'cukup tinggi'
                );

            $teks = implode(' ', $kalimat);

            // Huruf kecil di awal hanya jika kalimat tidak diawali nama siswa.
            if (!str_starts_with($teks, $panggilan)) {
                $teks = lcfirst($teks);
            }

            $blok[] =
                "Pada aspek " . mb_strtolower($nama)
                . " ({$skor}/10, tergolong {$label}), "
                . $teks;
        }

        // Jika seluruh subskala sehat.
        if (count($blok) === 1) {

            $blok[] =
                "Seluruh subskala berada pada rentang sehat. "
                . "Pemantauan rutin sesuai jadwal skrining sekolah dapat "
                . "dilanjutkan, dan {$panggilan} dapat dilibatkan dalam "
                . "kegiatan positif serta dukungan teman sebaya.";
        }

        return implode(
            "\n\n",
            $blok
        );
    }

    /**
     * Tentukan kategori subskala:
     * baik / waspada / perhatian.
     */
    private function kategoriSubskala(
        int $skor,
        array $ambang,
        bool $dibalik = false
    ): string {

        [
            $waspada,
            $perhatian
        ] = $ambang;

        if ($dibalik) {

            if ($skor <= $perhatian) {
                return 'perhatian';
            }

            if ($skor <= $waspada) {
                return 'waspada';
            }

            return 'baik';
        }

        if ($skor >= $perhatian) {
            return 'perhatian';
        }

        if ($skor >= $waspada) {
            return 'waspada';
        }

        return 'baik';
    }

    /**
     * Kalimat uraian per subskala (nada naratif, bukan perintah).
     * Placeholder {n} diganti dengan nama panggilan siswa.
     */
    private function saranSubskala(
        string $nama,
        string $kategori,
        string $panggilan = 'siswa'
    ): array {

        $peta = [

            'Emosional' => [

                'perhatian' => [
                    'Konseling individual dapat menjadi ruang bagi {n} untuk menceritakan kecemasan atau kesedihan yang dirasakannya.',
                    'Teknik regulasi emosi seperti pernapasan dalam atau grounding dapat dikenalkan untuk membantunya menenangkan diri.',
                    'Jurnal emosi juga dapat membantunya mengenali pola dan pemicu perasaannya.',
                    'Apabila keluhan menetap atau mengganggu aktivitas, koordinasi dengan orang tua dan pertimbangan rujukan ke tenaga profesional dapat dilakukan.',
                ],

                'waspada' => [
                    'Konseling kelompok kecil bertema pengelolaan stres dan emosi dapat menjadi pilihan bagi {n}.',
                    'Ia juga dapat dilatih strategi menenangkan diri saat menghadapi tekanan.',
                    'Perubahan suasana hati dan pengaruhnya terhadap kegiatan belajar dapat terus dipantau.',
                ],
            ],

            'Perilaku' => [

                'perhatian' => [
                    'Pendekatan konseling behavioral dengan target perilaku yang spesifik dapat membantu {n} mengelola perilakunya.',
                    'Latihan pengendalian marah dan pemecahan masalah melalui role play dapat menjadi bagian dari sesi konseling.',
                    'Pemantauan perilaku dapat dikoordinasikan bersama wali kelas dan guru mata pelajaran.',
                    'Bila diperlukan, orang tua dapat dilibatkan agar strategi penanganan berjalan konsisten.',
                ],

                'waspada' => [
                    'Sesi reflektif dapat membantu {n} memahami dampak perilakunya terhadap diri sendiri dan orang lain.',
                    'Penguatan positif ketika ia menunjukkan perilaku yang diharapkan dapat mendukung perubahan tersebut.',
                    'Frekuensi perilaku tersebut dapat dipantau pada periode berikutnya.',
                ],
            ],

            'Hiperaktivitas' => [

                'perhatian' => [
                    'Strategi belajar terstruktur, dengan tugas dibagi menjadi beberapa bagian kecil, dapat membantu {n} tetap fokus.',
                    'Daftar tugas harian dapat membantunya mengorganisasi pekerjaan.',
                    'Lingkungan belajar dengan sedikit distraksi juga akan mendukung konsentrasinya.',
                    'Apabila kesulitan konsentrasi menetap dan mengganggu prestasi akademik, konsultasi dengan tenaga profesional dapat dipertimbangkan.',
                ],

                'waspada' => [
                    'Latihan manajemen waktu sederhana dapat membantu {n} mengatur kegiatannya.',
                    'Pengingat visual seperti jadwal atau daftar tugas dapat digunakan sebagai penunjang.',
                    'Perlu diamati apakah kesulitan muncul pada semua mata pelajaran atau hanya pada situasi tertentu.',
                ],
            ],

            'Teman Sebaya' => [

                'perhatian' => [
                    'Kemungkinan adanya perundungan, penolakan, atau isolasi sosial dapat digali lebih lanjut melalui wawancara individual.',
                    'Pemetaan sederhana hubungan pertemanan di kelas dapat memberi gambaran mengenai lingkungan sosial {n}.',
                    'Keterampilan sosial seperti memulai percakapan dan bergabung dalam kelompok dapat dilatih secara bertahap.',
                    'Keterlibatan dalam kegiatan kelompok yang terstruktur juga dapat membantunya membangun relasi.',
                ],

                'waspada' => [
                    '{n} dapat didorong untuk mengikuti kegiatan kelompok sesuai minatnya.',
                    'Kesempatan interaksi positif dengan teman sebaya dapat diciptakan untuk mendukung relasinya.',
                    'Dinamika pertemanannya dapat terus dipantau.',
                ],
            ],

            'Prososial' => [

                'perhatian' => [
                    'Peran yang bertanggung jawab di kelas dapat melatih kepedulian {n} terhadap orang lain.',
                    'Role play atau diskusi kasus dapat digunakan untuk melatih empati.',
                    'Apresiasi yang spesifik terhadap perilaku menolong juga dapat memperkuat kebiasaan tersebut.',
                    'Perlu diperiksa apakah skor ini berkaitan dengan masalah relasi sebaya atau kondisi emosional.',
                ],

                'waspada' => [
                    'Keterlibatan dalam kegiatan sosial sekolah dapat menjadi sarana bagi {n} untuk mengembangkan kepedulian.',
                    'Umpan balik positif ketika ia menunjukkan kepedulian dapat mendorong perilaku tersebut.',
                ],
            ],
        ];

        $daftar = $peta[$nama][$kategori] ?? [];

        return array_map(
            fn ($kalimat) => str_replace(
                '{n}',
                $panggilan,
                $kalimat
            ),
            $daftar
        );
    }
}