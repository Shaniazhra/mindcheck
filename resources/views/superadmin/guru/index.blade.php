<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Guru BK | SMPN 216 Jakarta</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $logoUrl  = \App\Models\Pengaturan::url('logo', 'logo-smpn216.png');
        $sekarang = now('Asia/Jakarta')->locale('id');
    @endphp
    <link rel="icon" type="image/png" href="{{ $logoUrl }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Source+Serif+4:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/tema.css')
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <style>
        /* ============ Token: keluarga warna sama dengan Dashboard Super Admin ============ */
        /* Font dan ukuran font diatur oleh tema.css, jadi tidak diulang di sini */
        :root {
            --navy: #0F2747; --brand: #1D5FBF; --brand-soft: #E8F0FB; --bg: #F3F5F9;
            --ink: #14233B; --ink-2: #475569; --ink-3: #6B7A90; --line: #E3E8F0;

            /* Pembeda Super Admin: keluarga indigo */
            --ind-950: #12143A;
            --ind-900: #1A1D52;
            --accent: #4B5FD6;
            --accent-soft: #ECEFFC;
            --accent-line: #C9D0F6;
            --accent-glow: #8D9BF0;
        }
        [hidden] { display: none !important; }
        body {
            color: var(--ink);
            background: radial-gradient(900px 420px at 90% -100px, #E1E6FA 0%, transparent 70%), var(--bg);
            background-attachment: fixed;
        }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        :focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }
        .scrollbar-thin::-webkit-scrollbar { width: 6px; height: 6px; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 99px; }

        /* ---------- Komponen dasar ---------- */
        .card { background: #fff; border: 1px solid var(--line); border-radius: 14px; box-shadow: 0 1px 2px rgba(15,39,71,.05), 0 8px 24px -16px rgba(15,39,71,.18); }
        .ico { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: var(--accent-soft); color: var(--accent); }
        .h-title { font-size: .9rem; font-weight: 700; color: var(--ink); }
        .h-sub { font-size: .75rem; color: var(--ink-3); margin-top: 2px; }

        .btn-sa { display: inline-flex; align-items: center; gap: 8px; height: 40px; padding: 0 16px; border-radius: 11px;
                  background: var(--accent); color: #fff; font-size: .82rem; font-weight: 600; transition: .15s;
                  box-shadow: 0 6px 14px -8px var(--accent); }
        .btn-sa:hover { background: #3E50BF; }
        .icon-btn { width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border-radius: 9px;
                    border: 1px solid var(--line); background: #fff; transition: .15s; }
        .icon-btn.edit:hover { background: var(--accent-soft); border-color: var(--accent-line); }
        .icon-btn.del:hover { background: #FBE9E9; border-color: #F2C4C4; }

        /* ---------- Header ---------- */
        .topbar::before { content: ''; position: absolute; left: 0; right: 0; top: 0; height: 3px; background: linear-gradient(90deg, var(--ind-950) 0%, var(--accent) 55%, #2B78E0 100%); }

        /* ---------- Banner: busur tipis ---------- */
        .hero { position: relative; overflow: hidden; border-radius: 20px; padding: 28px; color: #fff;
                background: linear-gradient(125deg, #0E1030 0%, #1A1D52 50%, #3B4BC0 100%); box-shadow: 0 18px 40px -18px rgba(40,50,160,.6); }
        .hero::before { content: ''; position: absolute; inset: 0; pointer-events: none;
            background: repeating-radial-gradient(circle at 100% 0%, transparent 0, transparent 54px, rgba(255,255,255,.06) 54px, rgba(255,255,255,.06) 55px);
            -webkit-mask-image: linear-gradient(100deg, transparent 35%, #000 100%); mask-image: linear-gradient(100deg, transparent 35%, #000 100%); }
        .hero::after { content: ''; position: absolute; width: 420px; height: 420px; right: -120px; top: -170px; border-radius: 50%; pointer-events: none;
            background: radial-gradient(circle, rgba(141,155,240,.42), transparent 68%); }
        .hero > .in { position: relative; z-index: 1; }
        .hero-chip { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 8px; background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2); font-size: .74rem; font-weight: 600; letter-spacing: .03em; }

        /* ---------- Tabel ---------- */
        .tbl th { padding: 12px 18px; text-align: left; font-size: .7rem; font-weight: 700; letter-spacing: .04em;
                  text-transform: uppercase; color: var(--ink-3); background: #F7F9FC; border-bottom: 1px solid var(--line); white-space: nowrap; }
        .tbl td { padding: 14px 18px; font-size: .82rem; border-bottom: 1px solid var(--line); vertical-align: middle; }
        .tbl tbody tr:hover { background: #FAFBFE; }
        .tbl tbody tr:last-child td { border-bottom: 0; }
        .avatar { width: 38px; height: 38px; border-radius: 50%; background: var(--accent-soft); color: var(--accent);
                  display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: .8rem; flex-shrink: 0; }

        @media (max-width: 479px) {
            .hero { padding: 22px 18px; }
        }
    </style>
</head>

<body class="flex min-h-screen">

<div id="sidebar-overlay" onclick="closeSidebar()"></div>

@include('partials.sidebar_superadmin')

{{-- ================= MAIN ================= --}}
<main class="flex-1 min-w-0 flex flex-col">

    <header class="topbar h-16 bg-white/90 backdrop-blur-md border-b border-[#E3E8F0] flex items-center justify-between px-4 md:px-8 sticky top-0 z-30">
        <div class="flex items-center gap-3">
            <button id="hamburger-btn" onclick="openSidebar()" aria-label="Buka menu"
                    class="w-9 h-9 rounded-lg border border-[#E3E8F0] flex items-center justify-center hover:bg-[#ECEFFC] transition-colors lg:hidden">
                <span class="material-symbols-outlined text-[#475569]" style="font-size:20px">menu</span>
            </button>
            <div>
                <h2 class="text-base md:text-lg font-bold text-[#14233B] leading-tight">Data Guru BK</h2>
                <p class="text-xs text-[#6B7A90] hidden sm:block">Kelola akun Guru Bimbingan Konseling</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-medium text-[#475569] hidden md:flex items-center gap-2 px-3 py-2 rounded-lg bg-[#F3F5F9] border border-[#E3E8F0]">
                <span class="material-symbols-outlined" style="font-size:16px">calendar_today</span>
                {{ $sekarang->isoFormat('dddd, D MMMM Y') }}
            </span>
            <a href="{{ route('superadmin.guru.create') }}" class="btn-sa">
                <span class="material-symbols-outlined" style="font-size:18px">add</span>
                <span class="hidden sm:inline">Tambah Guru BK</span>
            </a>
        </div>
    </header>

    <div class="flex-1 p-4 md:p-8 space-y-6 max-w-[1400px] w-full mx-auto">

        @if(session('success'))
        <div class="bg-[#E3F5ED] border border-[#A7F3D0] text-[#0F8A5F] text-sm font-semibold rounded-xl px-4 py-3" role="status">
            {{ session('success') }}
        </div>
        @endif

        {{-- ===== Banner ===== --}}
        <section class="hero">
            <div class="in flex flex-col md:flex-row md:items-end justify-between gap-5">
                <div class="min-w-0 max-w-2xl">
                    <span class="hero-chip">
                        <span class="material-symbols-outlined" style="font-size:16px">groups</span>
                        {{ $guruList->count() }} AKUN GURU BK
                    </span>
                    <h3 class="text-2xl md:text-3xl font-semibold mt-3 leading-tight">Data Guru BK</h3>
                    <p class="text-[13.5px] text-indigo-100 mt-2 leading-relaxed">
                        Tambah, ubah, atau hapus akun Guru Bimbingan Konseling yang mengelola hasil skrining siswa.
                    </p>
                </div>

                @if($guruList->count() > 0)
                <div class="relative w-full md:w-72 flex-shrink-0">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94A3B8] pointer-events-none" style="font-size:18px">search</span>
                    <input id="cari-guru" type="search" placeholder="Cari nama, NIP, atau email" aria-label="Cari Guru BK" autocomplete="off"
                           class="w-full h-11 pl-10 pr-4 rounded-xl bg-white/95 text-[13.5px] font-medium text-[#14233B] placeholder:text-[#94A3B8] placeholder:font-normal border border-transparent focus:outline-none focus:ring-4 focus:ring-white/35">
                </div>
                @endif
            </div>
        </section>

        {{-- ===== Tabel ===== --}}
        <section class="card overflow-hidden">

            <div class="flex items-center gap-3 px-5 py-4 border-b border-[#E3E8F0]">
                <div class="ico"><span class="material-symbols-outlined" style="font-size:20px">badge</span></div>
                <div>
                    <h4 class="h-title">Daftar akun Guru BK</h4>
                    <p class="h-sub">Akun yang dapat meninjau hasil skrining dan menulis laporan BK</p>
                </div>
            </div>

            <div class="overflow-x-auto scrollbar-thin">
                <table class="tbl w-full" style="min-width:680px">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Email</th>
                            <th>Terdaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guruList as $guru)
                        <tr data-cari="{{ strtolower($guru->name . ' ' . ($guru->nip ?? '') . ' ' . $guru->email) }}">
                            <td>
                                <div class="flex items-center gap-3">
                                    <span class="avatar">{{ strtoupper(substr($guru->name, 0, 2)) }}</span>
                                    <span class="font-semibold text-[#14233B]">{{ $guru->name }}</span>
                                </div>
                            </td>
                            <td class="text-[#475569]">{{ $guru->nip ?: '-' }}</td>
                            <td class="text-[#475569]">{{ $guru->email }}</td>
                            <td class="text-xs text-[#6B7A90] whitespace-nowrap">{{ $guru->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="flex justify-start gap-2">
                                    <a href="{{ route('superadmin.guru.edit', $guru->id) }}" class="icon-btn edit" title="Edit" aria-label="Edit {{ $guru->name }}">
                                        <span class="material-symbols-outlined text-[#4B5FD6]" style="font-size:17px">edit</span>
                                    </a>
                                    {{-- Nama lewat data-nama supaya tanda petik di nama tidak merusak konfirmasi --}}
                                    <form method="POST" action="{{ route('superadmin.guru.destroy', $guru->id) }}"
                                          data-nama="{{ $guru->name }}"
                                          onsubmit="return confirm('Hapus akun Guru BK ' + this.dataset.nama + '?\n\nAkun ini tidak akan bisa login lagi.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-btn del" title="Hapus" aria-label="Hapus {{ $guru->name }}">
                                            <span class="material-symbols-outlined text-red-500" style="font-size:17px">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-16">
                                <span class="material-symbols-outlined text-[#CBD5E1]" style="font-size:40px">groups</span>
                                <p class="text-sm font-semibold text-[#14233B] mt-2">Belum ada akun Guru BK</p>
                                <p class="text-xs text-[#6B7A90] mt-1">Klik "Tambah Guru BK" untuk membuat akun pertama.</p>
                            </td>
                        </tr>
                        @endforelse

                        <tr id="guru-kosong" hidden>
                            <td colspan="5" class="text-center py-14">
                                <span class="material-symbols-outlined text-[#CBD5E1]" style="font-size:40px">search_off</span>
                                <p class="text-sm font-semibold text-[#14233B] mt-2">Guru BK tidak ditemukan</p>
                                <p class="text-xs text-[#6B7A90] mt-1">Coba kata kunci lain.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <footer class="pt-4 border-t border-[#E3E8F0] flex justify-between items-center flex-wrap gap-2">
            <p class="text-xs text-[#6B7A90]">© {{ date('Y') }} SMPN 216 Jakarta — Portal Skrining Kesehatan Mental Siswa</p>
            <p class="text-xs text-[#6B7A90]">Super Admin Panel</p>
        </footer>

    </div>
</main>

{{-- openSidebar() dan closeSidebar() sudah ada di partials.sidebar_superadmin --}}
<script>
    // Cari guru (nama, NIP, email)
    (function () {
        var input = document.getElementById('cari-guru');
        if (!input) return;
        var rows = Array.from(document.querySelectorAll('tr[data-cari]'));
        var kosong = document.getElementById('guru-kosong');

        input.addEventListener('input', function () {
            var q = input.value.trim().toLowerCase();
            var ada = 0;
            rows.forEach(function (r) {
                var cocok = !q || r.dataset.cari.indexOf(q) !== -1;
                r.hidden = !cocok;
                if (cocok) ada++;
            });
            kosong.hidden = ada > 0;
        });
    })();
</script>

</body>
</html>