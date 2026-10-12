{{-- Sidebar Guru BK untuk dashboard: @include('partials.sidebar_dashboard_gurubk') --}}
{{-- Jarak/ukuran (padding sidebar, menu, kartu user) mengikuti tema.css seperti sidebar Guru BK. --}}
{{-- Warna latar sidebar, cahaya, dan label menu memakai biru bawaan tema.css. --}}

<style>
    #sidebar-overlay {
        background: rgba(15, 39, 71, .5);
        backdrop-filter: blur(3px);
        -webkit-backdrop-filter: blur(3px);
    }

    #sidebar {
        border-right: 1px solid rgba(255,255,255,.08);
    }

    /* Hilangkan scrollbar horizontal (garis putih) saat hover menu */
    #sidebar nav {
        overflow-x: hidden;
    }

    /* Logo + nama sekolah, garis di bawahnya */
    #sidebar a.gb-brand {
        position: relative;
        padding-bottom: 14px;
        border-bottom: 1px solid rgba(255,255,255,.09);
    }

    #sidebar a.gb-brand::after {
        content: "";
        position: absolute;
        left: 8px;
        bottom: -1px;
        width: 58px;
        height: 2px;
        border-radius: 99px;
        background: linear-gradient(90deg, #5B9DF5, #8FBBFA);
    }

    #sidebar .nav-link {
        color: #B7C7DD;
        border: 1px solid transparent;
        transition: color .18s ease, background .18s ease,
                    border-color .18s ease, transform .18s ease;
    }

    #sidebar .nav-link .material-symbols-outlined {
        color: #93A9C9;
        transition: color .18s ease;
    }

    #sidebar .nav-link:hover {
        color: #fff;
        background: rgba(255,255,255,.065);
        border-color: rgba(255,255,255,.07);
        transform: translateX(2px);
    }

    #sidebar .nav-link:hover .material-symbols-outlined {
        color: #8FBBFA;
    }

    #sidebar .nav-link.active {
        color: #fff;
        background: linear-gradient(100deg, rgba(91,157,245,.32), rgba(91,157,245,.08));
        border-color: rgba(143,187,250,.25);
        box-shadow: inset 3px 0 0 #8FBBFA;
    }

    /* Penanda aktif: garis kiri bawaan tema dimatikan, diganti garis tepi dalam di atas */
    #sidebar .nav-link.active::before {
        content: none;
    }

    #sidebar .nav-link.active .material-symbols-outlined {
        color: #8FBBFA;
    }

    #sidebar .side-user {
        background: rgba(255,255,255,.055);
        border: 1px solid rgba(255,255,255,.085);
        border-radius: 14px;
    }

    #sidebar .side-user .logout {
        color: #9FB3CF;
    }

    .gb-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        background: linear-gradient(145deg, #5B9DF5, #3B7DDD);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 12px;
        box-shadow: 0 5px 14px rgba(59,125,221,.25);
    }

    @media (prefers-reduced-motion: reduce) {
        #sidebar .nav-link {
            transition: none !important;
        }
    }
</style>

@php
    $adaTahun = \Illuminate\Support\Facades\Route::has('riwayat.angkatan.index');
    $onTahun = $adaTahun && request()->routeIs('riwayat.angkatan*');
    $onRiwayat = !$onTahun && (request()->is('riwayat') || request()->is('riwayat/*'));
@endphp

<div id="sidebar-overlay" onclick="closeSidebar()"></div>

<aside id="sidebar" aria-label="Navigasi utama">

    <a href="{{ url('/') }}"
       title="Lihat halaman beranda"
       class="gb-brand flex items-center gap-3 px-2 py-1 hover:opacity-90 transition-opacity">

        {{-- Tanpa background logo --}}
        <div class="w-11 h-11 overflow-hidden flex-shrink-0">
            <img src="{{ \App\Models\Pengaturan::url('logo', 'logo-smpn216.png') }}"
                 alt="Logo SMPN 216"
                 class="w-full h-full object-contain">
        </div>

        <div class="leading-tight min-w-0">
            <h1 class="text-[16px] font-semibold text-white">SMPN 216 Jakarta</h1>
            <p class="text-[12px] text-[#9FB3CF] mt-0.5">
                Skrining Kesehatan Mental
            </p>
        </div>
    </a>

    <nav class="flex-1 overflow-y-auto scrollbar-thin mt-2">

        {{-- Kategori: Menu utama --}}
        <p class="nav-label">Menu utama</p>

        <a href="/dashboard"
           class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <span class="material-symbols-outlined" style="font-size:21px">
                dashboard
            </span>
            Dashboard
        </a>

        {{-- Kategori: Skrining --}}
        <p class="nav-label">Skrining</p>

        <a href="/riwayat"
           class="nav-link {{ $onRiwayat ? 'active' : '' }}">
            <span class="material-symbols-outlined" style="font-size:21px">
                clinical_notes
            </span>
            Riwayat Skrining
        </a>

        {{-- Kategori: Data siswa --}}
        <p class="nav-label">Data siswa</p>

        <a href="{{ route('kelas.index') }}"
           class="nav-link {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
            <span class="material-symbols-outlined" style="font-size:21px">
                groups
            </span>
            Data per Kelas
        </a>

        {{-- Menu Tahun Angkatan --}}
        @if($adaTahun)
            <a href="{{ route('riwayat.angkatan.index') }}"
               class="nav-link {{ $onTahun ? 'active' : '' }}">
                <span class="material-symbols-outlined" style="font-size:21px">
                    school
                </span>
                Tahun Angkatan
            </a>
        @endif

    </nav>

    <div class="side-user">

        <div class="gb-avatar">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        </div>

        <div class="overflow-hidden min-w-0">
            <p class="text-sm font-semibold truncate text-white">
                {{ Auth::user()->name }}
            </p>

            <p class="text-xs text-[#9FB3CF] truncate">
                Guru BK
            </p>
        </div>

        <form method="POST" action="/logout" class="ml-auto">
            @csrf

            <button type="submit"
                    title="Keluar"
                    aria-label="Keluar"
                    class="logout">
                <span class="material-symbols-outlined" style="font-size:19px">
                    logout
                </span>
            </button>
        </form>

    </div>

</aside>

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

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            closeSidebar();
        }
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            closeSidebar();
        }
    });
</script>