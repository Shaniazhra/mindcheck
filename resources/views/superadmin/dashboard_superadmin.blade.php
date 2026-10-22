<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Super Admin | SMPN 216 Jakarta</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $logoUrl    = \App\Models\Pengaturan::url('logo', 'logo-smpn216.png');
        $sekarang   = now('Asia/Jakarta')->locale('id');
        $persenAbn  = $totalKuesioner > 0 ? round($cntAbnormal / $totalKuesioner * 100) : 0;
        $rasio      = $totalGuru > 0 ? round($totalSiswa / $totalGuru) : null;
        $rataIsi    = $totalSiswa > 0 ? number_format($totalKuesioner / $totalSiswa, 1, ',', '.') : '-';
        $totalAkun  = $totalGuru + $totalSiswa;
        $namaDepan  = \Illuminate\Support\Str::title(\Illuminate\Support\Str::words(Auth::user()->name, 2, ''));

        // Warna status sama dengan dashboard Guru BK:
        // biru = umum, hijau = baik, kuning = waspada, merah = abnormal
        $stats = [
            ['label' => 'Guru BK',             'val' => $totalGuru,      'sub' => 'Akun aktif',                'icon' => 'groups',         'c' => '#1D5FBF', 'cs' => '#E8F0FB', 'href' => route('superadmin.guru.index')],
            ['label' => 'Siswa terdaftar',     'val' => $totalSiswa,     'sub' => 'Akun siswa',                'icon' => 'school',         'c' => '#0F8A5F', 'cs' => '#E3F5ED', 'href' => route('superadmin.siswa.index')],
            ['label' => 'Pengisian kuesioner', 'val' => $totalKuesioner, 'sub' => 'Seluruh hasil SDQ',         'icon' => 'quiz',           'c' => '#B7690B', 'cs' => '#FDF1DC', 'href' => route('superadmin.kuesioner.index')],
            ['label' => 'Kasus abnormal',      'val' => $cntAbnormal,    'sub' => $persenAbn . '% dari pengisian', 'icon' => 'priority_high', 'c' => '#C8303C', 'cs' => '#FDECEE', 'href' => route('superadmin.kuesioner.index', ['label' => 'Abnormal'])],
        ];

        $aksi = [
            ['t' => 'Tambah akun Guru BK',     's' => 'Buat akun Guru BK baru',             'icon' => 'person_add',      'href' => route('superadmin.guru.create')],
            ['t' => 'Kelola data siswa',       's' => 'Edit, reset password, hapus',        'icon' => 'manage_accounts', 'href' => route('superadmin.siswa.index')],
            ['t' => 'Lihat data kuesioner',    's' => 'Semua hasil skrining SDQ',           'icon' => 'fact_check',      'href' => route('superadmin.kuesioner.index')],
            ['t' => 'Logo & gambar beranda',   's' => 'Atur tampilan portal',               'icon' => 'image',           'href' => route('superadmin.pengaturan.index')],
        ];
    @endphp
    <link rel="icon" type="image/png" href="{{ $logoUrl }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,500;8..60,600;8..60,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    @vite('resources/css/tema.css')

    {{-- CSS khusus halaman Super Admin. Font, ukuran font, radius ikut tema.css; CSS sidebar ada di partial sidebar_superadmin --}}
    <style>
        /* ============ Token: keluarga warna sama dengan Guru BK ============ */
        :root {
            --navy: #0F2747; --brand: #1D5FBF; --brand-soft: #E8F0FB; --bg: #F3F5F9;
            --ink: #14233B; --ink-2: #475569; --ink-3: #6B7A90; --line: #E3E8F0;
            /* Warna status: hijau = Normal, kuning = Borderline, merah = Abnormal */
            --ok: #0F8A5F;   --ok-bg: #E3F5ED;
            --warn: #B7690B; --warn-bg: #FDF1DC;
            --act: #C8303C;  --act-bg: #FDECEE;

            /* Pembeda Super Admin: keluarga indigo */
            --ind-950: #12143A;
            --ind-900: #1A1D52;
            --accent: #4B5FD6;
            --accent-soft: #ECEFFC;
            --accent-line: #C9D0F6;
            --accent-glow: #8D9BF0;
        }

        body {
            color: var(--ink);
            background: radial-gradient(900px 420px at 90% -100px, #E1E6FA 0%, transparent 70%), var(--bg);
            background-attachment: fixed;
        }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        :focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }

        /* ---------- Komponen dasar ---------- */
        .card { background: #fff; border: 1px solid var(--line); border-radius: 14px; box-shadow: 0 1px 2px rgba(15,39,71,.05), 0 8px 24px -16px rgba(15,39,71,.18); }
        .ico { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: var(--accent-soft); color: var(--accent); }
        .h-title { color: var(--ink); }
        .h-sub { color: var(--ink-3); margin-top: 2px; }

        /* ---------- Header ---------- */
        .topbar::before { content: ''; position: absolute; left: 0; right: 0; top: 0; height: 3px; background: linear-gradient(90deg, var(--ind-950) 0%, var(--accent) 55%, #2B78E0 100%); }

        /* ---------- Banner: busur tipis dan panel total akun ---------- */
        .hero { position: relative; overflow: hidden; border-radius: 20px; padding: 26px 28px; color: #fff;
            background: linear-gradient(125deg, #0E1030 0%, #1A1D52 50%, #3B4BC0 100%); box-shadow: 0 18px 40px -18px rgba(40,50,160,.6); }
        .hero::before { content: ''; position: absolute; inset: 0; pointer-events: none;
            background: repeating-radial-gradient(circle at 100% 0%, transparent 0, transparent 54px, rgba(255,255,255,.06) 54px, rgba(255,255,255,.06) 55px);
            -webkit-mask-image: linear-gradient(100deg, transparent 35%, #000 100%); mask-image: linear-gradient(100deg, transparent 35%, #000 100%); }
        .hero::after { content: ''; position: absolute; width: 420px; height: 420px; right: -120px; top: -170px; border-radius: 50%; pointer-events: none;
            background: radial-gradient(circle, rgba(141,155,240,.42), transparent 68%); }
        .hero > .in { position: relative; z-index: 1; }
        /* Chip: ukuran font dari tema.css, bentuk bulat seperti tema */
        .hero-chip { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 999px; background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.22); font-weight: 600; letter-spacing: .03em; }
        .glass { border-radius: 14px; padding: 14px 18px; background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); min-width: 200px; }
        .glass .big { font-size: 1.5rem; font-weight: 700; line-height: 1; letter-spacing: -.01em; }

        /* ---------- Strip angka: satu kartu menyatu, dibagi garis tipis. Ikon + angka sebaris, label dan keterangan di bawah ---------- */
        .strip { display: grid; grid-template-columns: 1fr; overflow: hidden; }
        .strip a { position: relative; display: block; padding: 16px 18px; transition: background .18s; border-bottom: 1px solid var(--line); }
        .strip a:last-child { border-bottom: 0; }
        .strip a:hover { background: #FAFBFE; }
        .strip a::after { content: ''; position: absolute; left: 0; right: 0; bottom: -1px; height: 3px; background: var(--c); transform: scaleX(0); transform-origin: left; transition: transform .25s; }
        .strip a:hover::after { transform: scaleX(1); }
        .strip .tile { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: var(--cs); color: var(--c); }
        .strip .num { font-size: 1.5rem; font-weight: 700; line-height: 1; letter-spacing: -.01em; color: var(--c); }
        @media (min-width: 560px) {
            .strip { grid-template-columns: 1fr 1fr; }
            .strip a { border-bottom: 1px solid var(--line); }
            .strip a:nth-child(odd) { border-right: 1px solid var(--line); }
            .strip a:nth-last-child(-n+2) { border-bottom: 0; }
        }
        @media (min-width: 1280px) {
            .strip { grid-template-columns: repeat(4, 1fr); }
            .strip a, .strip a:nth-child(odd), .strip a:nth-last-child(-n+2) { border-bottom: 0; border-right: 1px solid var(--line); }
            .strip a:last-child { border-right: 0; }
        }

        /* ---------- Aksi cepat: ubin dengan ikon di atas ---------- */
        .quick { position: relative; display: block; padding: 16px; border-radius: 14px; border: 1px solid var(--line); background: #fff; transition: .18s; }
        .quick .qi { width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; background: var(--brand-soft); color: var(--brand); transition: .18s; }
        .quick .qt { display: block; margin-top: 14px; font-size: 13.5px; font-weight: 600; color: var(--ink); line-height: 1.3; }
        .quick .qs { display: block; margin-top: 3px; font-size: 12px; color: var(--ink-3); }
        .quick .go { position: absolute; top: 14px; right: 14px; color: #B4C0D2; transition: .18s; }
        @media (hover: hover) {
            .quick:hover { border-color: #B8C2F2; background: var(--accent-soft); transform: translateY(-2px); box-shadow: 0 12px 24px -16px rgba(75,95,214,.55); }
            .quick:hover .qi { background: var(--accent); color: #fff; }
            .quick:hover .go { color: var(--accent); transform: translate(2px, -2px); }
        }
        .quick:active { background: var(--accent-soft); }

        /* ---------- Batang proporsi (merah = abnormal) ---------- */
        .bar { position: relative; height: 10px; border-radius: 99px; background: #EDF1F7; overflow: hidden; }
        .bar > i { position: absolute; left: 0; top: 0; bottom: 0; width: calc(var(--p) * 1%); min-width: 0; border-radius: 99px; background: linear-gradient(90deg, #E5636D, var(--act)); }
        .pct { font-size: 1.25rem; font-weight: 700; line-height: 1; color: var(--act); }

        @media (max-width: 479px) {
            .hero { padding: 20px 18px; border-radius: 16px; }
            .glass { min-width: 0; width: 100%; }
            .card { border-radius: 12px; }
            .strip .num { font-size: 1.35rem; }
        }
        @media (prefers-reduced-motion: reduce) {
            .quick, .quick .go, .quick .qi, .strip a, .strip a::after { transition: none !important; }
        }
    </style>
</head>

<body class="flex min-h-screen">

{{-- Overlay sidebar (dipakai openSidebar/closeSidebar dari partial) --}}
<div id="sidebar-overlay" onclick="closeSidebar()"></div>

@include('partials.sidebar_superadmin')

{{-- ================= MAIN ================= --}}
<main class="flex-1 min-w-0 flex flex-col">

    <header class="topbar h-16 bg-white/90 backdrop-blur-md border-b border-[#E3E8F0] flex items-center justify-between px-4 md:px-8 sticky top-0 z-30">
        <div class="flex items-center gap-3 min-w-0">
            <button id="hamburger-btn" onclick="openSidebar()" aria-label="Buka menu"
                    class="w-9 h-9 border border-[#E3E8F0] flex items-center justify-center hover:bg-[#ECEFFC] transition-colors lg:hidden flex-shrink-0">
                <span class="material-symbols-outlined text-[#475569]" style="font-size:20px">menu</span>
            </button>
            <div class="min-w-0">
                <h2 class="text-[#14233B] leading-tight truncate">Dashboard Super Admin</h2>
                <p class="text-[#6B7A90] hidden sm:block">Kelola seluruh data sistem MindCheck</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-[13px] font-medium text-[#475569] hidden sm:flex items-center gap-2 px-3 py-2 rounded-lg bg-[#F3F5F9] border border-[#E3E8F0]">
                <span class="material-symbols-outlined" style="font-size:16px">calendar_today</span>
                {{ $sekarang->isoFormat('dddd, D MMMM Y') }}
            </span>
        </div>
    </header>

    <div class="flex-1 p-4 md:p-8 space-y-5 md:space-y-6 max-w-[1400px] w-full mx-auto">

        @if(session('success'))
        <div class="bg-[#E3F5ED] border border-[#A7F3D0] text-[#0F8A5F] text-[13.5px] font-semibold rounded-xl px-4 py-3" role="status">
            {{ session('success') }}
        </div>
        @endif

        {{-- ===== Banner ===== --}}
        <section class="hero">
            <div class="in flex flex-col lg:flex-row lg:items-center justify-between gap-5 lg:gap-6">
                <div class="min-w-0 max-w-2xl">
                    <span class="hero-chip">
                        <span class="material-symbols-outlined" style="font-size:16px">verified_user</span>
                        AKSES PENUH SISTEM
                    </span>
                    <h3 class="text-2xl md:text-3xl font-semibold mt-3 leading-tight">Halo, {{ $namaDepan }}</h3>
                    <p class="text-[13.5px] text-indigo-100 mt-2 leading-relaxed">
                        Kelola akun Guru BK dan siswa, pantau data kuesioner SDQ, dan atur tampilan portal dari satu tempat.
                    </p>
                </div>

                <div class="glass flex-shrink-0">
                    <p class="text-[12px] font-semibold tracking-wider uppercase text-indigo-200">Total akun terdaftar</p>
                    <p class="big mt-2">{{ number_format($totalAkun) }}</p>
                    <div class="mt-3 pt-3 border-t border-white/15 flex items-center justify-between gap-4 text-[12px] text-indigo-100">
                        <span>{{ number_format($totalGuru) }} Guru BK</span>
                        <span>{{ number_format($totalSiswa) }} siswa</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===== Ringkasan angka (satu strip menyatu) ===== --}}
        <section class="card strip" aria-label="Ringkasan angka">
            @foreach($stats as $st)
            <a href="{{ $st['href'] }}" style="--c:{{ $st['c'] }};--cs:{{ $st['cs'] }}">
                <div class="flex items-center gap-3">
                    <span class="tile"><span class="material-symbols-outlined" style="font-size:20px">{{ $st['icon'] }}</span></span>
                    <span class="num">{{ number_format($st['val']) }}</span>
                </div>
                <p class="text-[13.5px] font-semibold text-[#14233B] mt-2.5">{{ $st['label'] }}</p>
                <p class="text-[12px] text-[#6B7A90] mt-0.5">{{ $st['sub'] }}</p>
            </a>
            @endforeach
        </section>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 md:gap-6">

            {{-- ===== Aksi cepat ===== --}}
            <section class="card p-4 sm:p-5 md:p-6 xl:col-span-2">
                <div class="flex items-start gap-3">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">bolt</span></span>
                    <div>
                        <h4 class="h-title">Aksi cepat</h4>
                        <p class="h-sub">Tugas yang paling sering dilakukan.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 min-[480px]:grid-cols-2 gap-3 md:gap-4 mt-5">
                    @foreach($aksi as $a)
                    <a href="{{ $a['href'] }}" class="quick">
                        <span class="qi"><span class="material-symbols-outlined" style="font-size:22px">{{ $a['icon'] }}</span></span>
                        <span class="material-symbols-outlined go" style="font-size:20px">arrow_outward</span>
                        <span class="qt">{{ $a['t'] }}</span>
                        <span class="qs">{{ $a['s'] }}</span>
                    </a>
                    @endforeach
                </div>
            </section>

            {{-- ===== Ringkasan sistem ===== --}}
            <section class="card p-4 sm:p-5 md:p-6">
                <div class="flex items-start gap-3">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">insights</span></span>
                    <div>
                        <h4 class="h-title">Ringkasan sistem</h4>
                        <p class="h-sub">Gambaran singkat dari data saat ini.</p>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="flex items-end justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-[13px] font-semibold text-[#475569]">Proporsi kasus abnormal</p>
                            <p class="text-[13.5px] font-bold text-[#14233B] mt-1">{{ number_format($cntAbnormal) }} dari {{ number_format($totalKuesioner) }} pengisian</p>
                        </div>
                        <p class="pct">{{ $persenAbn }}%</p>
                    </div>
                    <div class="bar mt-3" style="--p:{{ $persenAbn }}" role="img" aria-label="Kasus abnormal {{ $persenAbn }} persen">
                        <i></i>
                    </div>
                </div>

                <div class="mt-6 pt-5 border-t border-[#E3E8F0] space-y-3">
                    <div class="flex items-center justify-between text-[13.5px] gap-3">
                        <span class="text-[#6B7A90]">Siswa per Guru BK</span>
                        <span class="font-bold text-[#14233B]">{{ $rasio !== null ? $rasio : '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-[13.5px] gap-3">
                        <span class="text-[#6B7A90]">Rata-rata pengisian per siswa</span>
                        <span class="font-bold text-[#14233B]">{{ $rataIsi }}</span>
                    </div>
                    <div class="flex items-center justify-between text-[13.5px] gap-3">
                        <span class="text-[#6B7A90]">Total akun terdaftar</span>
                        <span class="font-bold text-[#14233B]">{{ number_format($totalAkun) }}</span>
                    </div>
                </div>
            </section>

        </div>

        <footer class="pt-4 border-t border-[#E3E8F0] flex justify-between items-center flex-wrap gap-2">
            <p class="text-[12px] text-[#6B7A90]">© {{ date('Y') }} SMPN 216 Jakarta — Portal Skrining Kesehatan Mental Siswa</p>
            <p class="text-[12px] text-[#6B7A90]">Super Admin Panel</p>
        </footer>

    </div>
</main>

</body>
</html>