<!DOCTYPE html>
<html lang="id">
<head>
    <title>Detail Skrining | {{ $s->nama }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ \App\Models\Pengaturan::url('logo', 'logo-smpn216.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,500;8..60,600;8..60,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #0F2747; --brand: #1D5FBF; --brand-soft: #E8F0FB; --bg: #F3F5F9;
            --ink: #14233B; --ink-2: #475569; --ink-3: #6B7A90; --line: #E3E8F0;
            /* Warna status: hijau = Normal, kuning = Borderline, merah = Abnormal */
            --ok: #0F8A5F;   --ok-bg: #E3F5ED;
            --warn: #B7690B; --warn-bg: #FDF1DC;
            --act: #C8303C;  --act-bg: #FDECEE;
            --ai: #0A78B5;   --ai-bg: #E2F2FA;
        }
        body { color: var(--ink);
            background: radial-gradient(900px 400px at 85% -80px, #DCE8FA 0%, transparent 70%), var(--bg); background-attachment: fixed; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        :focus-visible { outline: 2px solid var(--brand); outline-offset: 2px; }
        .scrollbar-thin::-webkit-scrollbar { width: 6px; height: 6px; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 99px; }

        /* Komponen */
        .card { background: #fff; border: 1px solid var(--line); border-radius: 14px; box-shadow: 0 1px 2px rgba(15,39,71,.05), 0 8px 24px -16px rgba(15,39,71,.18); }
        .ico { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: var(--brand-soft); color: var(--brand); }
        .h-title { font-weight: 600; color: var(--ink); }
        .h-sub { color: var(--ink-3); margin-top: 2px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 999px; font-weight: 700; white-space: nowrap; }
        .b-ok { background: var(--ok-bg); color: var(--ok); }
        .b-warn { background: var(--warn-bg); color: var(--warn); }
        .b-act { background: var(--act-bg); color: var(--act); }
        .b-ai { background: var(--ai-bg); color: var(--ai); }
        .b-none { background: #E8ECF2; color: var(--ink-2); }
        .btn-line { display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px; border: 1px solid var(--line); background: #fff; font-weight: 600; color: var(--brand); transition: .15s; }
        .btn-line:hover { background: var(--brand-soft); border-color: #B9D0F2; }
        .btn-primary { display: inline-flex; align-items: center; gap: 8px; padding: 9px 16px; background: var(--brand); color: #fff; font-weight: 600; transition: .15s; box-shadow: 0 6px 14px -8px var(--brand); }
        .btn-primary:hover { background: #174C99; }
        .btn-ghost { display: inline-flex; align-items: center; gap: 8px; padding: 9px 16px; background: #fff; border: 1px solid var(--line); color: var(--ink-2); font-weight: 600; transition: .15s; }
        .btn-ghost:hover { background: var(--brand-soft); color: var(--brand); }
        .animate-bar { transition: width 1s cubic-bezier(.4,0,.2,1); }

        /* Banner utama */
        .hero { position: relative; overflow: hidden; border-radius: 20px; padding: 28px; color: #fff;
            background: linear-gradient(120deg, #0B1F3A 0%, #15407F 55%, #2B78E0 100%); box-shadow: 0 18px 40px -18px rgba(21,64,127,.65); }
        .hero-ring { position: absolute; border-radius: 50%; border: 1px solid rgba(255,255,255,.14); pointer-events: none; }
        .hero-ring.r1 { width: 380px; height: 380px; right: -90px; top: -150px; background: radial-gradient(circle, rgba(255,255,255,.12), transparent 70%); }
        .hero-ring.r2 { width: 230px; height: 230px; right: 190px; bottom: -130px; }

        @media (prefers-reduced-motion: reduce) { .animate-bar { transition: none !important; } }
        @media print {
            header, form, nav, .no-print { display: none !important; }
            body { background: #fff; }
            .card { box-shadow: none; }
        }
    </style>
    <style>
        .gauge-ring { transition: stroke-dasharray 1.1s cubic-bezier(.4,0,.2,1); }
        .badge-lg { padding: 5px 14px; }
        .meta { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: var(--r-field); background: rgba(255,255,255,.14); border: 1px solid rgba(255,255,255,.22); font-size: .75rem; line-height: 1.2; }
        .meta a { color: inherit; transition: color .15s; }
        .meta a:hover { color: #86EFAC; }
        .meta-empty { opacity: .8; font-style: italic; }
        .meta-btn { display: inline-flex; align-items: center; justify-content: center; width: 22px; height: 22px; margin: -2px -6px -2px 2px; border-radius: 7px; color: #DCE8FA; background: transparent; border: 0; cursor: pointer; transition: background .15s, color .15s; }
        .meta-btn:hover { background: rgba(255,255,255,.22); color: #fff; }
        .telp-form { margin-top: 12px; padding: 12px; border-radius: 12px; background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2); max-width: 460px; }
        .telp-input { flex: 1; min-width: 0; height: 38px; padding: 0 12px; border-radius: var(--r-field); border: 1px solid transparent; background: #fff; color: var(--ink); font-size: 13.5px; font-family: inherit; }
        .telp-input:focus { outline: none; border-color: #8FBBFA; box-shadow: 0 0 0 3px rgba(143,187,250,.35); }
        .telp-save { display: inline-flex; align-items: center; gap: 6px; height: 38px; padding: 0 14px; border-radius: var(--r-sm); background: #fff; color: var(--navy); font-size: 13px; font-weight: 700; border: 0; cursor: pointer; transition: background .15s; }
        .telp-save:hover { background: var(--brand-soft); }
        .telp-cancel { height: 38px; padding: 0 12px; border-radius: var(--r-sm); background: transparent; color: #DCE8FA; font-size: 13px; font-weight: 600; border: 1px solid rgba(255,255,255,.3); cursor: pointer; transition: background .15s; }
        .telp-cancel:hover { background: rgba(255,255,255,.14); }

        /* Skor SDQ per subskala (kartu polos) */
        .sub { border: 1px solid var(--line); border-radius: 12px; padding: 14px; transition: border-color .15s; }
        .sub:hover { border-color: #B9D0F2; }
        .sub-track { position: relative; height: 8px; border-radius: 999px; background: #EEF1F6; }
        .sub-fill { height: 100%; border-radius: 999px; }
        .sub-tick { position: absolute; top: 50%; width: 2px; height: 14px; border-radius: 99px; transform: translate(-50%, -50%); box-shadow: 0 0 0 1px #fff; }

        /* Analisis AI */
        .ai-tile { padding: 14px 16px; border-radius: 12px; background: #F7F9FC; border: 1px solid var(--line); }
        .ai-tile .lbl { font-size: 12px; font-weight: 600; color: var(--ink-3); margin-bottom: 8px; }
        .ai-tile .hint { display: block; margin-top: 8px; font-size: 11.5px; line-height: 1.45; color: #94A3B8; }
        .prow { padding: 12px 14px; border-radius: 12px; border: 1px solid var(--line); background: #fff; }
        .prow.top { border-color: var(--bd); background: var(--cbg); }
        .ptrack { height: 6px; border-radius: 999px; background: #EEF1F6; overflow: hidden; margin-top: 10px; }
        .prow.top .ptrack { background: rgba(255,255,255,.75); }
        .ptrack > i { display: block; height: 100%; border-radius: 999px; background: var(--bar); }
        .ptag { display: inline-block; padding: 2px 8px; border-radius: 999px; font-size: 11px; font-weight: 700; background: #fff; border: 1px solid var(--bd); color: var(--c); }
        .pval { font-size: 14px; font-weight: 700; white-space: nowrap; font-variant-numeric: tabular-nums; }

        /* Perkembangan siswa */
        .tchip { display: inline-flex; align-items: center; gap: 4px; padding: 3px 9px 3px 6px; border-radius: 999px; font-size: 12px; font-weight: 700; white-space: nowrap; }
        .tchip .material-symbols-outlined { font-size: 15px; }
        .t-baik { background: var(--ok-bg); color: var(--ok); }
        .t-sama { background: #EEF1F6; color: var(--ink-2); }
        .t-buruk { background: var(--warn-bg); color: var(--warn); }
        .chart-wrap { overflow-x: auto; }
        .chart-line { stroke-dasharray: 1; stroke-dashoffset: 1; animation: draw 1.3s .15s ease forwards; }
        @keyframes draw { to { stroke-dashoffset: 0; } }
        .mx { width: 100%; min-width: 480px; border-collapse: separate; border-spacing: 6px; }
        .mx th { font-size: 12px; font-weight: 600; color: var(--ink-3); text-align: center; padding-bottom: 2px; white-space: nowrap; }
        .mx th.cur { color: var(--brand); }
        .mx td.rowh { font-size: 13.5px; font-weight: 600; color: var(--ink); white-space: nowrap; padding-right: 8px; }
        .cell { display: flex; align-items: center; justify-content: center; height: 36px; border-radius: 10px; font-size: .82rem; font-weight: 800; }
        .cell.ok { background: var(--ok-bg); color: var(--ok); }
        .cell.warn { background: var(--warn-bg); color: var(--warn); }
        .cell.act { background: var(--act-bg); color: var(--act); }
        /* Pengisian berikutnya */
        .remind { padding: 18px 20px; display: flex; flex-direction: column; gap: 14px; }
        @media (min-width: 768px) { .remind { flex-direction: row; align-items: center; justify-content: space-between; } }
        .remind.due { border-color: #9DBDEB; background: linear-gradient(135deg, #F4F8FE 0%, #EAF2FD 100%); box-shadow: 0 0 0 3px rgba(29,95,191,.08), 0 12px 28px -16px rgba(29,95,191,.4); }
        .remind.due .ico { background: var(--brand); color: #fff; }
        .rbar { height: 8px; border-radius: 999px; background: #E7ECF4; overflow: hidden; }
        .rbar > i { display: block; height: 100%; border-radius: 999px; background: linear-gradient(90deg, #5B9DF5, var(--brand)); transition: width 1s cubic-bezier(.4,0,.2,1); }
        /* Riwayat (timeline) */
        .timeline { position: relative; list-style: none; margin: 0; padding: 0 0 0 26px; }
        .timeline::before { content: ''; position: absolute; left: 7px; top: 14px; bottom: 14px; width: 2px; background: var(--line); border-radius: 2px; }
        .tl-item { position: relative; margin-bottom: 12px; }
        .tl-item:last-child { margin-bottom: 0; }
        .tl-item::before { content: ''; position: absolute; left: -26px; top: 22px; width: 16px; height: 16px; border-radius: 50%; background: var(--dot, #94A3B8); border: 3px solid #fff; box-shadow: 0 0 0 1.5px var(--dot, #94A3B8); }
        .tl-card { padding: 14px 16px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; transition: border-color .15s, box-shadow .15s; }
        .tl-item.current .tl-card { border-color: #9DBDEB; background: #F8FBFF; box-shadow: 0 0 0 3px rgba(29,95,191,.08), 0 8px 24px -16px rgba(15,39,71,.18); }
        .tl-item.current::before { box-shadow: 0 0 0 1.5px var(--dot, #94A3B8), 0 0 0 5px rgba(29,95,191,.14); }
        .tl-card > .btn-line { margin-left: auto; }
        .hist-extra { display: none; }
        .hist-open .hist-extra { display: block; }
        .dotk { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 6px; }
        @media (prefers-reduced-motion: reduce) { .chart-line { animation: none !important; stroke-dashoffset: 0; } }
        @media (prefers-reduced-motion: reduce) { .gauge-ring { transition: none !important; } }

        /* ===== Perapian tampilan mobile ===== */
        @media (max-width: 639px) {
            .hero { padding: 22px 18px; border-radius: 16px; }
            .hero-ring.r1 { width: 260px; height: 260px; right: -100px; top: -110px; }
            .hero-ring.r2 { display: none; }
            .card { border-radius: 12px; }
            .meta { font-size: .72rem; padding: 5px 10px; }
            .telp-form { max-width: none; }
            .telp-input { flex: 1 1 100%; }
            .sub { padding: 12px; }
            .remind { padding: 16px; }
            .tl-card { padding: 12px 14px; gap: 10px; }
            .tl-card > .btn-line { width: 100%; justify-content: center; margin-left: 0; }
            .prow { padding: 11px 12px; }
            .ai-tile { padding: 12px 14px; }
            .pval { font-size: 13.5px; }
        }
    </style>

    @vite('resources/css/tema.css')
    <link rel="stylesheet" href="{{ asset('css/icons.css') }}">
    <script src="{{ asset('js/icons.js') }}" defer></script>
</head>
<body class="flex min-h-screen">

@php
    $isRisikoAI     = ($s->risiko_ai ?? '') === 'YES';
    $isNormalTapiAI = $isRisikoAI && $s->hasil_label === 'Normal';
    $keputusan      = $s->keputusan_akhir ?? $s->hasil_label;
    $nis            = $s->user?->nis ?: '-';

    // Nomor HP siswa + tautan WhatsApp (0812... -> 62812...)
    $noTelp  = $s->user?->no_telp;
    $nomorWa = null;
    if ($noTelp) {
        $nomorWa = preg_replace('/\D+/', '', $noTelp);
        if (str_starts_with($nomorWa, '0')) {
            $nomorWa = '62' . substr($nomorWa, 1);
        }
    }
    $formTelpTerbuka = $errors->has('no_telp');

    // Tanggal berbahasa Indonesia, zona WIB
    $tgl = $s->created_at->copy()->timezone('Asia/Jakarta')->locale('id');

    $sdqBadge = match($s->hasil_label) { 'Normal' => 'b-ok', 'Borderline' => 'b-warn', 'Abnormal' => 'b-act', default => 'b-none' };
    $nbBadge  = match($s->hasil_naive_bayes ?? '') { 'Normal' => 'b-ok', 'Borderline' => 'b-warn', 'High Risk' => 'b-act', default => 'b-none' };
    $kaBadge  = match($s->keputusan_akhir ?? '') { 'Normal' => 'b-ok', 'Borderline' => 'b-warn', 'High Risk', 'Abnormal' => 'b-act', default => 'b-none' };

    // ms = batas kuning, mt = batas merah (dipakai untuk penanda di batang)
    $subskala = [
        ['label' => 'Emosional', 'val' => $s->skor_emotional, 'max' => 10, 'icon' => 'mood_bad',
         'tinggi' => $s->skor_emotional >= 7, 'sedang' => $s->skor_emotional >= 5, 'ms' => 5, 'mt' => 7, 'rev' => false,
         'arti' => 'Indikasi kecemasan atau depresi — sering merasa sedih, takut, atau cemas berlebihan.'],
        ['label' => 'Perilaku', 'val' => $s->skor_conduct, 'max' => 10, 'icon' => 'warning',
         'tinggi' => $s->skor_conduct >= 5, 'sedang' => $s->skor_conduct >= 3, 'ms' => 3, 'mt' => 5, 'rev' => false,
         'arti' => 'Indikasi masalah perilaku — mudah marah, berbohong, atau perilaku agresif.'],
        ['label' => 'Hiperaktivitas', 'val' => $s->skor_hyperactivity, 'max' => 10, 'icon' => 'bolt',
         'tinggi' => $s->skor_hyperactivity >= 7, 'sedang' => $s->skor_hyperactivity >= 5, 'ms' => 5, 'mt' => 7, 'rev' => false,
         'arti' => 'Indikasi sulit fokus, gelisah, atau bertindak impulsif tanpa berpikir.'],
        ['label' => 'Teman Sebaya', 'val' => $s->skor_peer, 'max' => 10, 'icon' => 'group',
         'tinggi' => $s->skor_peer >= 6, 'sedang' => $s->skor_peer >= 4, 'ms' => 4, 'mt' => 6, 'rev' => false,
         'arti' => 'Indikasi isolasi sosial — kesulitan berteman, tidak disukai, atau di-bully.'],
        ['label' => 'Prososial', 'val' => $s->skor_prosocial, 'max' => 10, 'icon' => 'favorite',
         'tinggi' => $s->skor_prosocial <= 3, 'sedang' => $s->skor_prosocial <= 5, 'ms' => 5, 'mt' => 3, 'rev' => true,
         'arti' => 'Kurang menunjukkan empati, kepedulian, atau perilaku membantu orang lain.'],
    ];

    $probN = (float) ($s->prob_normal ?? 0);
    $probB = (float) ($s->prob_borderline ?? 0);
    $probH = (float) ($s->prob_high_risk ?? 0);
    $probMaks = max($probN, $probB, $probH);
    $probList = [
        ['label' => 'Normal',     'val' => $probN, 'bar' => '#10A674', 'c' => '#0F8A5F', 'cbg' => '#F4FBF8', 'bd' => '#CDEBDD'],
        ['label' => 'Borderline', 'val' => $probB, 'bar' => '#EBA024', 'c' => '#B7690B', 'cbg' => '#FFFAF0', 'bd' => '#F4DFB6'],
        ['label' => 'High Risk',  'val' => $probH, 'bar' => '#DC3A46', 'c' => '#C8303C', 'cbg' => '#FFF6F6', 'bd' => '#F3C9CD'],
    ];

    // Langkah rekomendasi: [warna, teks, label opsional]
    $rekom = [];
    if ($s->tindakan) {
        $rekom[] = ['#1D5FBF', $s->tindakan, 'Rekomendasi sistem:'];
        if ($s->keputusan_akhir === 'High Risk') {
            $rekom[] = ['#C8303C', 'Segera lakukan konseling bimbingan konseling (BK) individual intensif.', null];
            $rekom[] = ['#C8303C', 'Koordinasikan dengan orang tua/wali kelas dan pertimbangkan rujukan ke ahli profesional.', null];
        } elseif ($s->keputusan_akhir === 'Borderline') {
            $rekom[] = ['#B7690B', 'Jadwalkan pemantauan berkala dan konseling preventif ringan.', null];
            $rekom[] = ['#B7690B', 'Koordinasikan dengan guru mata bimbingan konseling untuk perkembangan di kelas.', null];
        } else {
            $rekom[] = ['#0F8A5F', 'Lanjutkan pemantauan berkala bimbingan konseling normal.', null];
        }
    } elseif ($isNormalTapiAI) {
        $rekom[] = ['#0A78B5', 'Lakukan wawancara individual untuk menggali kondisi sebenarnya.', null];
        $rekom[] = ['#0A78B5', 'Libatkan orang tua / wali untuk konfirmasi perilaku siswa di rumah.', null];
        $rekom[] = ['#0A78B5', 'Lakukan skrining ulang dalam 2–4 minggu ke depan.', null];
    } elseif ($s->hasil_label === 'Abnormal') {
        $rekom[] = ['#C8303C', 'Segera lakukan konseling individual intensif.', null];
        $rekom[] = ['#C8303C', 'Koordinasi dengan orang tua dan bila perlu rujuk ke psikolog/psikiater.', null];
        $rekom[] = ['#C8303C', 'Pantau perkembangan siswa secara berkala setiap minggu.', null];
    } elseif ($s->hasil_label === 'Borderline') {
        $rekom[] = ['#B7690B', 'Jadwalkan sesi konseling preventif dalam waktu dekat.', null];
        $rekom[] = ['#B7690B', 'Monitor perkembangan siswa dan lakukan skrining ulang dalam 1 bulan.', null];
    } else {
        $rekom[] = ['#0F8A5F', 'Siswa dalam kondisi normal. Lanjutkan pemantauan rutin.', null];
        $rekom[] = ['#0F8A5F', 'Jadwalkan skrining berikutnya sesuai jadwal reguler sekolah.', null];
    }

    // Ringkasan singkat dengan bahasa awam, sesuai kondisi
    if ($isNormalTapiAI) {
        $ringkas = [
            'icon' => 'psychology',
            'judul' => 'Hasil SDQ normal, namun AI mendeteksi pola yang perlu dicermati',
            'isi' => 'Total skor baku masih aman, tetapi kombinasi skor subskala terbaca berisiko oleh model AI. Disarankan wawancara lanjutan.',
            'box' => 'bg-[#E2F2FA] border-[#B7DDF0]',
            'ink' => 'text-[#075985]',
            'ico' => 'text-[#0A78B5]',
        ];
    } elseif (in_array($keputusan, ['High Risk', 'Abnormal'], true)) {
        $ringkas = [
            'icon' => 'priority_high',
            'judul' => 'Siswa memerlukan perhatian segera',
            'isi' => 'Hasil menunjukkan tingkat kesulitan yang tinggi. Disarankan konseling individual dan koordinasi dengan orang tua/wali.',
            'box' => 'bg-[#FDECEE] border-[#F3C9CD]',
            'ink' => 'text-[#9B1C28]',
            'ico' => 'text-[#C8303C]',
        ];
    } elseif ($keputusan === 'Borderline') {
        $ringkas = [
            'icon' => 'visibility',
            'judul' => 'Siswa perlu dipantau',
            'isi' => 'Hasil berada di batas waspada. Disarankan konseling preventif dan pemantauan berkala.',
            'box' => 'bg-[#FDF1DC] border-[#F4DFB6]',
            'ink' => 'text-[#8A4F08]',
            'ico' => 'text-[#B7690B]',
        ];
    } else {
        $ringkas = [
            'icon' => 'check_circle',
            'judul' => 'Kondisi siswa baik',
            'isi' => 'Tidak ditemukan tanda kesulitan yang menonjol. Lanjutkan pemantauan rutin.',
            'box' => 'bg-[#E3F5ED] border-[#BFE6D4]',
            'ink' => 'text-[#0B6B49]',
            'ico' => 'text-[#0F8A5F]',
        ];
    }

    // Gauge skor total (lingkaran), warna terang agar terbaca di latar biru tua
    $totalSkor  = (int) $s->total_kesulitan;
    $circ       = 2 * M_PI * 42;
    $dash       = $circ * min(40, max(0, $totalSkor)) / 40;
    $gaugeColor = '#CBD5E1';

    if ($s->hasil_label === 'Normal') {
        $gaugeColor = '#34D399';
    } elseif ($s->hasil_label === 'Borderline') {
        $gaugeColor = '#FBBF24';
    } elseif ($s->hasil_label === 'Abnormal') {
        $gaugeColor = '#FCA5A5';
    }

    // ---- Perkembangan siswa (riwayat pengisian) ----
    // Butuh $riwayatSiswa dari controller (semua hasil siswa ini, termasuk yang sedang dibuka)
    $adaRiwayat = isset($riwayatSiswa);
    $rw = collect($riwayatSiswa ?? [])->sortByDesc('created_at')->values();

    $namaAspek = ['skor_emotional' => 'Emosional', 'skor_conduct' => 'Perilaku', 'skor_hyperactivity' => 'Hiperaktivitas', 'skor_peer' => 'Teman sebaya', 'skor_prosocial' => 'Prososial'];
    // Tingkat per subskala: ok / warn / act (batas sama dengan kartu subskala di atas)
    $levelSkor = function ($key, $v) {
        [$sedang, $tinggi, $rev] = [
            'skor_emotional' => [5, 7, false], 'skor_conduct' => [3, 5, false], 'skor_hyperactivity' => [5, 7, false],
            'skor_peer' => [4, 6, false], 'skor_prosocial' => [5, 3, true],
        ][$key];
        return $rev ? ($v <= $tinggi ? 'act' : ($v <= $sedang ? 'warn' : 'ok')) : ($v >= $tinggi ? 'act' : ($v >= $sedang ? 'warn' : 'ok'));
    };
    // Skor kesulitan: turun = lebih baik. Selisih kurang dari 2 poin dianggap relatif sama.
    $tren = function ($now, $before) {
        $d = (int) $now->total_kesulitan - (int) $before->total_kesulitan;
        return $d <= -2 ? 'baik' : ($d >= 2 ? 'buruk' : 'sama');
    };
    $trenChip = [
        'baik'  => ['t-baik',  'trending_down', 'Skor turun (lebih baik)'],
        'sama'  => ['t-sama',  'trending_flat', 'Relatif sama'],
        'buruk' => ['t-buruk', 'trending_up',   'Skor naik (perlu perhatian)'],
    ];
    $badgeHasil = function ($v) {
        return match ($v ?? '') {
            'Normal' => 'b-ok',
            'Borderline' => 'b-warn',
            'Abnormal' => 'b-act',
            'High Risk' => 'b-act',
            default => 'b-none',
        };
    };

    $idxRw = $rw->search(fn ($r) => $r->id === $s->id);
    $prevRw = ($idxRw !== false) ? $rw->get($idxRw + 1) : null;
    $ringTren = null;
    if ($prevRw) {
        $rank = ['ok' => 0, 'warn' => 1, 'act' => 2];
        $naik = []; $turun = [];
        foreach ($namaAspek as $key => $nm) {
            $a = $rank[$levelSkor($key, (int) $s->{$key})]; $b = $rank[$levelSkor($key, (int) $prevRw->{$key})];
            if ($a > $b) $naik[] = $nm; elseif ($a < $b) $turun[] = $nm;
        }
        $ringTren = ['k' => $tren($s, $prevRw), 'd' => (int) $s->total_kesulitan - (int) $prevRw->total_kesulitan, 'naik' => $naik, 'turun' => $turun,
                     'tgl' => $prevRw->created_at->copy()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('j F Y'), 'sblm' => (int) $prevRw->total_kesulitan];
    }

    // Grafik total skor
    $seri = $rw->take(8)->reverse()->values(); $nSeri = $seri->count();
    $cw = 640; $chh = 230; $pl = 42; $pr = 26; $pt = 26; $pb = 46; $pw = $cw - $pl - $pr; $ph = $chh - $pt - $pb;
    $warnaTitik = ['Normal' => '#16A47A', 'Borderline' => '#E39A25', 'Abnormal' => '#DC3A46'];
    $titik = [];
    foreach ($seri as $i => $r) {
        $x = $nSeri > 1 ? $pl + $i * $pw / ($nSeri - 1) : $pl + $pw / 2;
        $y = $pt + $ph * (1 - min(40, max(0, (int) $r->total_kesulitan)) / 40);
        $tg = $r->created_at->copy()->timezone('Asia/Jakarta')->locale('id');
        $titik[] = ['x' => round($x, 1), 'y' => round($y, 1), 'total' => (int) $r->total_kesulitan, 'warna' => $warnaTitik[$r->hasil_label] ?? '#94A3B8',
                    'tgl' => $tg->translatedFormat('j M'), 'thn' => $tg->format('Y'), 'dipilih' => $r->id === $s->id];
    }
    $garis = $nSeri ? 'M' . implode(' L', array_map(fn ($t) => $t['x'] . ' ' . $t['y'], $titik)) : '';
    $area  = $nSeri > 1 ? $garis . ' L' . end($titik)['x'] . ' ' . ($pt + $ph) . ' L' . $titik[0]['x'] . ' ' . ($pt + $ph) . ' Z' : '';
    $kolom = $rw->take(5)->reverse()->values();

    // ---- Pengisian berikutnya (dihitung dari pengisian TERBARU siswa) ----
    $tampilAwal   = 4;    // jumlah riwayat yang langsung tampil
    $intervalHari = 90;   // saran jarak antar pengisian (hari), samakan dengan dashboard siswa
    $sekarang     = now('Asia/Jakarta')->locale('id');
    $terbaruSiswa = $rw->first() ?? $s;
    $tglTerbaru   = $terbaruSiswa->created_at->copy()->timezone('Asia/Jakarta')->locale('id');
    $hariSejak    = (int) floor($sekarang->copy()->startOfDay()->diffInDays($tglTerbaru->copy()->startOfDay(), true));
    $sisaHari     = $intervalHari - $hariSejak;
    $infoUlang    = [
        'tgl'        => $tglTerbaru->translatedFormat('j F Y'),
        'lalu'       => $hariSejak === 0 ? 'hari ini' : $hariSejak . ' hari lalu',
        'sudah'      => $sisaHari <= 0,
        'sisa'       => max(0, $sisaHari),
        'berikutnya' => $tglTerbaru->copy()->addDays($intervalHari)->translatedFormat('j F Y'),
        'persen'     => min(100, round($hariSejak / $intervalHari * 100)),
    ];
@endphp

@include('partials.sidebar_dashboard_gurubk')

<main class="flex-1 min-w-0 flex flex-col">

    <header class="h-16 bg-white/90 backdrop-blur-md border-b border-[#E3E8F0] flex items-center justify-between px-4 md:px-8 sticky top-0 z-30">
        <div class="flex items-center gap-3 min-w-0">
            <button id="hamburger-btn" onclick="openSidebar()" aria-label="Buka menu"
                class="w-9 h-9 border border-[#E3E8F0] flex items-center justify-center hover:bg-[#E8F0FB] transition-colors lg:hidden flex-shrink-0">
                <span class="material-symbols-outlined text-[#475569]" style="font-size:20px">menu</span>
            </button>
            <a href="/riwayat" title="Kembali ke riwayat" aria-label="Kembali" class="w-9 h-9 border border-[#E3E8F0] flex items-center justify-center hover:bg-[#E8F0FB] transition-colors flex-shrink-0">
                <span class="material-symbols-outlined text-[#475569]" style="font-size:20px">arrow_back</span>
            </a>
            <div class="truncate">
                <p class="text-xs text-[#6B7A90] truncate">
                    <a href="/riwayat" class="hover:text-[#1D5FBF] transition-colors">Riwayat Skrining</a>
                    <span class="mx-1">/</span>
                    <span class="text-[#14233B] font-medium">Detail</span>
                </p>
                <h2 class="text-base md:text-lg font-bold text-[#14233B] truncate leading-tight">{{ $s->nama }}</h2>
            </div>
        </div>
        <a href="/riwayat/{{ $s->id }}/laporan" class="btn-primary flex-shrink-0 ml-2 no-print">
            <span class="material-symbols-outlined" style="font-size:18px">description</span>
            <span class="hidden sm:inline">Buat Laporan</span>
        </a>
    </header>

    <div class="flex-1 p-4 md:p-8 space-y-5 md:space-y-6 max-w-6xl w-full mx-auto">

        {{-- Pesan sukses / gagal setelah ubah nomor HP --}}
        @if(session('success'))
        <div class="bg-[#E3F5ED] border border-[#BFE6D4] text-[#0B6B49] text-sm font-medium px-4 py-3 rounded-xl flex items-center gap-2 no-print" role="status">
            <span class="material-symbols-outlined" style="font-size:20px">check_circle</span>
            {{ session('success') }}
        </div>
        @endif
        @if($errors->has('no_telp'))
        <div class="bg-[#FDF1DC] border border-[#F4DFB6] text-[#8A4F08] text-sm font-medium px-4 py-3 rounded-xl flex items-center gap-2 no-print" role="alert">
            <span class="material-symbols-outlined" style="font-size:20px">error</span>
            {{ $errors->first('no_telp') }}
        </div>
        @endif

        {{-- ============ Banner: identitas + skor total ============ --}}
        <section class="hero">
            <div class="hero-ring r1"></div><div class="hero-ring r2"></div>
            <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">

                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-white/15 border border-white/25 flex items-center justify-center font-bold text-xl md:text-2xl flex-shrink-0">
                            {{ strtoupper(substr($s->nama, 0, 2)) }}
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-2xl md:text-3xl font-extrabold truncate leading-tight">{{ $s->nama }}</h3>
                        </div>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-2">
                        <span class="meta"><span class="material-symbols-outlined" style="font-size:16px">school</span>Kelas {{ $s->kelas }}</span>
                        <span class="meta"><span class="material-symbols-outlined" style="font-size:16px">badge</span>NIS {{ $nis }}</span>
                        <span class="meta"><span class="material-symbols-outlined" style="font-size:16px">calendar_month</span>{{ $tgl->translatedFormat('j F Y') }}</span>
                        <span class="meta"><span class="material-symbols-outlined" style="font-size:16px">schedule</span>{{ $tgl->format('H.i') }} WIB · {{ $tgl->diffForHumans() }}</span>

                        @if($s->user)
                        <span class="meta" id="telp-view">
                            <span class="material-symbols-outlined" style="font-size:16px">phone</span>
                            @if($nomorWa)
                                <a href="https://wa.me/{{ $nomorWa }}" target="_blank" rel="noopener noreferrer" title="Buka WhatsApp">{{ $noTelp }}</a>
                            @else
                                <span class="meta-empty">Belum ada no. HP</span>
                            @endif
                            <button type="button" id="telp-edit-btn" class="meta-btn no-print" aria-label="Ubah nomor HP siswa" title="Ubah nomor HP" aria-expanded="{{ $formTelpTerbuka ? 'true' : 'false' }}" aria-controls="telp-form">
                                <span class="material-symbols-outlined" style="font-size:14px">edit</span>
                            </button>
                        </span>
                        @endif
                    </div>

                    @if($s->user)
                    <form id="telp-form" method="POST" action="/riwayat/{{ $s->id }}/no-telp" class="telp-form no-print {{ $formTelpTerbuka ? '' : 'hidden' }}">
                        @csrf
                        @method('PATCH')
                        <label for="no_telp" class="block text-xs font-semibold mb-2">Nomor HP siswa</label>
                        <div class="flex flex-wrap gap-2">
                            <input type="tel" inputmode="tel" id="no_telp" name="no_telp" class="telp-input" value="{{ old('no_telp', $noTelp) }}"
                                   placeholder="Contoh: 081234567890" maxlength="20" autocomplete="off">
                            <button type="submit" class="telp-save">
                                <span class="material-symbols-outlined" style="font-size:16px">check</span>Simpan
                            </button>
                            <button type="button" id="telp-cancel" class="telp-cancel">Batal</button>
                        </div>
                        <p class="text-[11px] mt-2" style="color:#C9DBF5">Perubahan berlaku untuk semua riwayat siswa ini. Kosongkan untuk menghapus nomor.</p>
                    </form>
                    @endif
                </div>

                {{-- Gauge skor total --}}
                <div class="flex items-center gap-4 md:flex-col md:gap-2 flex-shrink-0">
                    <div class="relative w-28 h-28">
                        <svg viewBox="0 0 100 100" class="w-full h-full -rotate-90" role="img" aria-label="Total skor kesulitan {{ $totalSkor }} dari 40">
                            <circle cx="50" cy="50" r="42" fill="none" stroke="rgba(255,255,255,.2)" stroke-width="9"/>
                            <circle cx="50" cy="50" r="42" fill="none" stroke="{{ $gaugeColor }}" stroke-width="9"
                                    stroke-linecap="round" class="gauge-ring" data-gauge
                                    stroke-dasharray="{{ round($dash, 2) }} {{ round($circ, 2) }}"/>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-3xl font-extrabold leading-none">{{ $totalSkor }}</span>
                            <span class="text-[11px] text-blue-100 mt-0.5">dari 40</span>
                        </div>
                    </div>
                    <div class="md:text-center">
                        <p class="text-xs text-blue-100">Total skor kesulitan</p>
                        <span class="badge {{ $sdqBadge }} mt-1" style="background:#fff">SDQ: {{ $s->hasil_label }}</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ============ Ringkasan bahasa awam ============ --}}
        <div class="rounded-2xl p-4 md:p-5 flex gap-3 border {{ $ringkas['box'] }}" role="status">
            <span class="material-symbols-outlined mt-0.5 flex-shrink-0 {{ $ringkas['ico'] }}" style="font-size:24px;font-variation-settings:'FILL' 1">{{ $ringkas['icon'] }}</span>
            <div>
                <p class="text-sm font-bold {{ $ringkas['ink'] }}">{{ $ringkas['judul'] }}</p>
                <p class="text-xs md:text-sm mt-1 leading-relaxed {{ $ringkas['ink'] }} opacity-90">{{ $ringkas['isi'] }}</p>
            </div>
        </div>

        {{-- ============ Tiga hasil utama ============ --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4">
            <div class="card p-4 md:p-5">
                <div class="flex items-center gap-2.5 text-[#6B7A90] text-xs font-semibold mb-3">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:19px">fact_check</span></span>
                    Hasil SDQ
                </div>
                <span class="badge badge-lg {{ $sdqBadge }}">{{ $s->hasil_label }}</span>
                <p class="text-[11.5px] text-[#94A3B8] mt-2.5">Berdasarkan total skor baku</p>
            </div>

            <div class="card p-4 md:p-5">
                <div class="flex items-center gap-2.5 text-[#6B7A90] text-xs font-semibold mb-3">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:19px">psychology</span></span>
                    Prediksi AI
                </div>
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="badge badge-lg {{ $nbBadge }}">{{ $s->hasil_naive_bayes ?? '-' }}</span>
                    @if($isRisikoAI)
                        <span class="badge b-ai">Berisiko</span>
                    @elseif(($s->risiko_ai ?? '') === 'NO')
                        <span class="badge b-ok">Aman</span>
                    @endif
                </div>
                <p class="text-[11.5px] text-[#94A3B8] mt-2.5">Gaussian Naive Bayes</p>
            </div>

            <div class="card p-4 md:p-5" style="border-color:#B9D0F2;box-shadow:0 0 0 3px rgba(29,95,191,.08)">
                <div class="flex items-center gap-2.5 text-[#6B7A90] text-xs font-semibold mb-3">
                    <span class="ico" style="background:var(--brand);color:#fff"><span class="material-symbols-outlined" style="font-size:19px">flag</span></span>
                    Keputusan akhir
                </div>
                <span class="badge badge-lg {{ $kaBadge }}">{{ $keputusan }}</span>
                <p class="text-[11.5px] text-[#94A3B8] mt-2.5">Gabungan SDQ dan AI (salah satu berisiko)</p>
            </div>
        </div>

        {{-- ============ Subskala (lebar penuh) ============ --}}
        <section class="card p-4 sm:p-5 md:p-6">
            <div class="flex items-center justify-between gap-3 mb-5">
                <div class="flex items-center gap-3">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">bar_chart</span></span>
                    <h4 class="h-title">Skor SDQ per Subskala</h4>
                </div>
                <span class="text-xs text-[#6B7A90] whitespace-nowrap">Total <strong class="text-[#14233B]">{{ $s->total_kesulitan }}/40</strong></span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($subskala as $sk)
                @php
                    $persen  = ($sk['val'] / $sk['max']) * 100;
                    $fillBg  = $sk['tinggi'] ? 'bg-[#DC3A46]' : ($sk['sedang'] ? 'bg-[#EBA024]' : 'bg-[#10A674]');
                    $textCol = $sk['tinggi'] ? 'text-[#C8303C]' : ($sk['sedang'] ? 'text-[#B7690B]' : 'text-[#0F8A5F]');
                    $level   = $sk['tinggi'] ? ['Perlu perhatian', 'b-act'] : ($sk['sedang'] ? ['Perlu dipantau', 'b-warn'] : ['Aman', 'b-ok']);
                    $op      = $sk['rev'] ? '≤' : '≥';
                @endphp
                <div class="sub {{ $loop->last ? 'md:col-span-2' : '' }}">
                    <div class="flex items-center justify-between gap-3 mb-3">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="ico" style="width:32px;height:32px"><span class="material-symbols-outlined" style="font-size:18px">{{ $sk['icon'] }}</span></span>
                            <p class="text-sm font-semibold text-[#14233B] truncate">{{ $sk['label'] }}</p>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <span class="badge {{ $level[1] }}">{{ $level[0] }}</span>
                            <span class="text-sm font-bold {{ $textCol }}">{{ $sk['val'] }}/{{ $sk['max'] }}</span>
                        </div>
                    </div>

                    <div class="sub-track" role="img" aria-label="{{ $sk['label'] }}: {{ $sk['val'] }} dari {{ $sk['max'] }}. Kuning {{ $op }} {{ $sk['ms'] }}, Merah {{ $op }} {{ $sk['mt'] }}">
                        <div data-bar class="sub-fill animate-bar {{ $fillBg }}" style="width:{{ $persen }}%"></div>
                        <span class="sub-tick" style="left:{{ $sk['ms'] * 10 }}%;background:#EBA024" title="Kuning {{ $op }} {{ $sk['ms'] }}"></span>
                        <span class="sub-tick" style="left:{{ $sk['mt'] * 10 }}%;background:#DC3A46" title="Merah {{ $op }} {{ $sk['mt'] }}"></span>
                    </div>

                    <p class="text-[12px] text-[#6B7A90] mt-2">
                        <span class="text-[#B7690B]">Kuning {{ $op }} {{ $sk['ms'] }}</span>
                        <span class="mx-1 text-[#CBD5E1]">·</span>
                        <span class="text-[#C8303C]">Merah {{ $op }} {{ $sk['mt'] }}</span>
                    </p>

                    @if($sk['sedang'])
                        <p class="text-[11.5px] text-[#6B7A90] mt-2 leading-relaxed">{{ $sk['arti'] }}</p>
                    @endif
                </div>
                @endforeach
            </div>

            <p class="text-[11.5px] text-[#94A3B8] mt-4 pt-4 border-t border-[#E3E8F0] leading-relaxed">
                Garis kuning dan merah di batang adalah batas level. Prososial dibaca terbalik: skor yang rendah yang perlu perhatian.
            </p>
        </section>

        {{-- ============ Analisis AI (lebar penuh) ============ --}}
        <section class="card p-4 sm:p-5 md:p-6">
            <div class="flex items-start gap-3 mb-5">
                <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">analytics</span></span>
                <div>
                    <h4 class="h-title">Analisis AI</h4>
                    <p class="h-sub text-xs">Gaussian Naive Bayes</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 lg:gap-6">
                {{-- Kiri: prediksi dan keputusan akhir --}}
                <div class="lg:col-span-4 grid grid-cols-2 lg:grid-cols-1 gap-3 content-start">
                    <div class="ai-tile">
                        <p class="lbl">Prediksi Naive Bayes</p>
                        <span class="badge {{ $nbBadge }}">{{ $s->hasil_naive_bayes ?? '-' }}</span>
                        <span class="hint">Kelas dengan peluang tertinggi</span>
                    </div>
                    <div class="ai-tile">
                        <p class="lbl">Keputusan akhir</p>
                        <span class="badge {{ $kaBadge }}">{{ $keputusan }}</span>
                        <span class="hint">Berisiko bila SDQ atau AI berisiko</span>
                    </div>
                </div>

                {{-- Kanan: probabilitas tiap kelas --}}
                <div class="lg:col-span-8 lg:pl-6 lg:border-l border-[#E3E8F0]">
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <h5 class="text-xs font-bold text-[#475569]">Probabilitas tiap kelas</h5>
                        <span class="text-[11.5px] text-[#94A3B8]">Total 100%</span>
                    </div>

                    <div class="space-y-2.5">
                        @foreach($probList as $p)
                        @php $top = $probMaks > 0 && $p['val'] == $probMaks; @endphp
                        <div class="prow {{ $top ? 'top' : '' }}" style="--c:{{ $p['c'] }};--cbg:{{ $p['cbg'] }};--bd:{{ $p['bd'] }};--bar:{{ $p['bar'] }}">
                            <div class="flex items-center justify-between gap-2">
                                <span class="flex items-center gap-2 min-w-0">
                                    <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background:{{ $p['bar'] }}"></span>
                                    <span class="text-[13.5px] font-semibold text-[#14233B]">{{ $p['label'] }}</span>
                                    @if($top)<span class="ptag">Prediksi</span>@endif
                                </span>
                                <span class="pval" style="color:{{ $p['c'] }}">{{ number_format($p['val'], 1, ',', '.') }}%</span>
                            </div>
                            <div class="ptrack" role="img" aria-label="{{ $p['label'] }} {{ $p['val'] }}%"><i data-bar style="width:{{ $p['val'] }}%"></i></div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <p class="text-[11.5px] text-[#94A3B8] mt-5 pt-4 border-t border-[#E3E8F0] leading-relaxed">
                Prediksi AI mengikuti kelas dengan probabilitas tertinggi. Keputusan akhir dinyatakan berisiko bila SDQ atau AI menunjukkan risiko.
            </p>
        </section>

        {{-- ============ Pola tersembunyi ============ --}}
        @if($isRisikoAI)
        <section class="card overflow-hidden">
            <div class="px-4 sm:px-5 md:px-6 py-4 border-b border-[#E3E8F0] flex items-center gap-3 bg-[#F7F9FC]">
                <span class="ico" style="background:var(--ai-bg);color:var(--ai)"><span class="material-symbols-outlined" style="font-size:20px">psychology</span></span>
                <div>
                    <h4 class="h-title">Rincian Pola Tersembunyi</h4>
                    <p class="h-sub">Subskala yang menyebabkan AI mendeteksi risiko</p>
                </div>
            </div>
            <div class="p-4 sm:p-5 md:p-6 space-y-3">
                @php $adaSubskalaSignifikan = false; @endphp
                @foreach($subskala as $sk)
                    @continue(!$sk['sedang'])
                    @php $adaSubskalaSignifikan = true; @endphp
                    <div class="flex items-start gap-3 p-4 rounded-xl border {{ $sk['tinggi'] ? 'bg-[#FDECEE] border-[#F3C9CD]' : 'bg-[#FDF1DC] border-[#F4DFB6]' }}">
                        <span class="material-symbols-outlined flex-shrink-0 mt-0.5 {{ $sk['tinggi'] ? 'text-[#C8303C]' : 'text-[#B7690B]' }}" style="font-size:19px;font-variation-settings:'FILL' 1">{{ $sk['icon'] }}</span>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1 gap-2">
                                <p class="text-xs md:text-sm font-bold {{ $sk['tinggi'] ? 'text-[#9B1C28]' : 'text-[#8A4F08]' }}">{{ $sk['label'] }} {{ $sk['tinggi'] ? 'sangat tinggi' : 'cukup tinggi' }}</p>
                                <span class="text-xs md:text-sm font-extrabold flex-shrink-0 {{ $sk['tinggi'] ? 'text-[#C8303C]' : 'text-[#B7690B]' }}">{{ $sk['val'] }}/{{ $sk['max'] }}</span>
                            </div>
                            <p class="text-xs text-[#475569] leading-relaxed">{{ $sk['arti'] }}</p>
                        </div>
                    </div>
                @endforeach

                @if(!$adaSubskalaSignifikan)
                    <div class="flex items-start gap-3 p-4 rounded-xl bg-[#E8F0FB] border border-[#C9DBF5]">
                        <span class="material-symbols-outlined flex-shrink-0 mt-0.5 text-[#1D5FBF]" style="font-size:19px;font-variation-settings:'FILL' 1">psychology</span>
                        <p class="text-xs text-[#334155] leading-relaxed">AI mendeteksi kombinasi skor subskala yang tidak biasa meski tidak ada satu subskala yang menonjol sendiri. Pola gabungan inilah yang ditangkap model, bukan satu subskala tunggal.</p>
                    </div>
                @endif

                @if($isNormalTapiAI)
                <div class="p-4 rounded-xl bg-[#E2F2FA] border border-[#B7DDF0]">
                    <p class="text-xs leading-relaxed text-[#075985]">
                        <span class="font-bold">Kesimpulan:</span> Total skor SDQ <strong>{{ $s->total_kesulitan }}/40</strong> terlihat aman secara baku, namun kombinasi subskala di atas terdeteksi sebagai pola risiko oleh AI. Ini adalah kasus yang akan terlewat bila hanya mengandalkan perhitungan SDQ standar.
                    </p>
                </div>
                @endif
            </div>
        </section>
        @endif

        {{-- ============ Pengisian berikutnya ============ --}}
        <section class="card remind {{ $infoUlang['sudah'] ? 'due' : '' }}" aria-labelledby="judul-ulang">
            <div class="flex items-start gap-3 min-w-0 flex-1">
                <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">{{ $infoUlang['sudah'] ? 'notifications_active' : 'event_repeat' }}</span></span>
                <div class="min-w-0 flex-1">
                    <h4 id="judul-ulang" class="h-title">{{ $infoUlang['sudah'] ? 'Sudah waktunya mengisi ulang' : 'Pengisian berikutnya' }}</h4>
                    <p class="h-sub" style="line-height:1.6">
                        @if($infoUlang['sudah'])
                            Terakhir mengisi pada {{ $infoUlang['tgl'] }} ({{ $infoUlang['lalu'] }}). Siswa belum mengisi ulang sejak itu, pertimbangkan untuk mengingatkannya.
                        @else
                            Terakhir mengisi pada {{ $infoUlang['tgl'] }} ({{ $infoUlang['lalu'] }}). Disarankan mengisi lagi sekitar <strong class="text-[#14233B]">{{ $infoUlang['berikutnya'] }}</strong>, kira-kira {{ $infoUlang['sisa'] }} hari lagi.
                        @endif
                    </p>
                    <div class="mt-3 max-w-md">
                        <div class="rbar" role="img" aria-label="{{ $infoUlang['persen'] }} persen menuju waktu isi ulang"><i data-bar style="width:{{ $infoUlang['persen'] }}%"></i></div>
                        <div class="flex justify-between text-[11px] text-[#6B7A90] mt-1.5">
                            <span>Terakhir mengisi</span><span>{{ $infoUlang['sudah'] ? 'Jatuh tempo' : 'Disarankan isi ulang' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-shrink-0 md:text-right">
                <span class="badge {{ $infoUlang['sudah'] ? 'b-warn' : 'b-ok' }}">{{ $infoUlang['sudah'] ? 'Jatuh tempo' : $infoUlang['sisa'] . ' hari lagi' }}</span>
                <p class="text-xs text-[#6B7A90] mt-1.5">Target: {{ $infoUlang['berikutnya'] }}</p>
            </div>
        </section>

        @if($adaRiwayat)
        {{-- ============ Perkembangan dari waktu ke waktu ============ --}}
        <section aria-labelledby="judul-tren">
            <div class="flex items-start gap-3 mb-4">
                <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">monitoring</span></span>
                <div>
                    <h4 id="judul-tren" class="h-title">Perkembangan dari waktu ke waktu</h4>
                    <p class="h-sub">Total skor kesulitan tiap kali siswa mengisi. Semakin rendah semakin baik.</p>
                </div>
            </div>

            <div class="card p-4 md:p-6">
                @if($rw->count() >= 2)
                    @if($ringTren)
                    @php $kTren = $ringTren['k']; @endphp
                    <div class="flex flex-wrap items-start gap-3 mb-4 p-3.5 rounded-xl {{ ['baik' => 'bg-[#E3F5ED]', 'sama' => 'bg-[#F3F5F9]', 'buruk' => 'bg-[#FDF1DC]'][$kTren] }}">
                        <span class="tchip {{ $trenChip[$kTren][0] }}" style="background:#fff"><span class="material-symbols-outlined">{{ $trenChip[$kTren][1] }}</span>{{ $trenChip[$kTren][2] }}</span>
                        <div class="min-w-0 text-[13px] leading-relaxed text-[#475569]">
                            <p class="font-bold text-sm text-[#14233B]">
                                Total skor {{ $ringTren['d'] === 0 ? 'sama' : ($ringTren['d'] > 0 ? 'naik ' . $ringTren['d'] . ' poin' : 'turun ' . abs($ringTren['d']) . ' poin') }}
                                dibanding pengisian {{ $ringTren['tgl'] }} ({{ $ringTren['sblm'] }} menjadi {{ $totalSkor }})
                            </p>
                            @if(count($ringTren['naik']))<p class="mt-1">Subskala yang memburuk: <strong class="text-[#8A4F08]">{{ implode(', ', $ringTren['naik']) }}</strong></p>@endif
                            @if(count($ringTren['turun']))<p class="mt-0.5">Subskala yang membaik: <strong class="text-[#0B6B49]">{{ implode(', ', $ringTren['turun']) }}</strong></p>@endif
                            @if(!count($ringTren['naik']) && !count($ringTren['turun']))<p class="mt-1">Tingkat tiap subskala tidak berubah.</p>@endif
                        </div>
                    </div>
                    @else
                    <p class="mb-4 text-xs text-[#6B7A90] flex items-center gap-1.5"><span class="material-symbols-outlined" style="font-size:16px">info</span>Ini pengisian pertama siswa, belum ada pembanding sebelumnya.</p>
                    @endif

                    <div class="chart-wrap">
                        <svg viewBox="0 0 {{ $cw }} {{ $chh }}" style="min-width:520px;width:100%;height:auto" role="img" aria-label="Grafik total skor kesulitan dari {{ $nSeri }} pengisian terakhir">
                            <defs>
                                <linearGradient id="areaGrad" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0" stop-color="#1D5FBF" stop-opacity=".18"/><stop offset="1" stop-color="#1D5FBF" stop-opacity="0"/>
                                </linearGradient>
                            </defs>
                            @foreach([0, 10, 20, 30, 40] as $g)
                                @php $gy = round($pt + $ph * (1 - $g / 40), 1); @endphp
                                <line x1="{{ $pl }}" y1="{{ $gy }}" x2="{{ $cw - $pr }}" y2="{{ $gy }}" stroke="#E3E8F0" stroke-width="1" {{ $g === 0 ? '' : 'stroke-dasharray=4,4' }}/>
                                <text x="{{ $pl - 10 }}" y="{{ $gy + 4 }}" text-anchor="end" font-size="11" fill="#6B7A90">{{ $g }}</text>
                            @endforeach
                            <path d="{{ $area }}" fill="url(#areaGrad)"/>
                            <path class="chart-line" pathLength="1" d="{{ $garis }}" fill="none" stroke="#1D5FBF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            @foreach($titik as $t)
                                @if($t['dipilih'])<circle cx="{{ $t['x'] }}" cy="{{ $t['y'] }}" r="13" fill="{{ $t['warna'] }}" opacity=".18"/>@endif
                                <circle cx="{{ $t['x'] }}" cy="{{ $t['y'] }}" r="{{ $t['dipilih'] ? 7 : 5.5 }}" fill="{{ $t['dipilih'] ? $t['warna'] : '#fff' }}" stroke="{{ $t['warna'] }}" stroke-width="3"/>
                                <text x="{{ $t['x'] }}" y="{{ $t['y'] - 14 }}" text-anchor="middle" font-size="12" font-weight="700" fill="#14233B">{{ $t['total'] }}</text>
                                <text x="{{ $t['x'] }}" y="{{ $chh - 22 }}" text-anchor="middle" font-size="11.5" font-weight="600" fill="#475569">{{ $t['tgl'] }}</text>
                                <text x="{{ $t['x'] }}" y="{{ $chh - 8 }}" text-anchor="middle" font-size="10" fill="#6B7A90">{{ $t['thn'] }}</text>
                            @endforeach
                        </svg>
                    </div>
                    <div class="flex flex-wrap gap-x-4 gap-y-1 mt-3 text-xs text-[#475569]">
                        <span><i class="dotk" style="background:#16A47A"></i>Normal</span>
                        <span><i class="dotk" style="background:#E39A25"></i>Borderline</span>
                        <span><i class="dotk" style="background:#DC3A46"></i>Abnormal</span>
                        <span class="text-[#6B7A90]">Titik besar = pengisian yang sedang dibuka</span>
                    </div>
                @else
                    <div class="text-center py-8 px-4">
                        <span class="ico mx-auto mb-3" style="width:52px;height:52px;border-radius:50%"><span class="material-symbols-outlined" style="font-size:26px">show_chart</span></span>
                        <p class="text-sm font-bold text-[#14233B]">Baru satu kali mengisi</p>
                        <p class="text-[13px] leading-relaxed text-[#475569] mt-1 max-w-md mx-auto">Grafik dan perbandingan akan muncul setelah siswa ini mengisi skrining untuk kedua kalinya.</p>
                    </div>
                @endif
            </div>
        </section>

        {{-- ============ Perubahan tiap aspek ============ --}}
        @if($kolom->count() >= 2)
        <section aria-labelledby="judul-banding">
            <div class="flex items-start gap-3 mb-4">
                <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">table_rows</span></span>
                <div>
                    <h4 id="judul-banding" class="h-title">Perubahan tiap aspek</h4>
                    <p class="h-sub">Skor 0 sampai 10 pada {{ $kolom->count() }} pengisian terakhir. Warnanya sama dengan kartu subskala di atas.</p>
                </div>
            </div>
            <div class="card p-4 md:p-5">
                <div class="chart-wrap">
                    <table class="mx" aria-label="Perbandingan skor per aspek">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                @foreach($kolom as $r)
                                    @php $tk = $r->created_at->copy()->timezone('Asia/Jakarta')->locale('id'); @endphp
                                    <th scope="col" class="{{ $r->id === $s->id ? 'cur' : '' }}">{{ $tk->translatedFormat('j M') }}<br><span style="font-weight:500">{{ $tk->format('Y') }}</span></th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($namaAspek as $key => $nm)
                            <tr>
                                <td class="rowh">{{ $nm }}</td>
                                @foreach($kolom as $r)
                                    <td><span class="cell {{ $levelSkor($key, (int) $r->{$key}) }}" title="{{ $nm }}: {{ $r->{$key} }}/10">{{ $r->{$key} }}</span></td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex flex-wrap gap-x-4 gap-y-1 mt-3 text-xs text-[#475569]">
                    <span><i class="dotk" style="background:#0F8A5F"></i>Aman</span>
                    <span><i class="dotk" style="background:#B7690B"></i>Perlu dipantau</span>
                    <span><i class="dotk" style="background:#C8303C"></i>Perlu perhatian</span>
                    <span class="text-[#6B7A90]">Prososial dibaca terbalik. Kolom biru = pengisian yang sedang dibuka.</span>
                </div>
            </div>
        </section>
        @endif

        {{-- ============ Riwayat pengisian ============ --}}
        <section id="riwayat" aria-labelledby="judul-riwayat" class="scroll-mt-20">
            <div class="flex items-start gap-3 mb-4">
                <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">history</span></span>
                <div>
                    <h4 id="judul-riwayat" class="h-title">Riwayat pengisian</h4>
                    <p class="h-sub">Siswa sudah mengisi {{ $rw->count() }} kali. Pilih salah satu untuk membuka hasilnya.</p>
                </div>
            </div>

            <ol class="timeline" id="hist-list">
                @foreach($rw as $r)
                    @php
                        $tr = $r->created_at->copy()->timezone('Asia/Jakarta')->locale('id');
                        $lebihLama = $rw->get($loop->index + 1);
                        $tk = $lebihLama ? $tren($r, $lebihLama) : null;
                        $ini = $r->id === $s->id;
                        $riskAi = ($r->risiko_ai ?? '') === 'YES';
                    @endphp
                    <li class="tl-item {{ $ini ? 'current' : '' }} {{ $loop->index >= $tampilAwal ? 'hist-extra' : '' }}" style="--dot:{{ $warnaTitik[$r->hasil_label] ?? '#94A3B8' }}">
                        <div class="card tl-card">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <p class="text-sm font-bold text-[#14233B]">{{ $tr->translatedFormat('j F Y') }}</p>
                                    @if($loop->first)<span class="badge b-none">Terbaru</span>@endif
                                </div>
                                <p class="text-xs text-[#6B7A90] mt-0.5">{{ $tr->format('H.i') }} WIB · {{ $tr->diffForHumans() }}</p>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="badge {{ $badgeHasil($r->hasil_label) }}">SDQ: {{ $r->hasil_label }}</span>
                                @if($riskAi)<span class="badge b-ai">AI: Berisiko</span>@endif
                                <span class="text-xs font-semibold text-[#475569]">Skor {{ $r->total_kesulitan }}/40</span>
                                @if($tk)<span class="tchip {{ $trenChip[$tk][0] }}"><span class="material-symbols-outlined">{{ $trenChip[$tk][1] }}</span>{{ $trenChip[$tk][2] }}</span>
                                @else<span class="tchip t-sama">Pengisian pertama</span>@endif
                            </div>
                            @unless($ini)
                                <a href="/riwayat/{{ $r->id }}" class="btn-line">Lihat detail<span class="material-symbols-outlined" style="font-size:14px">chevron_right</span></a>
                            @endunless
                        </div>
                    </li>
                @endforeach
            </ol>

            @if($rw->count() > $tampilAwal)
            <div class="mt-3 pl-[26px]">
                <button type="button" id="btn-hist" class="btn-ghost" style="padding:7px 14px" aria-expanded="false" aria-controls="hist-list">
                    <span class="material-symbols-outlined" style="font-size:18px" id="btn-hist-ico">expand_more</span>
                    <span id="btn-hist-label">Tampilkan {{ $rw->count() - $tampilAwal }} riwayat lainnya</span>
                </button>
            </div>
            @endif
        </section>
        @endif

        {{-- ============ Rekomendasi ============ --}}
        <section class="card p-4 sm:p-5 md:p-6">
            <div class="flex items-center gap-3 mb-6">
                <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">lightbulb</span></span>
                <h4 class="h-title">Rekomendasi Tindak Lanjut</h4>
            </div>

            <ol class="relative border-l-2 border-[#E3E8F0] ml-3 space-y-5 text-xs md:text-sm text-[#334155]">
                @foreach($rekom as $r)
                <li class="pl-7 relative">
                    <span class="absolute -left-[15px] top-0 w-7 h-7 rounded-full flex items-center justify-center text-[11px] font-bold text-white ring-4 ring-white" style="background:{{ $r[0] }}">{{ $loop->iteration }}</span>
                    <p class="leading-relaxed pt-1">@if($r[2])<strong>{{ $r[2] }}</strong> @endif{{ $r[1] }}</p>
                </li>
                @endforeach
            </ol>

            <div class="mt-7 pt-5 border-t border-[#E3E8F0] flex flex-wrap items-center gap-3 no-print">
                <a href="/riwayat/{{ $s->id }}/laporan" class="btn-primary" style="padding:11px 18px">
                    <span class="material-symbols-outlined" style="font-size:18px">description</span>
                    Buat Laporan
                </a>
                <a href="/riwayat" class="btn-ghost" style="padding:11px 18px">
                    <span class="material-symbols-outlined" style="font-size:18px">arrow_back</span>
                    Kembali ke riwayat
                </a>
            </div>
        </section>

        {{-- Catatan --}}
        <div class="flex items-start gap-3 px-4 py-3.5 rounded-xl bg-white border border-[#E3E8F0] text-xs text-[#6B7A90] leading-relaxed">
            <span class="material-symbols-outlined text-[#94A3B8] flex-shrink-0" style="font-size:18px">info</span>
            <p>Hasil skrining ini bukan diagnosis. Keputusan tindak lanjut tetap berada pada pertimbangan Guru BK setelah berbincang langsung dengan siswa.</p>
        </div>

        <footer class="pt-4 border-t border-[#E3E8F0] flex justify-between items-center flex-wrap gap-2">
            <p class="text-xs text-[#6B7A90]">© 2026 SMPN 216 Jakarta — Portal Skrining Kesehatan Mental Siswa</p>
            <p class="text-xs text-[#6B7A90]">Powered by SDQ + Gaussian Naive Bayes</p>
        </footer>

    </div>
</main>

<script>
    // Animasi isi bar dan gauge saat halaman dibuka (nilai akhir tetap tampil bila JS mati)
    (function () {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        document.querySelectorAll('[data-bar]').forEach(function (el) {
            var w = el.style.width;
            el.style.width = '0';
            requestAnimationFrame(function () {
                requestAnimationFrame(function () { el.style.width = w; });
            });
        });

        document.querySelectorAll('[data-gauge]').forEach(function (el) {
            var d = el.getAttribute('stroke-dasharray');
            var circ = d.split(' ')[1];
            el.setAttribute('stroke-dasharray', '0 ' + circ);
            requestAnimationFrame(function () {
                requestAnimationFrame(function () { el.setAttribute('stroke-dasharray', d); });
            });
        });
    })();

    // Tampilkan / sembunyikan riwayat yang lebih lama
    (function () {
        var btn = document.getElementById('btn-hist'), list = document.getElementById('hist-list');
        if (!btn || !list) return;
        var extra = list.querySelectorAll('.hist-extra').length;
        btn.addEventListener('click', function () {
            var open = list.classList.toggle('hist-open');
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            document.getElementById('btn-hist-ico').textContent = open ? 'expand_less' : 'expand_more';
            document.getElementById('btn-hist-label').textContent = open ? 'Sembunyikan riwayat lama' : 'Tampilkan ' + extra + ' riwayat lainnya';
        });
    })();

    // Ubah nomor HP siswa (form inline di banner)
    (function () {
        var btn = document.getElementById('telp-edit-btn');
        var form = document.getElementById('telp-form');
        var cancel = document.getElementById('telp-cancel');
        var input = document.getElementById('no_telp');
        if (!btn || !form) return;

        function buka(show) {
            form.classList.toggle('hidden', !show);
            btn.setAttribute('aria-expanded', show ? 'true' : 'false');
            if (show && input) { input.focus(); input.select(); }
        }
        btn.addEventListener('click', function () { buka(form.classList.contains('hidden')); });
        if (cancel) cancel.addEventListener('click', function () { buka(false); btn.focus(); });
        form.addEventListener('keydown', function (e) { if (e.key === 'Escape') { buka(false); btn.focus(); } });
    })();
</script>

</body>
</html>