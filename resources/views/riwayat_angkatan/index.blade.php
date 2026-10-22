<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Riwayat Angkatan | SMPN 216 Jakarta</title>
    <link rel="icon" type="image/png" href="{{ \App\Models\Pengaturan::url('logo', 'logo-smpn216.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Source+Serif+4:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    @vite('resources/css/tema.css')

    <style>
        :root {
            --navy: #0F2747;
            --brand: #1D5FBF;
            --brand-soft: #E8F0FB;
            --bg: #F3F5F9;
            --ink: #14233B;
            --ink-2: #475569;
            --ink-3: #6B7A90;
            --line: #E3E8F0;

            /* Warna status: hijau = Normal, kuning = Borderline, merah = Abnormal */
            --ok: #0F8A5F;
            --ok-bg: #E3F5ED;
            --warn: #B7690B;
            --warn-bg: #FDF1DC;
            --act: #C8303C;
            --act-bg: #FDECEE;
        }

        body {
            font-family: var(--font-sans);
            color: var(--ink);
            background:
                radial-gradient(
                    900px 400px at 85% -80px,
                    #DCE8FA 0%,
                    transparent 70%
                ),
                var(--bg);
            background-attachment: fixed;
        }

        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24;
        }

        :focus-visible {
            outline: 2px solid var(--brand);
            outline-offset: 2px;
        }

        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 99px;
        }

        /* =========================================================
           Komponen halaman
           ========================================================= */

        .card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 14px;
            box-shadow:
                0 1px 2px rgba(15,39,71,.05),
                0 8px 24px -16px rgba(15,39,71,.18);
        }

        .ico {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: var(--brand-soft);
            color: var(--brand);
        }

        .h-title {
            font-size: .9rem;
            font-weight: 700;
            color: var(--ink);
        }

        .h-sub {
            font-size: .75rem;
            color: var(--ink-3);
            margin-top: 2px;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .b-ok {
            background: var(--ok-bg);
            color: var(--ok);
        }

        .b-warn {
            background: var(--warn-bg);
            color: var(--warn);
        }

        .b-act {
            background: var(--act-bg);
            color: var(--act);
        }

        .b-brand {
            background: var(--brand-soft);
            color: var(--brand);
        }

        /* =========================================================
           Banner ringkasan
           ========================================================= */

        .hero {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            padding: 28px;
            color: #fff;
            background:
                linear-gradient(
                    120deg,
                    #0B1F3A 0%,
                    #15407F 55%,
                    #2B78E0 100%
                );
            box-shadow:
                0 18px 40px -18px rgba(21,64,127,.65);
        }

        .hero-ring {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,.14);
            pointer-events: none;
        }

        .hero-ring.r1 {
            width: 380px;
            height: 380px;
            right: -90px;
            top: -150px;
            background:
                radial-gradient(
                    circle,
                    rgba(255,255,255,.12),
                    transparent 70%
                );
        }

        .hero-ring.r2 {
            width: 230px;
            height: 230px;
            right: 190px;
            bottom: -130px;
        }

        .meta {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 10px;
            background: rgba(255,255,255,.14);
            border: 1px solid rgba(255,255,255,.22);
            font-size: .75rem;
            line-height: 1.2;
        }

        /* =========================================================
           Daftar angkatan
           ========================================================= */

        .year-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1px solid transparent;
            transition:
                background .15s,
                border-color .15s;
        }

        .year-row:hover {
            background: #F7F9FC;
            border-color: #B9D0F2;
        }

        .year-row:hover .chev {
            color: var(--brand);
            transform: translateX(2px);
        }

        .chev {
            color: #94A3B8;
            transition:
                color .15s,
                transform .15s;
        }

        .year-badge {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: var(--brand-soft);
            color: var(--brand);
        }

        @media (prefers-reduced-motion: reduce) {
            .year-row,
            .chev {
                transition: none !important;
            }
        }

        /* =========================================================
           Perapian tampilan mobile
           ========================================================= */

        @media (max-width: 639px) {
            .hero {
                padding: 22px 18px;
                border-radius: 16px;
            }

            .hero-ring.r1 {
                width: 260px;
                height: 260px;
                right: -100px;
                top: -110px;
            }

            .hero-ring.r2 {
                display: none;
            }

            .meta {
                flex: 1 1 auto;
                justify-content: center;
            }

            .card {
                border-radius: 12px;
            }

            .year-row {
                padding: 12px;
                gap: 10px;
            }

            .year-badge {
                width: 40px;
                height: 40px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/icons.css') }}">
    <script src="{{ asset('js/icons.js') }}" defer></script>
</head>

<body class="flex min-h-screen">

@php
    $totalAngkatan = $riwayat->count();
    $totalSiswa    = (int) $riwayat->sum('jumlah_siswa');
@endphp

@include('partials.sidebar_dashboard_gurubk')

<main class="flex-1 min-w-0 flex flex-col">

    <header class="h-16 bg-white/90 backdrop-blur-md border-b border-[#E3E8F0] flex items-center justify-between px-4 md:px-8 sticky top-0 z-30">

        <div class="flex items-center gap-3 min-w-0">

            <button
                id="hamburger-btn"
                onclick="openSidebar()"
                aria-label="Buka menu"
                class="w-9 h-9 rounded-lg border border-[#E3E8F0] flex items-center justify-center hover:bg-[#E8F0FB] transition-colors lg:hidden flex-shrink-0"
            >
                <span
                    class="material-symbols-outlined text-[#475569]"
                    style="font-size:20px"
                >
                    menu
                </span>
            </button>

            <div class="truncate">

                <h2 class="text-base md:text-lg font-bold text-[#14233B] truncate leading-tight">
                    Riwayat Angkatan
                </h2>

                <p class="text-xs text-[#6B7A90] truncate">
                    Data siswa yang telah lulus
                </p>

            </div>

        </div>

    </header>

    <div class="flex-1 p-4 md:p-8 space-y-5 md:space-y-6 max-w-6xl w-full mx-auto">

        {{-- ============ Banner ringkasan ============ --}}

        <section class="hero">

            <div class="hero-ring r1"></div>
            <div class="hero-ring r2"></div>

            <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-5">

                <div class="min-w-0">

                    <h3 class="text-2xl md:text-3xl font-extrabold leading-tight">
                        Riwayat Angkatan
                    </h3>

                    <p class="text-sm text-blue-100 mt-2 leading-relaxed max-w-xl">
                        Arsip siswa yang telah lulus, dikelompokkan berdasarkan angkatan (tahun masuk). Data hasil skrining tetap tersimpan.
                    </p>

                </div>

                <div class="flex flex-wrap gap-2 flex-shrink-0">

                    <span class="meta">
                        <span
                            class="material-symbols-outlined"
                            style="font-size:16px"
                        >
                            calendar_month
                        </span>

                        {{ $totalAngkatan }} angkatan
                    </span>

                    <span class="meta">
                        <span
                            class="material-symbols-outlined"
                            style="font-size:16px"
                        >
                            school
                        </span>

                        {{ $totalSiswa }} siswa lulus
                    </span>

                </div>

            </div>

        </section>

        {{-- ============ Daftar angkatan ============ --}}

        <section
            class="card overflow-hidden"
            aria-labelledby="judul-arsip"
        >

            <div class="px-4 sm:px-5 md:px-6 py-4 border-b border-[#E3E8F0] flex items-center gap-3 bg-[#F7F9FC]">

                <span class="ico">
                    <span
                        class="material-symbols-outlined"
                        style="font-size:20px"
                    >
                        history
                    </span>
                </span>

                <div>

                    <h4
                        id="judul-arsip"
                        class="h-title"
                    >
                        Arsip Angkatan
                    </h4>

                    <p class="h-sub">
                        Pilih angkatan untuk melihat data siswa
                    </p>

                </div>

            </div>

            @if($riwayat->count() > 0)

                <div class="p-2 md:p-3 space-y-1">

                    @foreach($riwayat as $item)

                        <a
                            href="{{ route('riwayat.angkatan.detail', ['angkatan' => $item->angkatan]) }}"
                            class="year-row"
                        >

                            <div class="flex items-center gap-3.5 min-w-0">

                                <span class="year-badge">

                                    <span
                                        class="material-symbols-outlined"
                                        style="font-size:22px"
                                    >
                                        calendar_month
                                    </span>

                                </span>

                                <div class="min-w-0">

                                    <p class="text-sm font-bold text-[#14233B] truncate">
                                        Angkatan {{ $item->angkatan }}
                                    </p>

                                    <p class="text-xs text-[#6B7A90] mt-0.5">
                                        Masuk {{ $item->angkatan }},
                                        lulus {{ (int) $item->angkatan + 3 }}
                                    </p>

                                </div>

                            </div>

                            <div class="flex items-center gap-2 flex-shrink-0">

                                <span class="badge b-brand">
                                    {{ $item->jumlah_siswa }} siswa
                                </span>

                                <span
                                    class="material-symbols-outlined chev"
                                    style="font-size:22px"
                                >
                                    chevron_right
                                </span>

                            </div>

                        </a>

                    @endforeach

                </div>

            @else

                <div class="text-center py-14 px-5">

                    <span
                        class="ico mx-auto mb-3"
                        style="width:56px;height:56px;border-radius:50%"
                    >
                        <span
                            class="material-symbols-outlined"
                            style="font-size:28px"
                        >
                            history
                        </span>
                    </span>

                    <p class="text-sm font-bold text-[#14233B]">
                        Belum ada riwayat angkatan
                    </p>

                    <p class="text-[13px] leading-relaxed text-[#475569] mt-1 max-w-sm mx-auto">
                        Data akan muncul setelah siswa ditandai sebagai lulus.
                    </p>

                </div>

            @endif

        </section>

        <footer class="pt-4 border-t border-[#E3E8F0] flex justify-between items-center flex-wrap gap-2">

            <p class="text-xs text-[#6B7A90]">
                © 2026 SMPN 216 Jakarta — Portal Skrining Kesehatan Mental Siswa
            </p>

            <p class="text-xs text-[#6B7A90]">
                Powered by SDQ + Gaussian Naive Bayes
            </p>

        </footer>

    </div>

</main>

</body>
</html>