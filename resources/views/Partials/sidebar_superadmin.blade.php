@vite('resources/css/tema.css')

@php
    $logoSidebar = \App\Models\Pengaturan::url('logo');

    $menuSuperAdmin = [
        [
            'judul' => 'Menu Utama',
            'items' => [
                [
                    'label' => 'Dashboard',
                    'icon' => 'dashboard',
                    'route' => 'superadmin.dashboard',
                    'match' => ['superadmin.dashboard'],
                ],
            ],
        ],
        [
            'judul' => 'Manajemen data',
            'items' => [
                [
                    'label' => 'Data Guru BK',
                    'icon' => 'groups',
                    'route' => 'superadmin.guru.index',
                    'match' => ['superadmin.guru.*'],
                ],
                [
                    'label' => 'Data Siswa',
                    'icon' => 'school',
                    'route' => 'superadmin.siswa.index',
                    'match' => ['superadmin.siswa.*'],
                ],
                [
                    'label' => 'Data Kuesioner',
                    'icon' => 'fact_check',
                    'route' => 'superadmin.kuesioner.index',
                    'match' => ['superadmin.kuesioner.*'],
                ],
            ],
        ],
        [
            'judul' => 'Pengaturan',
            'items' => [
                [
                    'label' => 'Tampilan Portal',
                    'icon' => 'web',
                    'route' => 'superadmin.pengaturan.index',
                    'match' => ['superadmin.pengaturan.*'],
                ],
            ],
        ],
    ];
@endphp

