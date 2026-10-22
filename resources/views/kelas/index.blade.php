<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data per Kelas | SMPN 216 Jakarta</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('logo-smpn216.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Source+Serif+4:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700&display=swap" rel="stylesheet">
    @vite('resources/css/tema.css')

    <style>
        :root {
            --navy: #0F2747; --brand: #1D5FBF; --brand-soft: #E8F0FB; --bg: #F3F5F9;
            --ink: #14233B; --ink-2: #475569; --ink-3: #6B7A90; --line: #E3E8F0;
            --ok: #0F8A5F;   --ok-bg: #E3F5ED;
            --warn: #B7690B; --warn-bg: #FDF1DC;
            --act: #6D3FD0;  --act-bg: #EEE8FB;
            --ai: #0A78B5;   --ai-bg: #E2F2FA;
        }
        body { font-family: var(--font-sans); color: var(--ink);
            background: radial-gradient(900px 400px at 85% -80px, #DCE8FA 0%, transparent 70%), var(--bg); background-attachment: fixed; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        :focus-visible { outline: 2px solid var(--brand); outline-offset: 2px; }
        .scrollbar-thin::-webkit-scrollbar { width: 6px; height: 6px; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 99px; }

        /* Card */
        .card { background: #fff; border: 1px solid var(--line); border-radius: 14px; box-shadow: 0 1px 2px rgba(15,39,71,.05), 0 8px 24px -16px rgba(15,39,71,.18); }
        .h-title { font-size: .9rem; font-weight: 700; color: var(--ink); }

        /* Hero */
        .hero { position: relative; overflow: hidden; border-radius: 20px; padding: 28px; color: #fff;
            background: linear-gradient(120deg, #0B1F3A 0%, #15407F 55%, #2B78E0 100%); box-shadow: 0 18px 40px -18px rgba(21,64,127,.65); }
        .hero-ring { position: absolute; border-radius: 50%; border: 1px solid rgba(255,255,255,.14); pointer-events: none; }
        .hero-ring.r1 { width: 380px; height: 380px; right: -90px; top: -150px; background: radial-gradient(circle, rgba(255,255,255,.12), transparent 70%); }
        .hero-ring.r2 { width: 230px; height: 230px; right: 190px; bottom: -130px; }
        .hero-chip { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 999px; background: rgba(255,255,255,.14); border: 1px solid rgba(255,255,255,.14); font-size: .75rem; font-weight: 600; }

        /* Kelas */
        [hidden] { display: none !important; }
        .kelas { display: flex; align-items: center; gap: 12px; padding: 12px 14px; background: #fff; border: 1px solid var(--line); border-radius: 12px; transition: border-color .15s, background .15s; }
        .kelas .tile { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: var(--brand-soft); color: var(--brand); transition: .15s; }
        .kelas .nama { display: block; font-size: .92rem; font-weight: 700; color: var(--ink); line-height: 1.25; }
        .kelas .jml { display: block; font-size: .75rem; color: var(--ink-3); margin-top: 2px; }
        .kelas .chev { margin-left: auto; color: #B4C0D2; transition: .15s; }
        .kelas:hover { border-color: #9DBBE8; background: #F6F9FE; }
        .kelas:hover .tile { background: var(--brand); color: #fff; }
        .kelas:hover .chev { color: var(--brand); transform: translateX(2px); }
        @media (prefers-reduced-motion: reduce) { .kelas, .kelas .chev { transition: none !important; } }
    </style>
</head>

<body class="flex min-h-screen">

@php
    $sekarang    = now('Asia/Jakarta')->locale('id');
    $kumpulan    = collect($daftarKelas);
    $totalKelas  = $kumpulan->count();
    $totalSiswa  = (int) $kumpulan->sum('jumlah_siswa');

    $grup = $kumpulan->groupBy(
        fn ($k) => preg_match('/^\s*(\d+)/', $k->kelas, $m) ? $m[1] : ''
    );

    $bisaGrup = $grup->count() > 1 && !$grup->has('');

    $grup = $kumpulan->isEmpty()
        ? collect()
        : ($bisaGrup ? $grup->sortKeys() : collect(['' => $kumpulan]));
@endphp

@include('partials.sidebar_dashboard_gurubk')

{{-- MAIN --}}
<main class="flex-1 min-w-0 flex flex-col">

    <header class="h-16 bg-white/90 backdrop-blur-md border-b border-[#E3E8F0] flex items-center justify-between px-4 md:px-8 sticky top-0 z-30">

        <div class="flex items-center gap-3">
            <button id="hamburger-btn" onclick="openSidebar()" aria-label="Buka menu"
                class="w-9 h-9 rounded-lg border border-[#E3E8F0] flex items-center justify-center hover:bg-[#E8F0FB] transition-colors lg:hidden">
                <span class="material-symbols-outlined text-[#475569]" style="font-size:20px">menu</span>
            </button>

            <div>
                <h2 class="text-base md:text-lg font-bold text-[#14233B] leading-tight">Data per Kelas</h2>
                <p class="text-xs text-[#6B7A90] hidden sm:block">Pilih kelas untuk melihat daftar siswa</p>
            </div>
        </div>

        <span class="text-xs font-medium text-[#475569] hidden sm:flex items-center gap-2 px-3 py-2 rounded-lg bg-[#F3F5F9] border border-[#E3E8F0]">
            <span class="material-symbols-outlined" style="font-size:16px">calendar_today</span>
            {{ $sekarang->isoFormat('dddd, D MMMM Y') }}
        </span>

    </header>

    <div class="flex-1 p-4 md:p-8 space-y-6 max-w-[1400px] w-full mx-auto">

        {{-- BANNER --}}
        <section class="hero">

            <div class="hero-ring r1"></div>
            <div class="hero-ring r2"></div>

            <div class="relative flex flex-col md:flex-row md:items-end justify-between gap-5">

                <div class="min-w-0 max-w-2xl">

                    <span class="hero-chip">
                        <span class="material-symbols-outlined" style="font-size:16px">groups</span>
                        {{ $totalKelas }} kelas · {{ $totalSiswa }} siswa
                    </span>

                    <h3 class="text-2xl md:text-3xl font-extrabold mt-3 leading-tight">Data per Kelas</h3>

                    <p class="text-sm text-blue-100 mt-2 leading-relaxed">
                        Pilih kelas untuk melihat daftar siswa dan hasil skriningnya.
                    </p>

                </div>

                @if($totalKelas > 0)
                    <div class="relative w-full md:w-72 flex-shrink-0">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94A3B8] pointer-events-none" style="font-size:18px">search</span>
                        <input id="cari-kelas" type="search" placeholder="Cari kelas, misalnya 7-1" aria-label="Cari kelas" autocomplete="off"
                            class="w-full h-11 pl-10 pr-4 rounded-[var(--r-field)] bg-white/95 text-sm font-medium text-[#14233B] placeholder:text-[#94A3B8] placeholder:font-normal border border-white/[.14] focus:outline-none focus:ring-4 focus:ring-white/35">

                    </div>
                @endif

            </div>

        </section>

        {{-- DAFTAR KELAS --}}
        <div class="space-y-5" id="daftar-kelas">

            @forelse($grup as $tingkat => $items)

                <section class="card p-5" data-grup>

                    <div class="flex items-center justify-between gap-3 mb-4">
                        <h4 class="h-title" style="font-size:.95rem">
                            {{ $bisaGrup ? 'Tingkat ' . $tingkat : 'Semua kelas' }}
                        </h4>
                        <span class="text-xs text-[#6B7A90]">
                            {{ $items->count() }} kelas · {{ (int) $items->sum('jumlah_siswa') }} siswa
                        </span>
                    </div>

                    <div class="grid grid-cols-1 min-[480px]:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-3">

                        @foreach($items as $k)
                            <a href="{{ route('kelas.detail', $k->kelas) }}"
                               data-kelas="{{ strtolower($k->kelas) }}"
                               class="kelas"
                               aria-label="Kelas {{ $k->kelas }}, {{ $k->jumlah_siswa }} siswa">

                                <span class="tile">
                                    <span class="material-symbols-outlined" style="font-size:20px">groups</span>
                                </span>

                                <span class="min-w-0">
                                    <span class="nama">Kelas {{ $k->kelas }}</span>
                                    <span class="jml">{{ $k->jumlah_siswa }} siswa</span>
                                </span>

                                <span class="material-symbols-outlined chev" style="font-size:20px">chevron_right</span>

                            </a>
                        @endforeach

                    </div>

                </section>

            @empty

                <div class="card text-center py-16 px-5">
                    <span class="material-symbols-outlined text-[#CBD5E1]" style="font-size:40px">groups</span>
                    <p class="text-sm font-semibold text-[#14233B] mt-2">Belum ada data siswa</p>
                    <p class="text-xs text-[#6B7A90] mt-1">Kelas akan muncul di sini setelah data siswa ditambahkan.</p>
                </div>

            @endforelse

            <div id="kelas-kosong" hidden class="card text-center py-14 px-5">
                <span class="material-symbols-outlined text-[#CBD5E1]" style="font-size:40px">search_off</span>
                <p class="text-sm font-semibold text-[#14233B] mt-2">Kelas tidak ditemukan</p>
                <p class="text-xs text-[#6B7A90] mt-1">Coba kata kunci lain, misalnya "7A".</p>
            </div>

        </div>

        <footer class="pt-4 border-t border-[#E3E8F0] flex justify-between items-center flex-wrap gap-2">
            <p class="text-xs text-[#6B7A90]">© 2026 SMPN 216 Jakarta — Portal Skrining Kesehatan Mental Siswa</p>
            <p class="text-xs text-[#6B7A90]">Powered by SDQ + Gaussian Naive Bayes</p>
        </footer>

    </div>

</main>

{{-- SEARCH --}}
<script>
    (function () {
        var input = document.getElementById('cari-kelas');
        if (!input) return;

        var items  = Array.from(document.querySelectorAll('[data-kelas]'));
        var kosong = document.getElementById('kelas-kosong');

        input.addEventListener('input', function () {
            var q   = input.value.trim().toLowerCase();
            var ada = 0;

            items.forEach(function (el) {
                var cocok = !q || el.dataset.kelas.indexOf(q) !== -1;
                el.hidden = !cocok;
                if (cocok) ada++;
            });

            document.querySelectorAll('[data-grup]').forEach(function (g) {
                g.hidden = !g.querySelector('[data-kelas]:not([hidden])');
            });

            kosong.hidden = ada > 0;
        });
    })();
</script>

</body>
</html>