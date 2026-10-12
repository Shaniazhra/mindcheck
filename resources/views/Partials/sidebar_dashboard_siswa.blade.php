{{-- Sidebar Siswa: dipakai semua halaman siswa lewat @include('partials.sidebar_dashboard_siswa') --}}
{{-- CSS sidebar umum ada di tema.css --}}

<aside id="sidebar" aria-label="Navigasi utama">

    <a href="{{ url('/') }}"
       title="Lihat halaman beranda"
       class="flex items-center gap-3 px-2 py-1 hover:opacity-90 transition-opacity">

        <div class="w-11 h-11 overflow-hidden flex-shrink-0">
            <img src="{{ \App\Models\Pengaturan::url('logo', 'logo-smpn216.png') }}"
                 alt="Logo SMPN 216"
                 class="w-full h-full object-contain">
        </div>

        <div class="leading-tight min-w-0">
            <h1 class="text-[16px] font-semibold text-white">SMPN 216 Jakarta</h1>
            <p class="text-[12px] text-[#9FB3CF] mt-0.5">Skrining Kesehatan Mental</p>
        </div>

    </a>

    <nav class="flex-1 overflow-y-auto scrollbar-thin mt-2">

        <p class="nav-label">Menu utama</p>

        <a href="/dashboard-siswa"
           class="nav-link {{ request()->is('dashboard-siswa') ? 'active' : '' }}">
            <span class="material-symbols-outlined" style="font-size:21px">home</span>
            Beranda
        </a>

        <p class="nav-label">Skrining</p>

        <a href="/sdq"
           class="nav-link {{ request()->is('sdq') ? 'active' : '' }}">
            <span class="material-symbols-outlined" style="font-size:21px">assignment</span>
            Isi Kuesioner SDQ
        </a>

        <a href="/hasil-skrining"
           class="nav-link {{ request()->is('hasil-skrining') ? 'active' : '' }}">
            <span class="material-symbols-outlined" style="font-size:21px">clinical_notes</span>
            Hasil Skrining
        </a>

    </nav>

    <div class="side-user">

        <div class="w-10 h-10 rounded-full bg-[#3B7DDD] flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        </div>

        <div class="overflow-hidden min-w-0">
            <p class="text-sm font-semibold truncate text-white">{{ Auth::user()->name }}</p>
            <p class="text-xs text-[#9FB3CF] truncate">Siswa, Kelas {{ Auth::user()->kelas }}</p>
        </div>

        <form method="POST" action="/logout" class="ml-auto">
            @csrf
            <button type="submit" title="Keluar" aria-label="Keluar" class="logout">
                <span class="material-symbols-outlined" style="font-size:19px">logout</span>
            </button>
        </form>

    </div>

</aside>