<style>
    :root {
        --sa-width: 270px; /* ubah angka ini jika lebar sidebar perlu disamakan */
        --sa-sidebar: #12143A;
        --sa-sidebar-2: #1A1D52;
        --sa-accent: #4B5FD6;
        --sa-accent-light: #8D9BF0;
        --sa-text: #E8EBFF;
        --sa-muted: #A5ADD0;
        --sa-line: rgba(255,255,255,.09);
    }

    #sidebar-overlay {
        display: block; /* tema.css menyembunyikan dengan display:none */
        position: fixed;
        inset: 0;
        z-index: 40;
        background: rgba(10, 15, 40, .58);
        backdrop-filter: blur(3px);
        -webkit-backdrop-filter: blur(3px);
        opacity: 0;
        visibility: hidden;
        transition: opacity .25s ease, visibility .25s ease;
    }

    #sidebar-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    #sidebar {
        position: fixed;
        inset: 0 auto 0 0;
        z-index: 50;
        display: flex;
        flex-direction: column;
        width: min(var(--sa-width), 86vw);
        height: 100dvh;
        padding: 0; /* tema.css memberi padding sendiri, di sini tidak dipakai */
        overflow: hidden;
        color: var(--sa-text);
        background:
            radial-gradient(350px 240px at -15% -5%, rgba(75,95,214,.30), transparent 70%),
            linear-gradient(180deg, var(--sa-sidebar) 0%, #15173F 55%, #10122F 100%);
        border-right: 1px solid rgba(255,255,255,.08);
        box-shadow: 16px 0 40px -30px rgba(0,0,0,.5);
        -webkit-tap-highlight-color: transparent;

        /* Tertutup: tidak bisa difokus lewat keyboard / pembaca layar */
        visibility: hidden;
        transform: translateX(-105%);
        transition: transform .28s cubic-bezier(.2,.7,.2,1), visibility 0s linear .28s;
    }

    /* Matikan cahaya biru bawaan tema.css, sidebar ini punya gradiennya sendiri */
    #sidebar::after {
        content: none;
    }

    #sidebar.open {
        visibility: visible;
        transform: translateX(0);
        transition: transform .28s cubic-bezier(.2,.7,.2,1), visibility 0s;
    }

    /* Brand: logo + teks, jarak mengikuti sidebar Guru BK */
    .sa-brand {
        position: relative;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 22px 14px 0;
        padding: 4px 8px 14px;
        border-bottom: 1px solid var(--sa-line);
    }

    .sa-brand::after {
        content: "";
        position: absolute;
        bottom: -1px;
        left: 8px;
        width: 58px;
        height: 2px;
        border-radius: 99px;
        background: linear-gradient(90deg, var(--sa-accent), var(--sa-accent-light));
    }

    .sa-brand-link {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
        min-width: 0;
    }

    /* Background logo dihilangkan */
    .sa-brand-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 44px;
        height: 44px;
        padding: 0;
        overflow: hidden;
        background: transparent;
        border: 0;
        border-radius: 0;
        box-shadow: none;
    }

    .sa-brand-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .sa-brand-text {
        display: block;
        min-width: 0;
    }

    /* Font mengikuti tema.css: judul serif 16px/600, subjudul 12px */
    .sa-brand-name {
        display: block;
        overflow: hidden;
        color: #fff;
        font-family: var(--font-serif);
        font-size: 16px;
        font-weight: 600;
        line-height: 1.25;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .sa-brand-caption {
        display: block;
        overflow: hidden;
        margin-top: 2px;
        color: #A9B2DC;
        font-family: var(--font-sans);
        font-size: 12px;
        line-height: 1.3;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    /* Badge Super Admin */
    .sa-badge {
        display: inline-flex;
        align-items: center;
        align-self: flex-start;
        gap: 6px;
        margin: 14px 14px 0;
        padding: 6px 12px;
        color: #D5DAFF;
        background: rgba(255,255,255,.07);
        border: 1px solid rgba(255,255,255,.16);
        border-radius: 8px;
        font-family: var(--font-sans);
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
        line-height: 1;
    }

    .sa-nav {
        flex: 1;
        min-height: 0;
        padding: 0 14px 16px;
        margin-top: 8px;
        overflow-y: auto;
        overflow-x: hidden; /* cegah scrollbar horizontal (garis putih) saat hover menu */
        overscroll-behavior: contain; /* scroll menu tidak ikut menggulung halaman di belakang */
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: rgba(255,255,255,.16) transparent;
    }

    .sa-nav::-webkit-scrollbar {
        width: 5px;
    }

    .sa-nav::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,.16);
        border-radius: 99px;
    }

    /* Judul kategori: sama dengan .nav-label di sidebar Guru BK */
    .sa-nav-heading {
        display: block;
        padding: 0 12px;
        margin: 22px 0 8px;
        color: #7F97B8;
        font-family: var(--font-sans);
        font-size: 12px;
        font-weight: 600;
    }

    .sa-nav-link {
        position: relative;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 12px;
        margin: 0 0 4px;
        color: #B7BEDC;
        font-family: var(--font-sans);
        font-size: 13.5px;
        font-weight: 500;
        border: 1px solid transparent;
        border-radius: var(--r-field, 10px);
        transition: color .18s ease, background .18s ease,
                    border-color .18s ease, transform .18s ease;
    }

    .sa-nav-link > span:last-child {
        min-width: 0;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .sa-nav-link .sa-nav-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 23px;
        height: 23px;
        flex-shrink: 0;
        color: #8F99C8;
        transition: color .18s ease;
    }

    .sa-nav-link .sa-nav-icon .material-symbols-outlined {
        font-size: 21px;
    }

    .sa-nav-link:active {
        background: rgba(255,255,255,.09);
    }

    /* Efek hover hanya di perangkat yang punya kursor (di HP tidak "menempel") */
    @media (hover: hover) {
        .sa-nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,.065);
            border-color: rgba(255,255,255,.07);
            transform: translateX(2px);
        }

        .sa-nav-link:hover .sa-nav-icon {
            color: #B8C0FF;
        }
    }

    .sa-nav-link.active {
        color: #fff;
        font-weight: 600;
        background: linear-gradient(100deg, rgba(75,95,214,.31), rgba(75,95,214,.12));
        border-color: rgba(141,155,240,.25);
        box-shadow: inset 3px 0 0 var(--sa-accent-light);
    }

    .sa-nav-link.active .sa-nav-icon {
        color: #B8C0FF;
    }

    .sa-sidebar-bottom {
        flex-shrink: 0;
        padding: 12px 12px calc(14px + env(safe-area-inset-bottom, 0px));
        background: rgba(8,10,32,.22);
        border-top: 1px solid var(--sa-line);
    }

    .sa-logout {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        min-height: 44px;
        padding: 9px 12px;
        color: #F3B9C1;
        background: rgba(239,68,68,.07);
        border: 1px solid rgba(248,113,113,.17);
        border-radius: var(--r-field, 10px);
        font-family: var(--font-sans);
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        transition: background .18s ease, border-color .18s ease;
    }

    .sa-logout:hover,
    .sa-logout:active {
        color: #fff;
        background: rgba(220,38,38,.2);
        border-color: rgba(248,113,113,.4);
    }

    .sa-sidebar-version {
        margin-top: 10px;
        color: #737DA6;
        font-family: var(--font-sans);
        font-size: 12px;
        text-align: center;
        letter-spacing: .03em;
    }

    /* Fokus keyboard yang jelas dengan warna indigo */
    #sidebar a:focus-visible,
    #sidebar button:focus-visible {
        outline: 2px solid var(--sa-accent-light);
        outline-offset: 2px;
    }

    /* Desktop: sidebar menetap di sisi kiri */
    @media (min-width: 1024px) {
        #sidebar {
            position: sticky;
            top: 0;
            flex: 0 0 var(--sa-width);
            width: var(--sa-width);
            height: 100vh;
            visibility: visible;
            transform: none;
            box-shadow: none;
        }

        #sidebar-overlay {
            display: none;
        }
    }

    /* HP dengan layar pendek (mode landscape): beri ruang lebih untuk menu */
    @media (max-height: 560px) {
        .sa-sidebar-version {
            display: none;
        }

        .sa-brand {
            margin-top: 14px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        #sidebar,
        #sidebar-overlay,
        .sa-nav-link,
        .sa-nav-link .sa-nav-icon,
        .sa-logout {
            transition: none !important;
        }
    }
</style>

<aside id="sidebar" aria-label="Navigasi Super Admin">
    <div class="sa-brand">
        <a href="{{ Route::has('superadmin.dashboard') ? route('superadmin.dashboard') : url('/') }}"
           class="sa-brand-link"
           aria-label="Dashboard Super Admin">
            @if($logoSidebar)
                <span class="sa-brand-logo">
                    <img src="{{ $logoSidebar }}" alt="Logo SMPN 216 Jakarta">
                </span>
            @else
                <span class="sa-brand-logo">
                    <span class="material-symbols-outlined" style="font-size:30px;color:#8D9BF0">school</span>
                </span>
            @endif

            <span class="sa-brand-text">
                <span class="sa-brand-name">SMPN 216 Jakarta</span>
                <span class="sa-brand-caption">Sistem Informasi MindCheck</span>
            </span>
        </a>
    </div>

    <span class="sa-badge">
        <span class="material-symbols-outlined" style="font-size:14px">shield_person</span>
        Super Admin
    </span>

    <nav class="sa-nav" aria-label="Menu utama">
        @foreach($menuSuperAdmin as $grup)
            <div class="sa-nav-group">
                <span class="sa-nav-heading">{{ $grup['judul'] }}</span>

                @foreach($grup['items'] as $item)
                    @php
                        $routeTersedia = \Illuminate\Support\Facades\Route::has($item['route']);
                        $aktif = collect($item['match'])
                            ->contains(fn ($pattern) => request()->routeIs($pattern));
                    @endphp

                    @if($routeTersedia)
                        <a href="{{ route($item['route']) }}"
                           class="sa-nav-link {{ $aktif ? 'active' : '' }}"
                           @if($aktif) aria-current="page" @endif>
                            <span class="sa-nav-icon">
                                <span class="material-symbols-outlined">{{ $item['icon'] }}</span>
                            </span>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        @endforeach
    </nav>

    <div class="sa-sidebar-bottom">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sa-logout">
                <span class="material-symbols-outlined" style="font-size:18px">logout</span>
                Keluar dari akun
            </button>
        </form>

        <div class="sa-sidebar-version">
            MINDCHECK · SMPN 216 JAKARTA
        </div>
    </div>
</aside>

<script>
    function openSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        if (!sidebar || !overlay) return;

        sidebar.classList.add('open');
        overlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        if (!sidebar || !overlay) return;

        sidebar.classList.remove('open');
        overlay.classList.remove('show');
        document.body.style.overflow = '';
    }

    // Tanpa tombol X, sidebar ditutup dengan menyentuh area gelap di luar sidebar
    (function () {
        const overlay = document.getElementById('sidebar-overlay');
        if (overlay) overlay.addEventListener('click', closeSidebar);
    })();

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') closeSidebar();
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth >= 1024) closeSidebar();
    });
</script>