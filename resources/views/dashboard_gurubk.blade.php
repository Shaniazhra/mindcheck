<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Guru BK | SMPN 216 Jakarta</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ \App\Models\Pengaturan::url('logo', 'logo-smpn216.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,500;8..60,600;8..60,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #0F2747; --brand: #1D5FBF; --brand-soft: #E8F0FB; --bg: #F3F5F9;
            --ink: #14233B; --ink-2: #475569; --ink-3: #6B7A90; --line: #E3E8F0;
            /* Warna status: hijau = Normal, kuning = Borderline, merah = Abnormal */
            --ok: #0F8A5F;   --ok-bg: #E3F5ED;
            --warn: #B7690B; --warn-bg: #FDF1DC;
            --act: #C8303C;  --act-bg: #FDECEE;
            --ai: #0A78B5;   --ai-bg: #E2F2FA;
            /* Sudut mengikuti halaman Riwayat */
            --r-btn: 11px;    /* tombol utama */
            --r-field: 10px;  /* input, select, menu sidebar */
            --r-sm: 9px;      /* tombol kecil, pagination, ikon */
        }
        body { font-family: 'Inter', system-ui, sans-serif; -webkit-font-smoothing: antialiased; color: var(--ink);
            background: radial-gradient(900px 400px at 85% -80px, #DCE8FA 0%, transparent 70%), var(--bg); background-attachment: fixed; }
        h1, h2, h3, h4 { font-family: 'Source Serif 4', Georgia, serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        :focus-visible { outline: 2px solid var(--brand); outline-offset: 2px; }
        .scrollbar-thin::-webkit-scrollbar { width: 6px; height: 6px; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 99px; }

        /* Komponen */
        .card { background: #fff; border: 1px solid var(--line); border-radius: 14px; box-shadow: 0 1px 2px rgba(15,39,71,.05), 0 8px 24px -16px rgba(15,39,71,.18); }
        .ico { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: var(--brand-soft); color: var(--brand); }
        .h-title { font-size: 17px; font-weight: 600; color: var(--ink); }
        .h-sub { font-size: 13.5px; color: var(--ink-3); margin-top: 2px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; white-space: nowrap; }
        .b-ok { background: var(--ok-bg); color: var(--ok); }
        .b-warn { background: var(--warn-bg); color: var(--warn); }
        .b-act { background: var(--act-bg); color: var(--act); }
        .b-ai { background: var(--ai-bg); color: var(--ai); }
        .b-none { background: #E8ECF2; color: var(--ink-2); }
        .btn-line { display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px; border-radius: var(--r-sm); border: 1px solid var(--line); background: #fff; font-size: 13px; font-weight: 600; color: var(--brand); transition: .15s; }
        .btn-line:hover { background: var(--brand-soft); border-color: #B9D0F2; }
        .btn-primary { display: inline-flex; align-items: center; gap: 8px; padding: 9px 16px; border-radius: var(--r-btn); background: var(--brand); color: #fff; font-size: 13.5px; font-weight: 600; transition: .15s; box-shadow: 0 6px 14px -8px var(--brand); }
        .btn-primary:hover { background: #174C99; }
        .btn-ghost { display: inline-flex; align-items: center; gap: 8px; padding: 9px 16px; border-radius: var(--r-btn); background: #fff; border: 1px solid var(--line); color: var(--ink-2); font-size: 13.5px; font-weight: 600; transition: .15s; }
        .btn-ghost:hover { background: var(--brand-soft); color: var(--brand); }
        .field { height: 40px; border-radius: var(--r-field); border: 1px solid var(--line); background: #fff; font-size: 13.5px; color: var(--ink-2); }
        .field:focus { outline: none; border-color: var(--brand); box-shadow: 0 0 0 4px rgba(29,95,191,.12); }
        .pg { width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border-radius: var(--r-sm); border: 1px solid var(--line); background: #fff; font-size: 13px; font-weight: 500; color: var(--ink-2); transition: .15s; }
        a.pg:hover, button.pg:hover:not(:disabled) { background: var(--brand-soft); color: var(--brand); }
        .pg.on { background: var(--brand); border-color: var(--brand); color: #fff; font-weight: 700; }
        .pg:disabled, .pg.off { background: #F7F9FC; color: #C5CEDB; cursor: not-allowed; }
        .animate-bar { transition: width 1s cubic-bezier(.4,0,.2,1); }

        /* Banner utama */
        .hero { position: relative; overflow: hidden; border-radius: 20px; padding: 28px; color: #fff;
            background: linear-gradient(120deg, #0B1F3A 0%, #15407F 55%, #2B78E0 100%); box-shadow: 0 18px 40px -18px rgba(21,64,127,.65); }
        .hero-ring { position: absolute; border-radius: 50%; border: 1px solid rgba(255,255,255,.14); pointer-events: none; }
        .hero-ring.r1 { width: 380px; height: 380px; right: -90px; top: -150px; background: radial-gradient(circle, rgba(255,255,255,.12), transparent 70%); }
        .hero-ring.r2 { width: 230px; height: 230px; right: 190px; bottom: -130px; }
        .hero-chip { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 999px; background: rgba(255,255,255,.14); border: 1px solid rgba(255,255,255,.22); font-size: 12px; font-weight: 600; }

        /* Sidebar */
        #sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(15,39,71,.5); z-index: 40; }
        #sidebar-overlay.open { display: block; }
        #sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: 272px; z-index: 50; display: flex; flex-direction: column; padding: 22px 14px 16px;
            background: linear-gradient(180deg, #0F2747 0%, #0B1F3A 100%); color: #fff; transform: translateX(-100%); transition: transform .3s cubic-bezier(.4,0,.2,1); }
        #sidebar.open { transform: translateX(0); }
        #sidebar::after { content: ''; position: absolute; inset: 0; pointer-events: none; background: radial-gradient(260px 220px at 0% 0%, rgba(91,157,245,.28), transparent 70%), radial-gradient(240px 240px at 100% 100%, rgba(91,157,245,.16), transparent 70%); }
        #sidebar > * { position: relative; z-index: 1; }
        .nav-label { padding: 0 12px; margin: 22px 0 8px; font-size: 12px; font-weight: 600; color: #7F97B8; }
        .nav-link { position: relative; display: flex; align-items: center; gap: 12px; padding: 11px 12px; margin-bottom: 4px; border-radius: var(--r-field); font-size: 13.5px; font-weight: 500; color: #B7C7DD; transition: .15s; }
        .nav-link:hover { background: rgba(255,255,255,.07); color: #fff; }
        .nav-link.active { background: linear-gradient(90deg, rgba(91,157,245,.32), rgba(91,157,245,.08)); box-shadow: inset 0 0 0 1px rgba(143,187,250,.25); color: #fff; font-weight: 600; }
        .nav-link.active::before { content: ''; position: absolute; left: -14px; top: 9px; bottom: 9px; width: 4px; border-radius: 0 4px 4px 0; background: #5B9DF5; }
        .nav-link.active .material-symbols-outlined { color: #8FBBFA; font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
        .side-user { margin-top: auto; padding: 12px; border-radius: 12px; background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.1); display: flex; align-items: center; gap: 10px; }
        .side-user .logout { margin-left: auto; width: 34px; height: 34px; border-radius: var(--r-sm); display: flex; align-items: center; justify-content: center; color: #9FB3CF; transition: .15s; }
        .side-user .logout:hover { background: rgba(229,72,77,.18); color: #FF8A8E; }
        @media (min-width: 1024px) {
            #sidebar { position: sticky; transform: translateX(0) !important; flex-shrink: 0; }
            #sidebar-overlay { display: none !important; }
            #hamburger-btn { display: none !important; }
        }
        @media (prefers-reduced-motion: reduce) { .animate-bar, #sidebar { transition: none !important; } }
        @media print {
            #sidebar, #sidebar-overlay, header, form, nav, .no-print { display: none !important; }
            body { background: #fff; }
            .card { box-shadow: none; }
        }
    </style>
    <style>
        .side-card { margin-bottom: 12px; padding: 14px; border-radius: 14px; background: linear-gradient(135deg, rgba(91,157,245,.28), rgba(91,157,245,.08)); border: 1px solid rgba(143,187,250,.25); }
        .side-card b { font-size: 1.5rem; font-weight: 700; line-height: 1; }
        .prog { display: flex; align-items: center; gap: 12px; padding: 14px 16px; border-radius: 12px; border: 1px solid var(--line); background: var(--cbg); }
        .prog .num { font-size: 1.6rem; font-weight: 700; line-height: 1; color: var(--c); }

        /* Kartu statistik (versi ringkas) */
        .stat { position: relative; overflow: hidden; padding: 14px 14px 12px; transition: transform .2s, box-shadow .2s; }
        .stat:hover { transform: translateY(-3px); box-shadow: 0 14px 28px -14px rgba(15,39,71,.35); }
        .stat::before { content: ''; position: absolute; left: 0; right: 0; top: 0; height: 3px; background: var(--c); }
        .stat .tile { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; flex-shrink: 0; background: linear-gradient(135deg, var(--c), color-mix(in srgb, var(--c) 65%, #fff)); box-shadow: 0 6px 12px -6px var(--c); }
        /* Angka statistik tetap Inter supaya rapi, bukan serif */
        .stat-num { font-family: 'Inter', system-ui, sans-serif !important; font-size: 1.7rem; font-weight: 700; line-height: 1; color: var(--c); }

        .att { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 12px 14px; border: 1px solid var(--line); border-left: 4px solid var(--c); border-radius: 12px; background: var(--cbg); transition: box-shadow .15s; }
        .att:hover { box-shadow: 0 2px 8px rgba(15,39,71,.08); }
        .avatar { width: 40px; height: 40px; border-radius: 50%; background: #fff; border: 1px solid var(--line); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: var(--brand); flex-shrink: 0; }
        #tabel-skrining { min-width: 980px; }
        #tabel-skrining.show-detail { min-width: 1400px; }
        #tabel-skrining:not(.show-detail) .col-detail { display: none; }
        #tabel-skrining th { padding: 12px 18px; text-align: left; font-size: 12px; font-weight: 700; color: var(--ink-2); background: #F7F9FC; border-bottom: 1px solid var(--line); white-space: nowrap; }
        #tabel-skrining td { padding: 14px 18px; vertical-align: middle; font-size: 13.5px; }
        tr.row-risiko { background-color: #F3FAFE; }
        tr.row-risiko:hover { background-color: #E8F4FB !important; }
        tr.row-risiko td:first-child { box-shadow: inset 3px 0 0 var(--ai); }
        tr[data-row]:not(.row-risiko):hover { background: #F8FAFD; }
        @media (prefers-reduced-motion: reduce) { .stat { transition: none !important; } }

        /* ===== Perapian tampilan mobile ===== */
        @media (max-width: 639px) {
            .hero { padding: 22px 18px; border-radius: 16px; }
            .hero-ring.r1 { width: 260px; height: 260px; right: -100px; top: -110px; }
            .hero-ring.r2 { display: none; }
            .card { border-radius: 12px; }
            .h-title { font-size: 16px; }
            .h-sub { font-size: 13px; }
            .stat { padding: 12px 12px 10px; }
            .stat .tile { width: 32px; height: 32px; }
            .stat-num { font-size: 1.45rem; }
            .prog { padding: 12px 14px; }
            /* Baris siswa: teks di atas, tombol selebar penuh di bawah */
            .att { flex-wrap: wrap; padding: 12px; }
            .att > div:first-child { flex: 1 1 100%; }
            .att > .btn-line { width: 100%; justify-content: center; }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/tema.css') }}">
</head>
<body class="flex min-h-screen">

@php
    // ===== Data ringkasan =====
    $totalSiswa    = $hasilSdq->count();
    $cntNormal     = $hasilSdq->where('hasil_label', 'Normal')->count();
    $cntBorderline = $hasilSdq->where('hasil_label', 'Borderline')->count();
    $cntAbnormal   = $hasilSdq->where('hasil_label', 'Abnormal')->count();
    $cntRisikoAI   = $hasilSdq->where('risiko_ai', 'YES')->count();

    $pct = fn ($n) => $totalSiswa > 0 ? round($n / $totalSiswa * 100) : 0;

    // ===== Analisis per siswa (dipakai di panel & tabel) =====
    $analisa = function ($s) {
        $keputusan  = $s->keputusan_akhir ?? $s->hasil_label;
        $isRisikoAI = ($s->risiko_ai ?? '') === 'YES';
        $tindakan   = in_array($keputusan, ['High Risk', 'Abnormal']);
        $polaTersembunyi = $isRisikoAI && $s->hasil_label === 'Normal';

        if ($polaTersembunyi) {
            $rekomendasi = 'Konseling: SDQ normal tapi AI mendeteksi risiko';
            $rekColor    = 'text-[#0A78B5] font-semibold';
        } elseif ($tindakan) {
            $rekomendasi = 'Tindakan segera';
            $rekColor    = 'text-[#C8303C] font-semibold';
        } elseif ($keputusan === 'Borderline' || $isRisikoAI) {
            $rekomendasi = 'Pemantauan aktif';
            $rekColor    = 'text-[#B7690B] font-semibold';
        } else {
            $rekomendasi = 'Pemantauan rutin';
            $rekColor    = 'text-[#6B7A90]';
        }

        $kaBadge = match (true) {
            $tindakan                   => 'b-act',
            $keputusan === 'Borderline' => 'b-warn',
            default                     => 'b-ok',
        };

        $groups = [];
        if ($tindakan)                                      $groups[] = 'tindakan';
        elseif ($keputusan === 'Borderline' || $isRisikoAI) $groups[] = 'pantau';
        else                                                $groups[] = 'normal';
        if ($isRisikoAI)                                    $groups[] = 'ai';

        return [
            'keputusan' => $keputusan, 'isRisikoAI' => $isRisikoAI, 'tindakan' => $tindakan,
            'polaTersembunyi' => $polaTersembunyi, 'rekomendasi' => $rekomendasi,
            'rekColor' => $rekColor, 'kaBadge' => $kaBadge, 'groups' => implode(' ', $groups),
        ];
    };

    $semuaPerhatian = $hasilSdq->filter(function ($s) use ($analisa) {
        $a = $analisa($s);
        return $a['tindakan'] || $a['isRisikoAI'];
    })->sortByDesc(fn ($s) => $analisa($s)['tindakan'] ? 1 : 0)->values();

    $cntTindakan    = $hasilSdq->filter(fn ($s) => $analisa($s)['tindakan'])->count();
    $perluPerhatian = $semuaPerhatian->take(5);

    // ===== Perkembangan siswa (hasil terbaru vs pengisian sebelumnya) =====
    // Butuh $hasilSdq berisi SEMUA hasil (bukan hanya yang terbaru per siswa).
    $perubahan = $hasilSdq->groupBy(fn ($r) => $r->user_id ?? ('n:' . $r->nama))
        ->filter(fn ($g) => $g->count() >= 2)
        ->map(function ($g) {
            $g = $g->sortByDesc('created_at')->values();
            $d = (int) $g[0]->total_kesulitan - (int) $g[1]->total_kesulitan;
            return (object) ['s' => $g[0], 'prev' => $g[1], 'delta' => $d, 'n' => $g->count(),
                             'arah' => $d <= -2 ? 'baik' : ($d >= 2 ? 'buruk' : 'sama')];
        })->values();
    $cntBaik   = $perubahan->where('arah', 'baik')->count();
    $cntSama   = $perubahan->where('arah', 'sama')->count();
    $cntBuruk  = $perubahan->where('arah', 'buruk')->count();
    $daftarBuruk = $perubahan->where('arah', 'buruk')->sortByDesc('delta')->take(5)->values();

    // ===== Sapaan sesuai jam (WIB) =====
    $sekarang = now('Asia/Jakarta')->locale('id');
    $jam = (int) $sekarang->format('H');
    $sapaan = $jam < 11 ? 'Selamat pagi' : ($jam < 15 ? 'Selamat siang' : ($jam < 18 ? 'Selamat sore' : 'Selamat malam'));
    $namaDepan = \Illuminate\Support\Str::words(Auth::user()->name, 1, '');

    // ===== Kartu statistik (tampilan) =====
    $stats = [
        ['label' => 'Total skrining',  'val' => $totalSiswa,    'sub' => 'Hasil tersimpan',                          'icon' => 'fact_check',          'c' => '#1D5FBF', 'cbg' => '#E8F0FB', 'ping' => false],
        ['label' => 'Normal',          'val' => $cntNormal,     'sub' => $pct($cntNormal) . '% • Kondisi baik',      'icon' => 'sentiment_satisfied', 'c' => '#0F8A5F', 'cbg' => '#E3F5ED', 'ping' => false],
        ['label' => 'Borderline',      'val' => $cntBorderline, 'sub' => $pct($cntBorderline) . '% • Perlu dipantau','icon' => 'visibility',          'c' => '#B7690B', 'cbg' => '#FDF1DC', 'ping' => false],
        ['label' => 'Abnormal',        'val' => $cntAbnormal,   'sub' => $pct($cntAbnormal) . '% • Perlu tindakan',  'icon' => 'priority_high',       'c' => '#C8303C', 'cbg' => '#FDECEE', 'ping' => false],
        ['label' => 'Pola risiko (AI)','val' => $cntRisikoAI,   'sub' => 'Risiko tersembunyi',                       'icon' => 'psychology',          'c' => '#0A78B5', 'cbg' => '#E2F2FA', 'ping' => $cntRisikoAI > 0, 'wide' => true],
    ];
@endphp

<div id="sidebar-overlay" onclick="closeSidebar()"></div>

@include('partials.sidebar_dashboard_gurubk')

<script>
    function openSidebar() {
        document.getElementById('sidebar').classList.add('open');
        document.getElementById('sidebar-overlay').classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebar-overlay').classList.remove('open');
        document.body.style.overflow = '';
    }
    window.addEventListener('resize', () => { if (window.innerWidth >= 1024) closeSidebar(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSidebar(); });
</script>

{{-- ================= MAIN ================= --}}
<main class="flex-1 min-w-0 flex flex-col">

    <header class="h-16 bg-white/90 backdrop-blur-md border-b border-[#E3E8F0] flex items-center justify-between px-4 md:px-8 sticky top-0 z-30">
        <div class="flex items-center gap-3">
            <button id="hamburger-btn" onclick="openSidebar()" aria-label="Buka menu"
                class="w-9 h-9 rounded-[9px] border border-[#E3E8F0] flex items-center justify-center hover:bg-[#E8F0FB] transition-colors lg:hidden">
                <span class="material-symbols-outlined text-[#475569]" style="font-size:20px">menu</span>
            </button>
            <div>
                <h2 class="text-lg md:text-xl font-semibold text-[#14233B] leading-tight">Dashboard Guru BK</h2>
                <p class="text-[13px] text-[#6B7A90] hidden sm:block">Pantau kondisi kesehatan mental siswa</p>
            </div>
        </div>
        <span class="text-[13px] font-medium text-[#475569] hidden sm:flex items-center gap-2 px-3 py-2 rounded-lg bg-[#F3F5F9] border border-[#E3E8F0]">
            <span class="material-symbols-outlined" style="font-size:16px">calendar_today</span>
            {{ $sekarang->isoFormat('dddd, D MMMM Y') }}
        </span>
    </header>

    <div class="flex-1 p-4 md:p-8 space-y-5 md:space-y-6 max-w-[1400px] w-full mx-auto">

        {{-- ===== Sapaan + ringkasan ===== --}}
        <section class="hero">
            <div class="hero-ring r1"></div><div class="hero-ring r2"></div>
            <div class="relative flex flex-col lg:flex-row lg:items-center justify-between gap-5 md:gap-7">
                <div class="min-w-0 max-w-2xl">
                    <span class="hero-chip">
                        <span class="material-symbols-outlined" style="font-size:16px">{{ $cntTindakan > 0 ? 'notifications_active' : 'verified' }}</span>
                        {{ $cntTindakan > 0 ? 'Ada kasus perlu tindakan' : 'Kondisi terpantau baik' }}
                    </span>
                    <h3 class="text-2xl md:text-3xl font-semibold mt-3 leading-tight">{{ $sapaan }}, {{ $namaDepan }}</h3>
                    <p class="text-[13.5px] text-blue-100 mt-2 leading-relaxed">
                        @if($totalSiswa === 0)
                            Belum ada siswa yang mengisi skrining. Hasil akan muncul di sini setelah siswa mengisi.
                        @elseif($cntTindakan > 0)
                            Ada <strong class="text-white">{{ $cntTindakan }} siswa</strong> yang perlu tindakan segera
                            @if($cntRisikoAI > 0) dan <strong class="text-white">{{ $cntRisikoAI }} siswa</strong> dengan pola risiko dari AI @endif.
                            Mulai dari daftar "Perlu Perhatian" di bawah.
                        @elseif($cntRisikoAI > 0)
                            Tidak ada kasus yang perlu tindakan segera, namun AI mendeteksi pola risiko pada <strong class="text-white">{{ $cntRisikoAI }} siswa</strong>.
                        @else
                            Tidak ada siswa yang perlu tindakan segera saat ini. Semua dalam pemantauan rutin.
                        @endif
                    </p>
                </div>
                <a href="/riwayat" class="no-print inline-flex items-center justify-center gap-2 px-5 py-3 rounded-[11px] bg-white text-[#0F2747] hover:bg-[#E8F0FB] text-[13.5px] font-semibold transition-colors shadow-lg shadow-black/10 flex-shrink-0 self-start lg:self-center w-full sm:w-auto">
                    <span class="material-symbols-outlined" style="font-size:18px">clinical_notes</span>
                    Buka Riwayat Skrining
                </a>
            </div>
        </section>

        {{-- ===== Kartu statistik ===== --}}
        <section class="grid grid-cols-2 lg:grid-cols-5 gap-3 md:gap-4">
            @foreach($stats as $st)
            <div class="card stat {{ !empty($st['wide']) ? 'col-span-2 lg:col-span-1' : '' }}" style="--c:{{ $st['c'] }}">
                <div class="flex items-center gap-3">
                    <div class="tile relative">
                        <span class="material-symbols-outlined" style="font-size:20px">{{ $st['icon'] }}</span>
                        @if($st['ping'])
                        <span class="absolute -top-1 -right-1 flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#38BDF8] opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-white border-2 border-[#0A78B5]"></span>
                        </span>
                        @endif
                    </div>
                    <h3 class="stat-num">{{ $st['val'] }}</h3>
                </div>
                <p class="text-[13.5px] font-semibold text-[#14233B] mt-2.5">{{ $st['label'] }}</p>
                <p class="text-[12px] text-[#6B7A90] mt-0.5">{{ $st['sub'] }}</p>
            </div>
            @endforeach
        </section>

        {{-- ===== Sebaran hasil ===== --}}
        @if($totalSiswa > 0)
        <section class="card p-4 sm:p-5 md:p-6">
            <div class="flex items-center justify-between flex-wrap gap-2 mb-4">
                <div class="flex items-center gap-3">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">donut_small</span></span>
                    <h4 class="h-title">Sebaran Hasil Skrining</h4>
                </div>
                <p class="text-[13px] text-[#6B7A90]">Berdasarkan hasil SDQ dari {{ $totalSiswa }} siswa</p>
            </div>
            <div class="flex h-2 w-full rounded-full overflow-hidden bg-[#EEF1F6]" role="img"
                 aria-label="Normal {{ $pct($cntNormal) }}%, Borderline {{ $pct($cntBorderline) }}%, Abnormal {{ $pct($cntAbnormal) }}%">
                <div data-bar class="bg-[#10A674] animate-bar" style="width:{{ $pct($cntNormal) }}%"></div>
                <div data-bar class="bg-[#EBA024] animate-bar" style="width:{{ $pct($cntBorderline) }}%"></div>
                <div data-bar class="bg-[#DC3A46] animate-bar" style="width:{{ $pct($cntAbnormal) }}%"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 sm:gap-3 mt-4">
                <div class="flex items-center gap-2.5 rounded-xl border border-[#CDEBDD] bg-[#F4FBF8] px-3.5 py-2.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#10A674]"></span>
                    <span class="text-[13px] text-[#475569]">Normal</span>
                    <strong class="ml-auto text-[13.5px] text-[#0F8A5F]">{{ $cntNormal }} <span class="text-[12px] font-medium text-[#6B7A90]">({{ $pct($cntNormal) }}%)</span></strong>
                </div>
                <div class="flex items-center gap-2.5 rounded-xl border border-[#F4DFB6] bg-[#FFFAF0] px-3.5 py-2.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#EBA024]"></span>
                    <span class="text-[13px] text-[#475569]">Borderline</span>
                    <strong class="ml-auto text-[13.5px] text-[#B7690B]">{{ $cntBorderline }} <span class="text-[12px] font-medium text-[#6B7A90]">({{ $pct($cntBorderline) }}%)</span></strong>
                </div>
                <div class="flex items-center gap-2.5 rounded-xl border border-[#F3C9CD] bg-[#FFF6F6] px-3.5 py-2.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#DC3A46]"></span>
                    <span class="text-[13px] text-[#475569]">Abnormal</span>
                    <strong class="ml-auto text-[13.5px] text-[#C8303C]">{{ $cntAbnormal }} <span class="text-[12px] font-medium text-[#6B7A90]">({{ $pct($cntAbnormal) }}%)</span></strong>
                </div>
            </div>
        </section>
        @endif

        {{-- ===== Perkembangan siswa ===== --}}
        @if($totalSiswa > 0)
        <section class="card p-4 sm:p-5 md:p-6">
            <div class="flex items-start justify-between gap-3 mb-4 flex-wrap">
                <div class="flex items-start gap-3">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">monitoring</span></span>
                    <div>
                        <h4 class="h-title">Perkembangan Siswa</h4>
                        <p class="h-sub">Hasil terbaru dibandingkan dengan pengisian sebelumnya (skor total turun = lebih baik)</p>
                    </div>
                </div>
                @if($perubahan->count() > 0)<span class="text-[13px] text-[#6B7A90]">{{ $perubahan->count() }} siswa sudah mengisi lebih dari sekali</span>@endif
            </div>

            @if($perubahan->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="prog" style="--c:#0F8A5F;--cbg:#F4FBF8"><span class="material-symbols-outlined text-[#0F8A5F]" style="font-size:26px">trending_down</span><div><p class="num">{{ $cntBaik }}</p><p class="text-[13px] text-[#475569] mt-1">Membaik</p></div></div>
                <div class="prog" style="--c:#475569;--cbg:#F7F9FC"><span class="material-symbols-outlined text-[#475569]" style="font-size:26px">trending_flat</span><div><p class="num">{{ $cntSama }}</p><p class="text-[13px] text-[#475569] mt-1">Relatif sama</p></div></div>
                <div class="prog" style="--c:#B7690B;--cbg:#FFFAF0"><span class="material-symbols-outlined text-[#B7690B]" style="font-size:26px">trending_up</span><div><p class="num">{{ $cntBuruk }}</p><p class="text-[13px] text-[#475569] mt-1">Skor naik, perlu dipantau</p></div></div>
            </div>

            @if($daftarBuruk->count() > 0)
            <h5 class="text-[13px] font-semibold text-[#475569] mt-5 mb-2">Skor naik paling besar</h5>
            <div class="space-y-2">
                @foreach($daftarBuruk as $x)
                <div class="att" style="--c:#B7690B;--cbg:#FFFCF3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="avatar">{{ strtoupper(substr($x->s->nama ?? 'S', 0, 2)) }}</div>
                        <div class="min-w-0">
                            <p class="text-[13.5px] font-semibold text-[#14233B] truncate">{{ $x->s->nama }}</p>
                            <p class="text-[12px] text-[#6B7A90]">Kelas {{ $x->s->kelas }} · pengisian ke-{{ $x->n }}</p>
                            <p class="text-[12px] mt-1 text-[#B7690B] font-semibold">Skor total {{ $x->prev->total_kesulitan }} menjadi {{ $x->s->total_kesulitan }} (naik {{ $x->delta }} poin)</p>
                        </div>
                    </div>
                    <a href="/riwayat/{{ $x->s->id }}" class="btn-line flex-shrink-0">Lihat perkembangan<span class="material-symbols-outlined" style="font-size:15px">chevron_right</span></a>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-[13px] text-[#6B7A90] mt-4 flex items-center gap-1.5"><span class="material-symbols-outlined text-[#0F8A5F]" style="font-size:18px">check_circle</span>Tidak ada siswa yang skornya naik dibanding pengisian sebelumnya.</p>
            @endif
            @else
            <div class="text-center py-8 px-4 rounded-xl border border-dashed border-[#D5DDE9] bg-[#F7F9FC]">
                <span class="material-symbols-outlined text-[#CBD5E1]" style="font-size:36px">show_chart</span>
                <p class="text-[13.5px] font-semibold text-[#14233B] mt-2">Belum ada siswa yang mengisi lebih dari sekali</p>
                <p class="text-[13px] text-[#6B7A90] mt-1 max-w-md mx-auto leading-relaxed">Perbandingan perkembangan akan muncul setelah ada siswa yang mengisi skrining untuk kedua kalinya.</p>
            </div>
            @endif
        </section>
        @endif

        {{-- ===== Perlu perhatian + Subskala ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

            <section class="lg:col-span-7 card p-4 sm:p-5 md:p-6 flex flex-col">
                <div class="flex items-start justify-between gap-3 mb-4">
                    <div class="flex items-start gap-3">
                        <span class="ico" style="background:var(--act-bg);color:var(--act)"><span class="material-symbols-outlined" style="font-size:20px">notifications_active</span></span>
                        <div>
                            <h4 class="h-title">Perlu Perhatian</h4>
                            <p class="h-sub">Siswa yang sebaiknya ditindaklanjuti lebih dulu</p>
                        </div>
                    </div>
                    @if($semuaPerhatian->count() > 0)
                    <span class="badge b-act">{{ $semuaPerhatian->count() }} siswa</span>
                    @endif
                </div>

                <div class="space-y-2.5 flex-1">
                    @forelse($perluPerhatian as $s)
                    @php $a = $analisa($s); @endphp
                    <div class="att" style="--c:{{ $a['tindakan'] ? '#C8303C' : '#0A78B5' }};--cbg:{{ $a['tindakan'] ? '#FFF7F7' : '#F3FAFE' }}">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="avatar">{{ strtoupper(substr($s->nama ?? 'S', 0, 2)) }}</div>
                            <div class="min-w-0">
                                <p class="text-[13.5px] font-semibold text-[#14233B] truncate">{{ $s->nama }}</p>
                                <p class="text-[12px] text-[#6B7A90]">Kelas {{ $s->kelas }} • {{ $s->created_at->locale('id')->diffForHumans() }}</p>
                                <p class="text-[12px] mt-1 {{ $a['rekColor'] }}">{{ $a['rekomendasi'] }}</p>
                            </div>
                        </div>
                        <a href="/riwayat/{{ $s->id }}" class="btn-line flex-shrink-0">
                            Detail
                            <span class="material-symbols-outlined" style="font-size:15px">chevron_right</span>
                        </a>
                    </div>
                    @empty
                    <div class="h-full flex flex-col items-center justify-center text-center py-10">
                        <div class="w-12 h-12 rounded-full bg-[#E3F5ED] text-[#0F8A5F] flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined" style="font-size:26px">check_circle</span>
                        </div>
                        <p class="text-[13.5px] font-semibold text-[#14233B]">Tidak ada yang perlu tindakan segera</p>
                        <p class="text-[13px] text-[#6B7A90] mt-1 max-w-xs">Siswa dengan hasil Abnormal atau pola risiko dari AI akan muncul di sini.</p>
                    </div>
                    @endforelse
                </div>

                @if($semuaPerhatian->count() > 5)
                <a href="#data-lengkap" onclick="document.getElementById('filter-status').value='ai'; document.getElementById('filter-status').dispatchEvent(new Event('change'));"
                   class="mt-4 text-[13px] font-semibold text-[#1D5FBF] hover:underline flex items-center gap-1">
                    Lihat {{ $semuaPerhatian->count() - 5 }} siswa lainnya di tabel
                    <span class="material-symbols-outlined" style="font-size:14px">arrow_downward</span>
                </a>
                @endif
            </section>

            <section class="lg:col-span-5 card p-4 sm:p-5 md:p-6 flex flex-col">
                <div class="flex items-start gap-3 mb-5">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">bar_chart</span></span>
                    <div>
                        <h4 class="h-title">Rata-rata Skor Subskala</h4>
                        <p class="h-sub">Rata-rata skor 0–10 dari semua hasil skrining SDQ</p>
                    </div>
                </div>
                @php
                    // Batas mengikuti SDQ self-report 3 kategori (usia 11–17). Dua garis per batang:
                    //   border = garis kuning (batang melewatinya jadi Borderline)
                    //   batas  = garis merah  (batang melewatinya jadi Abnormal)
                    //   Prososial dibaca terbalik: batang jadi kuning jika turun di bawah 6, merah jika di bawah 5.
                    $sdqBars = [
                        ['label' => 'Gejala Emosional',     'key' => 'skor_emotional',     'border' => 6, 'batas' => 7, 'rendah' => false],
                        ['label' => 'Masalah Perilaku',     'key' => 'skor_conduct',       'border' => 4, 'batas' => 5, 'rendah' => false],
                        ['label' => 'Hiperaktivitas',       'key' => 'skor_hyperactivity', 'border' => 6, 'batas' => 7, 'rendah' => false],
                        ['label' => 'Masalah Teman Sebaya', 'key' => 'skor_peer',          'border' => 4, 'batas' => 6, 'rendah' => false],
                        ['label' => 'Perilaku Prososial',   'key' => 'skor_prosocial',     'border' => 6, 'batas' => 5, 'rendah' => true],
                    ];

                    // Warna status: hijau = Normal, kuning = Borderline, merah = Abnormal
                    $warnaStatus = ['ok' => '#10A674', 'warn' => '#EBA024', 'abn' => '#DC3A46', 'none' => '#CBD5E1'];
                @endphp
                <div class="flex-1 flex flex-col justify-between gap-4">
                    @foreach($sdqBars as $bar)
                    @php
                        // Dibulatkan 1 desimal supaya warna sama dengan angka yang tampil
                        $avg    = round((float) $hasilSdq->avg($bar['key']), 1);
                        $val    = round($avg / 10 * 100);
                        $avgTxt = number_format($avg, 1, ',', '.');

                        // Warna batang mengikuti garis yang dilewati rata-rata
                        if ($totalSiswa === 0) {
                            $st = 'none';
                        } elseif ($bar['rendah']) {
                            $st = $avg < $bar['batas'] ? 'abn' : ($avg < $bar['border'] ? 'warn' : 'ok');
                        } else {
                            $st = $avg >= $bar['batas'] ? 'abn' : ($avg >= $bar['border'] ? 'warn' : 'ok');
                        }
                        $warna = $warnaStatus[$st];

                        $opKuning = $bar['rendah'] ? '<' : '≥';
                        $ketKuning = 'Kuning ' . $opKuning . ' ' . $bar['border'];
                        $ketMerah  = 'Merah '  . $opKuning . ' ' . $bar['batas'];
                    @endphp
                    <div>
                        <div class="flex justify-between items-center text-[13.5px] mb-1.5 gap-2">
                            <span class="text-[#475569] flex items-center gap-2 min-w-0">
                                <span class="w-2 h-2 rounded-full flex-shrink-0" style="background:{{ $warna }}"></span>
                                <span class="truncate">{{ $bar['label'] }}</span>
                            </span>
                            <span class="font-bold text-[#14233B] whitespace-nowrap">{{ $avgTxt }}<span class="text-[12px] font-medium text-[#6B7A90]"> / 10</span></span>
                        </div>
                        <div class="relative h-1.5 w-full bg-[#EEF1F6] rounded-full" role="img" aria-label="{{ $bar['label'] }}: rata-rata {{ $avgTxt }} dari 10. {{ $ketKuning }}, {{ $ketMerah }}">
                            <div data-bar class="h-full rounded-full animate-bar" style="width:{{ $val }}%; background:{{ $warna }}"></div>
                            {{-- Garis batas kuning (Borderline) dan merah (Abnormal) --}}
                            <span class="absolute top-1/2 -translate-x-1/2 -translate-y-1/2 w-[2px] h-3 rounded-full" style="left:{{ $bar['border'] * 10 }}%; background:#EBA024; box-shadow:0 0 0 1px #fff" title="{{ $ketKuning }}"></span>
                            <span class="absolute top-1/2 -translate-x-1/2 -translate-y-1/2 w-[2px] h-3 rounded-full" style="left:{{ $bar['batas'] * 10 }}%; background:#DC3A46; box-shadow:0 0 0 1px #fff" title="{{ $ketMerah }}"></span>
                        </div>
                        <p class="text-[12px] text-[#6B7A90] mt-2">
                            <span class="text-[#B7690B]">{{ $ketKuning }}</span>
                            <span class="mx-1 text-[#CBD5E1]">·</span>
                            <span class="text-[#C8303C]">{{ $ketMerah }}</span>
                        </p>
                    </div>
                    @endforeach
                </div>

                <p class="mt-5 text-[13px] text-[#6B7A90] leading-relaxed">
                    Batang = <strong class="text-[#14233B]">rata-rata skor</strong> (skala 0–10). Batang
                    <span class="font-semibold text-[#0F8A5F]">hijau</span> (Normal) berubah
                    <span class="font-semibold text-[#B7690B]">kuning</span> (Borderline) setelah melewati garis kuning, dan
                    <span class="font-semibold text-[#C8303C]">merah</span> (Abnormal) setelah melewati garis merah.
                    <strong class="text-[#14233B]">Prososial dibaca terbalik</strong>: skor tinggi berarti baik, jadi batangnya berubah warna saat turun di bawah garis.
                </p>
            </section>
        </div>

        {{-- ===== Tabel lengkap ===== --}}
        <section id="data-lengkap" class="card overflow-hidden scroll-mt-20">
            <div class="px-4 sm:px-5 md:px-6 py-4 md:py-5 border-b border-[#E3E8F0] flex items-center justify-between flex-wrap gap-3">
                <div class="flex items-start gap-3">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">table_chart</span></span>
                    <div>
                        <h4 class="h-title">Data Lengkap Skrining</h4>
                        <p class="h-sub">
                            Semua hasil SDQ + Analisis AI
                            @if($cntRisikoAI > 0)
                            — <span class="text-[#0A78B5] font-semibold">{{ $cntRisikoAI }} terdeteksi AI</span>
                            @endif
                        </p>
                    </div>
                </div>
                <a href="/riwayat" class="text-[13px] text-[#1D5FBF] font-semibold hover:underline flex items-center gap-1">
                    Lihat semua
                    <span class="material-symbols-outlined" style="font-size:14px">chevron_right</span>
                </a>
            </div>

            @if($totalSiswa > 0)
            <div class="px-4 sm:px-5 md:px-6 py-3.5 border-b border-[#E3E8F0] bg-[#F7F9FC] flex flex-wrap items-center gap-2.5">
                <div class="relative w-full sm:w-auto sm:flex-1 sm:min-w-[200px]">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94A3B8] pointer-events-none" style="font-size:18px">search</span>
                    <input id="cari-siswa" type="search" placeholder="Cari nama, NIS, atau kelas..." class="field w-full pl-10 pr-4">
                </div>
                <select id="filter-status" class="field py-0 pl-4 pr-9 font-medium cursor-pointer flex-1 sm:flex-none min-w-0">
                    <option value="all">Semua status</option>
                    <option value="tindakan">Perlu tindakan</option>
                    <option value="pantau">Perlu dipantau</option>
                    <option value="normal">Normal</option>
                    <option value="ai">Terdeteksi AI</option>
                </select>
                <button type="button" id="toggle-detail" class="field inline-flex items-center justify-center gap-1.5 px-4 font-medium hover:bg-[#E8F0FB] hover:text-[#1D5FBF] transition-colors flex-1 sm:flex-none">
                    <span class="material-symbols-outlined" style="font-size:18px">view_column</span>
                    <span id="toggle-detail-label">Tampilkan skor detail</span>
                </button>
            </div>
            @endif

            <div class="overflow-x-auto scrollbar-thin">
                <table id="tabel-skrining" class="w-full">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Hasil SDQ</th>
                            <th class="col-detail">Total</th>
                            <th class="col-detail">Emosional</th>
                            <th class="col-detail">Perilaku</th>
                            <th class="col-detail">Hiperaktif</th>
                            <th class="col-detail">Teman</th>
                            <th class="col-detail">Prososial</th>
                            <th>Analisis AI</th>
                            <th>Keputusan Akhir</th>
                            <th>Rekomendasi</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E3E8F0]">
                        @forelse($hasilSdq as $s)
                        @php
                            $a = $analisa($s);
                            $nis = $s->user?->nis ?: '-';

                            $sdqBadge = match($s->hasil_label) {
                                'Normal'     => 'b-ok',
                                'Borderline' => 'b-warn',
                                'Abnormal'   => 'b-act',
                                default      => 'b-none'
                            };

                            $nbBadge = match($s->hasil_naive_bayes ?? '') {
                                'Normal'     => 'b-ok',
                                'Borderline' => 'b-warn',
                                'High Risk'  => 'b-act',
                                default      => 'b-none'
                            };

                            $tgl = $s->created_at->locale('id');
                        @endphp
                        <tr data-row
                            data-search="{{ strtolower($s->nama.' '.$s->kelas.' '.$nis) }}"
                            data-groups="{{ $a['groups'] }}"
                            {{ $loop->iteration > 10 ? 'hidden' : '' }}
                            class="{{ $a['isRisikoAI'] ? 'row-risiko' : '' }} transition-colors">
                            <td>
                                <div class="flex items-center gap-1.5 font-semibold text-[#14233B]">
                                    {{ $s->nama }}
                                    @if($a['isRisikoAI'])
                                    <span class="material-symbols-outlined text-[#0A78B5]" title="Terdeteksi pola risiko oleh AI" style="font-size:15px;font-variation-settings:'FILL' 1">psychology</span>
                                    @endif
                                </div>
                                <p class="text-[12px] text-[#6B7A90] mt-0.5">NIS {{ $nis }}</p>
                            </td>
                            <td class="text-[#475569] whitespace-nowrap">{{ $s->kelas }}</td>
                            <td><span class="badge {{ $sdqBadge }}">{{ $s->hasil_label }}</span></td>
                            <td class="font-bold text-[#14233B] col-detail">{{ $s->total_kesulitan }}<span class="text-[#6B7A90] font-normal">/40</span></td>
                            <td class="col-detail {{ $s->skor_emotional >= 7 ? 'font-bold text-[#1D5FBF]' : 'text-[#6B7A90]' }}">{{ $s->skor_emotional }}</td>
                            <td class="col-detail {{ $s->skor_conduct >= 5 ? 'font-bold text-[#1D5FBF]' : 'text-[#6B7A90]' }}">{{ $s->skor_conduct }}</td>
                            <td class="col-detail {{ $s->skor_hyperactivity >= 6 ? 'font-bold text-[#1D5FBF]' : 'text-[#6B7A90]' }}">{{ $s->skor_hyperactivity }}</td>
                            <td class="col-detail {{ $s->skor_peer >= 5 ? 'font-bold text-[#1D5FBF]' : 'text-[#6B7A90]' }}">{{ $s->skor_peer }}</td>
                            <td class="col-detail text-[#6B7A90]">{{ $s->skor_prosocial }}</td>
                            <td>
                                @if($s->hasil_naive_bayes)
                                <span class="badge {{ $nbBadge }}">{{ $s->hasil_naive_bayes }}</span>
                                @else
                                <span class="text-[12px] text-[#6B7A90]">-</span>
                                @endif
                            </td>
                            <td><span class="badge {{ $a['kaBadge'] }}">{{ $a['keputusan'] }}</span></td>
                            <td class="text-[12px] {{ $a['rekColor'] }}" style="min-width:160px">{{ $a['rekomendasi'] }}</td>
                            <td class="text-[#475569] text-[12px] whitespace-nowrap">
                                {{ $tgl->translatedFormat('j M Y') }}
                                <span class="block text-[#94A3B8]">{{ $tgl->format('H.i') }} WIB</span>
                            </td>
                            <td><a href="/riwayat/{{ $s->id }}" class="btn-line">Detail</a></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="14" class="px-5 py-16 text-center text-[#6B7A90] text-[13.5px]">Belum ada data skrining</td>
                        </tr>
                        @endforelse

                        <tr id="no-result" hidden>
                            <td colspan="14" class="px-5 py-14 text-center">
                                <span class="material-symbols-outlined text-[#CBD5E1]" style="font-size:36px">search_off</span>
                                <p class="text-[13.5px] font-semibold text-[#14233B] mt-2">Tidak ada data yang cocok</p>
                                <p class="text-[13px] text-[#6B7A90] mt-1">Coba ubah kata kunci atau filter status.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if($totalSiswa > 0)
            <div class="px-4 sm:px-5 md:px-6 py-4 border-t border-[#E3E8F0] flex items-center justify-between flex-wrap gap-3">
                <p id="pagination-info" class="text-[13px] text-[#6B7A90]">
                    Menampilkan <span class="font-bold text-[#14233B]">1–{{ min(10, $totalSiswa) }}</span>
                    dari <span class="font-bold text-[#14233B]">{{ $totalSiswa }}</span> data
                </p>
                <nav id="pagination-nav" class="flex items-center gap-1.5 flex-wrap" aria-label="Paginasi data skrining"></nav>
            </div>
            @endif
        </section>

        <footer class="pt-4 border-t border-[#E3E8F0] flex justify-between items-center flex-wrap gap-2">
            <p class="text-[12px] text-[#6B7A90]">© 2026 SMPN 216 Jakarta — Portal Skrining Kesehatan Mental Siswa</p>
            <p class="text-[12px] text-[#6B7A90]">Powered by SDQ + Gaussian Naive Bayes</p>
        </footer>

    </div>
</main>

<script>
    // Animasi isi bar saat halaman dibuka
    (function () {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        document.querySelectorAll('[data-bar]').forEach(function (el) {
            var w = el.style.width;
            el.style.width = '0';
            requestAnimationFrame(function () {
                requestAnimationFrame(function () { el.style.width = w; });
            });
        });
    })();

    // ===== Tabel: pencarian, filter, skor detail, dan pagination =====
    (function () {
        const PER_PAGE = 10;
        const table   = document.getElementById('tabel-skrining');
        const rows    = Array.from(document.querySelectorAll('#tabel-skrining tbody tr[data-row]'));
        const nav     = document.getElementById('pagination-nav');
        const info    = document.getElementById('pagination-info');
        const section = document.getElementById('data-lengkap');
        const search  = document.getElementById('cari-siswa');
        const filter  = document.getElementById('filter-status');
        const noRes   = document.getElementById('no-result');
        const toggle  = document.getElementById('toggle-detail');
        const toggleLabel = document.getElementById('toggle-detail-label');

        if (!nav || !info || rows.length === 0) return;

        let filtered = rows.slice();
        let current  = 1;

        function getPages(cur, last) {
            if (last <= 7) return Array.from({ length: last }, (_, i) => i + 1);
            const pages = [1];
            const start = Math.max(2, cur - 1);
            const end   = Math.min(last - 1, cur + 1);
            if (start > 2) pages.push('...');
            for (let i = start; i <= end; i++) pages.push(i);
            if (end < last - 1) pages.push('...');
            pages.push(last);
            return pages;
        }

        function arrowBtn(icon, target, disabled, label) {
            return `<button type="button" data-page="${target}" ${disabled ? 'disabled' : ''} aria-label="${label}" class="pg">
                        <span class="material-symbols-outlined" style="font-size:18px">${icon}</span>
                    </button>`;
        }

        function render() {
            const total      = filtered.length;
            const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
            if (current > totalPages) current = totalPages;

            const startIdx = (current - 1) * PER_PAGE;
            const endIdx   = Math.min(startIdx + PER_PAGE, total);

            rows.forEach(r => { r.hidden = true; });
            filtered.slice(startIdx, endIdx).forEach(r => { r.hidden = false; });
            noRes.hidden = total > 0;

            if (total === 0) {
                info.innerHTML = 'Tidak ada data yang cocok';
                nav.innerHTML = '';
                return;
            }

            info.innerHTML =
                'Menampilkan <span class="font-bold text-[#14233B]">' + (startIdx + 1) + '–' + endIdx + '</span>' +
                ' dari <span class="font-bold text-[#14233B]">' + total + '</span> data' +
                (total !== rows.length ? ' <span class="text-[#94A3B8]">(difilter dari ' + rows.length + ')</span>' : '');

            if (totalPages <= 1) { nav.innerHTML = ''; return; }

            let html = arrowBtn('chevron_left', current - 1, current === 1, 'Halaman sebelumnya');
            getPages(current, totalPages).forEach(p => {
                if (p === '...') {
                    html += '<span class="w-8 h-8 flex items-center justify-center text-xs text-[#94A3B8]">…</span>';
                } else {
                    html += `<button type="button" data-page="${p}" ${p === current ? 'aria-current="page"' : ''} class="pg ${p === current ? 'on' : ''}">${p}</button>`;
                }
            });
            html += arrowBtn('chevron_right', current + 1, current === totalPages, 'Halaman berikutnya');
            nav.innerHTML = html;
        }

        function applyFilter() {
            const q = (search ? search.value : '').trim().toLowerCase();
            const f = filter ? filter.value : 'all';
            filtered = rows.filter(r =>
                (!q || r.dataset.search.includes(q)) &&
                (f === 'all' || r.dataset.groups.split(' ').includes(f))
            );
            current = 1;
            render();
        }

        nav.addEventListener('click', function (e) {
            const btn = e.target.closest('button[data-page]');
            if (!btn || btn.disabled) return;
            const page = parseInt(btn.dataset.page, 10);
            const totalPages = Math.max(1, Math.ceil(filtered.length / PER_PAGE));
            if (isNaN(page) || page < 1 || page > totalPages || page === current) return;
            current = page;
            render();
            if (section) section.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });

        if (search) search.addEventListener('input', applyFilter);
        if (filter) filter.addEventListener('change', applyFilter);

        if (toggle) {
            toggle.addEventListener('click', function () {
                const on = table.classList.toggle('show-detail');
                toggleLabel.textContent = on ? 'Sembunyikan skor detail' : 'Tampilkan skor detail';
            });
        }

        render();
    })();
</script>

</body>
</html>