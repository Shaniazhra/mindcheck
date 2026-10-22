<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan BK | {{ $s->nama }}</title>
    <link rel="icon" type="image/png" href="{{ asset('logo-smpn216.png') }}">
    <style>
        @page { margin: 1.6cm 2.2cm 2.4cm 2.2cm; }

        /* Reset sengaja tidak memakai selector "*": di DomPDF, "* { margin: 0 }"
           ikut menimpa margin @page sehingga isi mepet ke tepi kertas. */
        body, h1, h2, p, ul, li, table, th, td, div, img { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #111827;
            font-size: 11px;
            line-height: 1.5;
            padding: 0;
        }

        table { page-break-inside: auto; }
        tr { page-break-inside: avoid; }

        /* ===== Kop Surat ===== */
        .letterhead {
            display: table;
            width: 100%;
            border-bottom: 2px solid #111827;
            padding-bottom: 8px;
            margin-bottom: 16px;
        }
        .letterhead .logo-cell {
            display: table-cell;
            vertical-align: middle;
            width: 62px;
        }
        .letterhead .logo-cell img { width: 54px; height: 54px; object-fit: contain; }
        .letterhead .text-cell {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }
        .letterhead .instansi {
            font-size: 10.5px;
            font-weight: bold;
            letter-spacing: 0.3px;
            color: #111827;
        }
        .letterhead h1 {
            font-size: 16px;
            font-weight: bold;
            color: #111827;
            margin-top: 1px;
        }
        .letterhead .alamat {
            font-size: 9px;
            color: #374151;
            margin-top: 3px;
        }
        .letterhead .kontak {
            font-size: 9px;
            color: #374151;
        }

        /* ===== Judul Dokumen ===== */
        .doc-heading {
            text-align: center;
            margin-bottom: 14px;
        }
        .doc-heading h2 {
            font-size: 12.5px;
            font-weight: bold;
            text-decoration: underline;
            color: #111827;
        }
        .doc-heading p {
            font-size: 9.5px;
            color: #4B5563;
            margin-top: 2px;
        }

        /* ===== Judul Bagian ===== */
        h2.section-title {
            font-size: 11px;
            font-weight: bold;
            color: #111827;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin: 18px 0 8px;
        }

        /* ===== Identitas ===== */
        table.identity { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
        table.identity td { padding: 3.5px 0; font-size: 10.5px; vertical-align: top; color: #111827; }
        table.identity td.label { width: 130px; }
        table.identity td.sep { width: 12px; }
        table.identity td.value { font-weight: bold; }
        table.identity td.value span.normal-weight { font-weight: normal; }

        /* ===== Tabel Subskala ===== */
        table.subskala { width: 100%; border-collapse: collapse; margin-top: 6px; }
        table.subskala th, table.subskala td {
            border: 1px solid #9CA3AF;
            padding: 6px 8px;
            font-size: 10px;
            text-align: left;
            vertical-align: top;
            color: #111827;
        }
        table.subskala th { background: #F3F4F6; font-size: 9.5px; font-weight: bold; }
        table.subskala th.center, table.subskala td.score { text-align: center; }
        table.subskala td.score { font-weight: bold; width: 50px; }
        table.subskala td.interp { font-size: 9.5px; line-height: 1.4; }

        /* ===== Probabilitas AI ===== */
        table.prob { width: 100%; border-collapse: collapse; margin-top: 6px; }
        table.prob td {
            width: 33.33%;
            text-align: center;
            border: 1px solid #9CA3AF;
            padding: 7px 4px;
            color: #111827;
        }
        table.prob .prob-label { font-size: 9px; color: #4B5563; }
        table.prob .prob-val { font-size: 13px; font-weight: bold; color: #111827; }

        /* ===== Laporan Konseling ===== */
        table.laporan { width: 100%; border-collapse: collapse; margin-top: 6px; }
        table.laporan td {
            border: 1px solid #9CA3AF;
            padding: 8px 10px;
            font-size: 10.5px;
            vertical-align: top;
            color: #111827;
        }
        table.laporan td.field-label {
            width: 130px;
            background: #F3F4F6;
            font-weight: bold;
            font-size: 10px;
        }

        /* Teks panjang multi-baris (observasi, rekomendasi).
           DomPDF mengabaikan line break mentah, jadi teks diubah jadi
           paragraf dan list sungguhan sebelum dirender. */
        .rich-text p { margin: 0 0 5px 0; text-align: justify; }
        .rich-text p.subhead { font-weight: bold; margin-bottom: 2px; }
        .rich-text ul { margin: 0 0 6px 15px; padding: 0; }
        .rich-text li { margin-bottom: 2px; line-height: 1.45; }
        .rich-text > *:last-child { margin-bottom: 0; }

        /* ===== Ruang untuk Tanda Tangan =====
           Tanda tangan digambar oleh controller (canvas DomPDF) di dasar
           halaman TERAKHIR. Spacer ini menyisihkan ruangnya supaya isi
           laporan tidak menabrak tanda tangan. */
        .signature-space { height: 3.6cm; }

        /* ===== Footer (berulang di dasar setiap halaman) ===== */
        .footer-doc {
            position: fixed;
            left: 0;
            right: 0;
            bottom: -2.1cm;
            height: 1.1cm;
            padding-top: 6px;
            border-top: 1px solid #D1D5DB;
            font-size: 8.5px;
            color: #9CA3AF;
            text-align: center;
        }
        .confidential {
            text-align: center;
            font-size: 8.5px;
            color: #9CA3AF;
            margin-top: 3px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

@php
    /**
     * Ubah teks multi-baris jadi HTML yang bisa dirender DomPDF.
     * - baris diawali "-" atau "•"  -> item <ul><li>
     * - baris diakhiri ":"          -> sub-judul tebal
     * - selebihnya                  -> paragraf biasa
     */
    $rich = function (?string $teks) {
        if (blank($teks)) {
            return '<p>—</p>';
        }

        $html    = '';
        $inList  = false;

        foreach (preg_split("/\r\n|\n|\r/", trim($teks)) as $baris) {
            $baris = trim($baris);

            if ($baris === '') {
                if ($inList) { $html .= '</ul>'; $inList = false; }
                continue;
            }

            if (preg_match('/^[-•*]\s*(.+)$/u', $baris, $m)) {
                if (!$inList) { $html .= '<ul>'; $inList = true; }
                $html .= '<li>' . e($m[1]) . '</li>';
                continue;
            }

            if ($inList) { $html .= '</ul>'; $inList = false; }

            $kelas = str_ends_with($baris, ':') ? ' class="subhead"' : '';
            $html .= "<p{$kelas}>" . e($baris) . '</p>';
        }

        if ($inList) { $html .= '</ul>'; }

        return $html;
    };

    // Teks hasil analisis AI (tanpa badge/warna)
    $risikoAI = ($s->risiko_ai ?? '') === 'YES';
    if ($risikoAI && $s->hasil_label === 'Normal') {
        $analisisAI = 'Berisiko — terdeteksi pola risiko tersembunyi pada kombinasi subskala meskipun skor total tergolong Normal';
    } elseif ($risikoAI) {
        $analisisAI = 'Berisiko — terdeteksi pola risiko pada hasil skrining';
    } else {
        $analisisAI = 'Tidak berisiko — tidak terdeteksi pola risiko pada hasil skrining';
    }
    $keputusanAkhir = $s->keputusan_akhir ?? $s->hasil_label;

    // Tahun ajaran saat skrining diisi (snapshot). Hasil lama yang belum
    // terisi dihitung dari tanggal skriningnya.
    $tahunAjaranSkrining = $s->tahun_ajaran
        ?: \App\Support\TahunAjaran::sekarang($s->created_at);
@endphp

    {{-- Kop Surat --}}
    <div class="letterhead">
        <div class="logo-cell">
            <img src="{{ public_path('logo-smpn216.png') }}" alt="Logo">
        </div>
        <div class="text-cell">
            <div class="instansi">PEMERINTAH PROVINSI DAERAH KHUSUS IBUKOTA JAKARTA</div>
            <h1>SMP NEGERI 216 JAKARTA</h1>
            <div class="alamat">Jl. Salemba Raya No. 18, Kenari, Kec. Senen, Kota Jakarta Pusat, DKI Jakarta 10430</div>
            <div class="kontak">Telp: (021) 3909123 | Website: smpn216jakarta.sch.id | Email: smpn216@jakarta.go.id</div>
        </div>
    </div>

    {{-- Judul Dokumen --}}
    <div class="doc-heading">
        <h2>LAPORAN KONSELING SISWA</h2>
        <p>Berdasarkan Hasil Skrining Kesehatan Mental (SDQ)</p>
    </div>

    {{-- Identitas Siswa --}}
    <h2 class="section-title">Identitas Siswa</h2>
    <table class="identity">
        <tr><td class="label">Nama Lengkap</td><td class="sep">:</td><td class="value">{{ $s->nama }}</td></tr>
        <tr><td class="label">Kelas</td><td class="sep">:</td><td class="value">{{ $s->kelas }}</td></tr>
        <tr><td class="label">Tahun Ajaran</td><td class="sep">:</td><td class="value">{{ $tahunAjaranSkrining }}</td></tr>
        <tr><td class="label">Tanggal Skrining</td><td class="sep">:</td><td class="value">{{ $s->created_at->translatedFormat('j F Y') }}</td></tr>
        <tr><td class="label">Hasil SDQ</td><td class="sep">:</td><td class="value">{{ $s->total_kesulitan }}/40 — {{ $s->hasil_label }}</td></tr>
        <tr><td class="label">Analisis AI</td><td class="sep">:</td><td class="value">{{ $analisisAI }}</td></tr>
        <tr><td class="label">Keputusan Akhir</td><td class="sep">:</td><td class="value">{{ $keputusanAkhir }}</td></tr>
    </table>

    {{-- Skor Subskala + Interpretasi --}}
    <h2 class="section-title">Skor SDQ per Subskala &amp; Interpretasi</h2>
    @php
        // Threshold 5/10 — konsisten dengan interpretasi di dashboard Guru BK.
        // Prososial bersifat reverse: skor tinggi justru baik.
        $subskala = [
            [
                'label' => 'Emosional', 'val' => $s->skor_emotional,
                'below' => 'Kondisi emosional relatif stabil — jarang cemas, sedih berlebihan, atau mengeluh sakit tanpa sebab jelas.',
                'above' => 'Terindikasi gejala emosional: mudah cemas, sering sedih/tidak bahagia, khawatir berlebihan, atau keluhan fisik terkait stres.',
            ],
            [
                'label' => 'Masalah Perilaku', 'val' => $s->skor_conduct,
                'below' => 'Mampu mengendalikan diri dengan baik — jarang menunjukkan perilaku menentang atau agresif.',
                'above' => 'Terindikasi masalah perilaku: mudah marah, sering berbohong, melanggar aturan, atau bersikap agresif ke orang lain.',
            ],
            [
                'label' => 'Hiperaktivitas', 'val' => $s->skor_hyperactivity,
                'below' => 'Mampu berkonsentrasi dengan baik dan tidak menunjukkan gejala hiperaktif berlebihan.',
                'above' => 'Terindikasi kesulitan fokus, gelisah, impulsif, atau sulit menyelesaikan tugas hingga tuntas.',
            ],
            [
                'label' => 'Teman Sebaya', 'val' => $s->skor_peer,
                'below' => 'Relasi sosial cenderung baik — memiliki teman dan tidak menunjukkan tanda dikucilkan.',
                'above' => 'Terindikasi kesulitan berteman, cenderung menyendiri, atau sering diganggu/dikucilkan teman sebaya.',
            ],
            [
                'label' => 'Prososial', 'val' => $s->skor_prosocial, 'reverse' => true,
                'below' => 'Terindikasi kurangnya perilaku prososial — jarang menunjukkan empati, berbagi, atau membantu orang lain.',
                'above' => 'Menunjukkan perilaku prososial yang baik — suka menolong, berbagi, dan peduli.',
            ],
        ];
    @endphp
    <table class="subskala">
        <tr>
            <th style="width:110px;">Subskala</th>
            <th class="center" style="width:50px;">Skor</th>
            <th>Interpretasi</th>
        </tr>
        @foreach($subskala as $sk)
        @php
            $isHigh  = $sk['val'] >= 5;
            $catatan = $isHigh ? $sk['above'] : $sk['below'];
        @endphp
        <tr>
            <td>{{ $sk['label'] }}</td>
            <td class="score">{{ $sk['val'] }}/10</td>
            <td class="interp">{{ $catatan }}</td>
        </tr>
        @endforeach
    </table>

    {{-- Probabilitas AI --}}
    <h2 class="section-title">Probabilitas Klasifikasi AI (Gaussian Naive Bayes)</h2>
    <table class="prob">
        <tr>
            <td><div class="prob-label">Normal</div><div class="prob-val">{{ $s->prob_normal ?? 0 }}%</div></td>
            <td><div class="prob-label">Borderline</div><div class="prob-val">{{ $s->prob_borderline ?? 0 }}%</div></td>
            <td><div class="prob-label">High Risk</div><div class="prob-val">{{ $s->prob_high_risk ?? 0 }}%</div></td>
        </tr>
    </table>

    {{-- Laporan Konseling --}}
    <h2 class="section-title">Laporan Konseling</h2>
    <table class="laporan">
        <tr>
            <td class="field-label">Tanggal Laporan</td>
            <td>{{ optional($laporan->tanggal_laporan)->translatedFormat('j F Y') ?? '—' }}</td>
        </tr>
        <tr>
            <td class="field-label">Observasi Guru BK</td>
            <td><div class="rich-text">{!! $rich($laporan->observasi) !!}</div></td>
        </tr>
        <tr>
            <td class="field-label">Rekomendasi Guru BK</td>
            <td><div class="rich-text">{!! $rich($laporan->rekomendasi) !!}</div></td>
        </tr>
    </table>

    {{-- Ruang tanda tangan (tanda tangan digambar controller di dasar halaman terakhir) --}}
    <div class="signature-space"></div>

    <div class="footer-doc">
        © {{ now()->year }} SMP Negeri 216 Jakarta — Portal Skrining Kesehatan Mental Siswa. Dicetak {{ now()->translatedFormat('j F Y, H:i') }}.
        <div class="confidential">Dokumen Rahasia — Hanya untuk Keperluan Internal Bimbingan &amp; Konseling</div>
    </div>

</body>
</html>