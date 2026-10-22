<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kuesioner | SMPN 216 Jakarta</title>
    @php
        $logoUrl  = \App\Models\Pengaturan::url('logo', 'logo-smpn216.png');
        $adaFilter = request('cari') || request('label');
    @endphp
    <link rel="icon" type="image/png" href="{{ $logoUrl }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Source+Serif+4:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    @vite('resources/css/tema.css')
    <style>
        /* ============ Token: sama dengan Dashboard Super Admin ============ */
        /* Font dan ukuran font diatur oleh tema.css; CSS sidebar ada di partial sidebar_superadmin */
        :root {
            --bg: #F3F5F9; --ink: #14233B; --ink-2: #475569; --ink-3: #6B7A90; --line: #E3E8F0;
            --accent: #4B5FD6; --accent-soft: #ECEFFC; --accent-line: #C9D0F6; --accent-glow: #8D9BF0;
            /* Warna status: hijau = Normal, kuning = Borderline, merah = Abnormal */
            --ok: #0F8A5F;   --ok-bg: #E3F5ED;
            --warn: #B7690B; --warn-bg: #FDF1DC;
            --act: #C8303C;  --act-bg: #FDECEE;
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
        .card { background: #fff; border: 1px solid var(--line); border-radius: 14px; box-shadow: 0 1px 2px rgba(15,39,71,.05), 0 8px 24px -16px rgba(15,39,71,.18); }

        /* ---------- Filter ---------- */
        .lbl { display: block; margin-bottom: 6px; font-size: .75rem; font-weight: 600; color: var(--ink-2); }
        .input { width: 100%; height: 42px; padding: 0 14px; border: 1px solid var(--line); background: #fff; font-size: .84rem; color: var(--ink); transition: .15s; }
        .input::placeholder { color: #A3AEC0; }
        .input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 4px rgba(75,95,214,.12); }
        select.input { padding-right: 36px; appearance: none; -webkit-appearance: none;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236B7A90' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E") no-repeat right 12px center; }
        .btn-sa { display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 42px; padding: 0 20px;
                  background: var(--accent); color: #fff; font-size: .82rem; font-weight: 600; transition: .15s; box-shadow: 0 6px 14px -8px var(--accent); }
        .btn-sa:hover { background: #3E50BF; }
        .btn-sa:active { transform: scale(.98); }
        .link-reset { display: inline-flex; align-items: center; height: 42px; padding: 0 6px; font-size: .78rem; font-weight: 600; color: var(--ink-3); }
        .link-reset:hover { color: var(--accent); text-decoration: underline; }

        /* ---------- Tabel ---------- */
        .tbl { min-width: 760px; }
        .tbl th { padding: 12px 18px; text-align: left; font-size: .7rem; font-weight: 700; letter-spacing: .04em;
                  text-transform: uppercase; color: var(--ink-3); background: #F7F9FC; border-bottom: 1px solid var(--line); white-space: nowrap; }
        .tbl td { padding: 14px 18px; font-size: .82rem; border-bottom: 1px solid var(--line); vertical-align: middle; }
        .tbl tbody tr:hover { background: #FAFBFE; }
        .tbl tbody tr:last-child td { border-bottom: 0; }
        .avatar { width: 38px; height: 38px; border-radius: 50%; background: var(--accent-soft); color: var(--accent);
                  display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: .78rem; flex-shrink: 0; }
        .kelas-pill { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 999px; background: var(--accent-soft); color: var(--accent); font-size: .74rem; font-weight: 700; }
        .skor { font-size: .84rem; font-weight: 600; color: var(--ink); }
        .skor small { font-size: .72rem; font-weight: 400; color: var(--ink-3); }

        /* Badge status: hijau Normal, kuning Borderline, merah Abnormal */
        .badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 11px; border-radius: 999px; font-size: .74rem; font-weight: 700; white-space: nowrap; }
        .badge.ok   { background: var(--ok-bg);   color: var(--ok); }
        .badge.warn { background: var(--warn-bg); color: var(--warn); }
        .badge.act  { background: var(--act-bg);  color: var(--act); }
        .badge.none { background: #EDF1F7; color: #475569; }

        .icon-btn { width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--line); background: #fff; transition: .15s; }
        .icon-btn.edit:hover { background: var(--accent-soft); border-color: var(--accent-line); }
        .icon-btn.del:hover { background: var(--act-bg); border-color: #F2C4C4; }

        /* ---------- Pagination ---------- */
        .pg-wrap { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; padding: 14px 18px; border-top: 1px solid var(--line); background: #FBFCFE; }
        .pg-info { font-size: .78rem; color: var(--ink-3); }
        .pg-info b { color: var(--ink); font-weight: 700; }
        .pg-list { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
        .pg-btn { min-width: 36px; height: 36px; padding: 0 10px; display: inline-flex; align-items: center; justify-content: center;
                  border: 1px solid var(--line); background: #fff; font-size: .8rem; font-weight: 600; color: var(--ink-2); transition: .15s; }
        a.pg-btn:hover { background: var(--accent-soft); border-color: var(--accent-line); color: var(--accent); }
        .pg-btn.on { background: var(--accent); border-color: var(--accent); color: #fff; box-shadow: 0 6px 14px -8px var(--accent); }
        .pg-btn.off { color: #C3CCDA; background: #F7F9FC; cursor: not-allowed; }
        .pg-dots { padding: 0 4px; color: var(--ink-3); font-size: .8rem; }

        /* ---------- Header ---------- */
        .topbar::before { content: ''; position: absolute; left: 0; right: 0; top: 0; height: 3px; background: linear-gradient(90deg, #12143A 0%, var(--accent) 55%, #2B78E0 100%); }

        /* ---------- Mobile: tabel tetap tabel, geser ke samping ---------- */
        @media (max-width: 639px) {
            .tbl th { padding: 10px 14px; }
            .tbl td { padding: 12px 14px; }
            .pg-wrap { justify-content: center; text-align: center; padding: 14px 12px; }
            .pg-btn { min-width: 34px; height: 34px; padding: 0 8px; }
        }
        @media (prefers-reduced-motion: reduce) { .btn-sa, .input, .pg-btn, .icon-btn { transition: none !important; } }
    </style>
    <link rel="stylesheet" href="{{ asset('css/icons.css') }}">
    <script src="{{ asset('js/icons.js') }}" defer></script>
</head>
<body class="flex min-h-screen">
<div id="sidebar-overlay" onclick="closeSidebar()"></div>

{{-- ================= SIDEBAR ================= --}}
@include('partials.sidebar_superadmin')

{{-- ================= MAIN ================= --}}
<main class="flex-1 min-w-0 flex flex-col">
    <header class="topbar h-16 bg-white/90 backdrop-blur-md border-b border-[#E3E8F0] flex items-center px-4 md:px-8 sticky top-0 z-30">
        <div class="flex items-center gap-3 min-w-0">
            <button id="hamburger-btn" onclick="openSidebar()" aria-label="Buka menu"
                    class="w-9 h-9 flex-shrink-0 rounded-lg border border-[#E3E8F0] flex items-center justify-center hover:bg-[#ECEFFC] transition-colors lg:hidden">
                <span class="material-symbols-outlined text-[#475569]" style="font-size:20px">menu</span>
            </button>
            <div class="min-w-0">
                <h2 class="text-base md:text-lg font-bold text-[#14233B] leading-tight truncate">Data Kuesioner</h2>
                <p class="text-xs text-[#6B7A90] hidden sm:block">Seluruh hasil pengisian SDQ siswa</p>
            </div>
        </div>
    </header>

    <div class="flex-1 p-4 md:p-8 space-y-5 md:space-y-6 max-w-[1400px] w-full mx-auto">
        @if(session('success'))
        <div class="bg-[#E3F5ED] border border-[#A7F3D0] text-[#0F8A5F] text-sm font-semibold rounded-xl px-4 py-3" role="status">
            {{ session('success') }}
        </div>
        @endif

        {{-- ===== Filter ===== --}}
        <form method="GET" action="{{ route('superadmin.kuesioner.index') }}" class="card p-4 md:p-5 flex flex-wrap gap-3 items-end">
            <div class="w-full sm:w-auto sm:flex-1 sm:min-w-[180px]">
                <label for="cari" class="lbl">Cari nama</label>
                <input id="cari" type="text" name="cari" value="{{ request('cari') }}" placeholder="Nama siswa" autocomplete="off" class="input">
            </div>
            <div class="w-full sm:w-52">
                <label for="label" class="lbl">Hasil SDQ</label>
                <select id="label" name="label" class="input">
                    <option value="">Semua hasil</option>
                    <option value="Normal" {{ request('label') === 'Normal' ? 'selected' : '' }}>Normal</option>
                    <option value="Borderline" {{ request('label') === 'Borderline' ? 'selected' : '' }}>Borderline</option>
                    <option value="Abnormal" {{ request('label') === 'Abnormal' ? 'selected' : '' }}>Abnormal</option>
                </select>
            </div>
            <div class="w-full sm:w-auto flex items-center gap-2">
                <button type="submit" class="btn-sa flex-1 sm:flex-none">
                    <span class="material-symbols-outlined" style="font-size:18px">search</span>
                    Filter
                </button>
                @if($adaFilter)
                <a href="{{ route('superadmin.kuesioner.index') }}" class="link-reset">Reset</a>
                @endif
            </div>
        </form>

        {{-- ===== Tabel ===== --}}
        <section class="card overflow-hidden">
            <div class="overflow-x-auto scrollbar-thin">
                <table class="tbl w-full">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Total</th>
                            <th>Hasil SDQ</th>
                            <th>Keputusan akhir</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kuesionerList as $s)
                        @php
                            $kelasBadge = match($s->hasil_label) {
                                'Normal'     => 'ok',
                                'Borderline' => 'warn',
                                'Abnormal'   => 'act',
                                default      => 'none',
                            };
                            $keputusan = $s->keputusan_akhir ?? $s->hasil_label;
                            $kelasKep  = match($keputusan) {
                                'Normal'     => 'ok',
                                'Borderline' => 'warn',
                                'Abnormal'   => 'act',
                                default      => 'none',
                            };
                        @endphp
                        <tr>
                            <td>
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="avatar">{{ strtoupper(substr($s->nama, 0, 2)) }}</span>
                                    <span class="font-semibold text-[#14233B] whitespace-nowrap">{{ $s->nama }}</span>
                                </div>
                            </td>
                            <td>
                                @if($s->kelas)
                                    <span class="kelas-pill">{{ $s->kelas }}</span>
                                @else
                                    <span class="text-[#475569]">-</span>
                                @endif
                            </td>
                            <td class="skor">{{ $s->total_kesulitan }}<small>/40</small></td>
                            <td><span class="badge {{ $kelasBadge }}">{{ $s->hasil_label ?: '-' }}</span></td>
                            <td><span class="badge {{ $kelasKep }}">{{ $keputusan ?: '-' }}</span></td>
                            <td class="text-xs text-[#6B7A90] whitespace-nowrap">{{ $s->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="flex justify-start gap-2">
                                    <a href="{{ route('superadmin.kuesioner.detail', $s->id) }}" class="icon-btn edit" title="Lihat detail" aria-label="Lihat detail {{ $s->nama }}">
                                        <span class="material-symbols-outlined text-[#4B5FD6]" style="font-size:17px">visibility</span>
                                    </a>
                                    {{-- Nama dan tanggal lewat data-attribute supaya tanda petik tidak merusak konfirmasi --}}
                                    <form method="POST" action="{{ route('superadmin.kuesioner.destroy', $s->id) }}"
                                          data-nama="{{ $s->nama }}" data-tanggal="{{ $s->created_at->format('d/m/Y') }}"
                                          onsubmit="return confirm('Hapus data kuesioner ' + this.dataset.nama + ' tanggal ' + this.dataset.tanggal + '?\n\nData yang dihapus tidak bisa dikembalikan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-btn del" title="Hapus" aria-label="Hapus data {{ $s->nama }}">
                                            <span class="material-symbols-outlined" style="font-size:17px;color:var(--act)">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-16">
                                <span class="material-symbols-outlined text-[#CBD5E1]" style="font-size:40px">{{ $adaFilter ? 'search_off' : 'quiz' }}</span>
                                <p class="text-sm font-semibold text-[#14233B] mt-2">{{ $adaFilter ? 'Data kuesioner tidak ditemukan' : 'Belum ada data kuesioner' }}</p>
                                <p class="text-xs text-[#6B7A90] mt-1">{{ $adaFilter ? 'Coba ubah kelas atau hasil SDQ.' : 'Hasil pengisian SDQ siswa akan muncul di sini.' }}</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($kuesionerList->total() > 0)
            @php
                $kuesionerList->withQueryString();
                $hal   = $kuesionerList->currentPage();
                $akhir = $kuesionerList->lastPage();

                // Nomor halaman yang ditampilkan: pertama, terakhir, dan sekitar halaman aktif
                $nomor = collect([1, $akhir, $hal - 1, $hal, $hal + 1])
                    ->filter(fn ($n) => $n >= 1 && $n <= $akhir)
                    ->unique()->sort()->values();
            @endphp
            <nav class="pg-wrap" aria-label="Navigasi halaman">
                <p class="pg-info">
                    Menampilkan <b>{{ $kuesionerList->firstItem() }}–{{ $kuesionerList->lastItem() }}</b>
                    dari <b>{{ number_format($kuesionerList->total()) }}</b> pengisian
                </p>
                @if($kuesionerList->hasPages())
                <div class="pg-list">
                    @if($kuesionerList->onFirstPage())
                        <span class="pg-btn off" aria-disabled="true"><span class="material-symbols-outlined" style="font-size:18px">chevron_left</span></span>
                    @else
                        <a href="{{ $kuesionerList->previousPageUrl() }}" class="pg-btn" rel="prev" aria-label="Halaman sebelumnya"><span class="material-symbols-outlined" style="font-size:18px">chevron_left</span></a>
                    @endif

                    @foreach($nomor as $i => $n)
                        @if($i > 0 && $n - $nomor[$i - 1] > 1)
                            <span class="pg-dots">…</span>
                        @endif
                        @if($n === $hal)
                            <span class="pg-btn on" aria-current="page">{{ $n }}</span>
                        @else
                            <a href="{{ $kuesionerList->url($n) }}" class="pg-btn" aria-label="Halaman {{ $n }}">{{ $n }}</a>
                        @endif
                    @endforeach

                    @if($kuesionerList->hasMorePages())
                        <a href="{{ $kuesionerList->nextPageUrl() }}" class="pg-btn" rel="next" aria-label="Halaman berikutnya"><span class="material-symbols-outlined" style="font-size:18px">chevron_right</span></a>
                    @else
                        <span class="pg-btn off" aria-disabled="true"><span class="material-symbols-outlined" style="font-size:18px">chevron_right</span></span>
                    @endif
                </div>
                @endif
            </nav>
            @endif
        </section>

        <footer class="pt-4 border-t border-[#E3E8F0] flex flex-col sm:flex-row sm:justify-between items-center text-center gap-1 sm:gap-2">
            <p class="text-xs text-[#6B7A90]">© {{ date('Y') }} SMPN 216 Jakarta — Portal Skrining Kesehatan Mental Siswa</p>
            <p class="text-xs text-[#6B7A90]">Super Admin Panel</p>
        </footer>
    </div>
</main>

{{-- openSidebar() dan closeSidebar() sudah ada di partials.sidebar_superadmin --}}
</body>
</html>