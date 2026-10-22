<!DOCTYPE html>
<html lang="id">
<head>
    <title>Riwayat Skrining | SMPN 216 Jakarta</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ \App\Models\Pengaturan::url('logo', 'logo-smpn216.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,500;8..60,600;8..60,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/tema.css')
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

        body {
            color: var(--ink);
            background: radial-gradient(900px 400px at 85% -80px, #DCE8FA 0%, transparent 70%), var(--bg);
            background-attachment: fixed;
        }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        :focus-visible { outline: 2px solid var(--brand); outline-offset: 2px; }
        [hidden] { display: none !important; }

        .scrollbar-thin::-webkit-scrollbar { width: 6px; height: 6px; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 99px; }

        /* ---------- Komponen ---------- */
        .card { background: #fff; border: 1px solid var(--line); border-radius: 14px; box-shadow: 0 1px 2px rgba(15,39,71,.05), 0 8px 24px -16px rgba(15,39,71,.18); }
        .ico { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: var(--brand-soft); color: var(--brand); }
        .h-title { font-weight: 700; color: var(--ink); }
        .h-sub { color: var(--ink-3); margin-top: 2px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 999px; font-weight: 700; white-space: nowrap; }
        .b-ok   { background: var(--ok-bg);   color: var(--ok); }
        .b-warn { background: var(--warn-bg); color: var(--warn); }
        .b-act  { background: var(--act-bg);  color: var(--act); }
        .b-ai   { background: var(--ai-bg);   color: var(--ai); }
        .b-none { background: #E8ECF2; color: var(--ink-2); }

        .btn-line { display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px; border: 1px solid var(--line); background: #fff; font-weight: 600; color: var(--brand); transition: .15s; }
        .btn-line:hover { background: var(--brand-soft); border-color: #B9D0F2; }
        .btn-primary { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 0 18px; height: 40px; background: var(--brand); color: #fff; font-weight: 600; transition: .15s; box-shadow: 0 6px 14px -8px var(--brand); }
        .btn-primary:hover { background: #174C99; }
        .field { height: 40px; border: 1px solid var(--line); background: #fff; color: var(--ink-2); width: 100%; }
        .field:focus { outline: none; border-color: var(--brand); box-shadow: 0 0 0 4px rgba(29,95,191,.12); }
        .lbl { display: block; font-weight: 600; color: var(--ink-3); margin-bottom: 6px; }

        .pg { width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--line); background: #fff; font-weight: 500; color: var(--ink-2); transition: .15s; }
        a.pg:hover { background: var(--brand-soft); color: var(--brand); }
        .pg.on { background: var(--brand); border-color: var(--brand); color: #fff; font-weight: 700; }
        .pg.off { background: #F7F9FC; color: #C5CEDB; cursor: not-allowed; }

        /* ---------- Banner ---------- */
        .hero {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            padding: 28px;
            color: #fff;
            background: linear-gradient(120deg, #0B1F3A 0%, #15407F 55%, #2B78E0 100%);
            box-shadow: 0 18px 40px -18px rgba(21,64,127,.65);
        }
        .hero-ring { position: absolute; border-radius: 50%; border: 1px solid rgba(255,255,255,.14); pointer-events: none; }
        .hero-ring.r1 { width: 380px; height: 380px; right: -90px; top: -150px; background: radial-gradient(circle, rgba(255,255,255,.12), transparent 70%); }
        .hero-ring.r2 { width: 230px; height: 230px; right: 190px; bottom: -130px; }
        .hero-chip { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 999px; background: rgba(255,255,255,.14); border: 1px solid rgba(255,255,255,.22); font-weight: 600; }

        /* ---------- Tabel ---------- */
        #tabel-riwayat { min-width: 1080px; }
        #tabel-riwayat th { padding: 12px 18px; text-align: left; font-weight: 700; color: var(--ink-2); background: #F7F9FC; border-bottom: 1px solid var(--line); white-space: nowrap; }
        #tabel-riwayat td { padding: 14px 18px; vertical-align: middle; }
        tr.row-risiko  { background: #F3FAFE; }
        tr.row-risiko:hover  { background: #E8F4FB !important; }
        tr.row-risiko td:first-child  { box-shadow: inset 3px 0 0 var(--ai); }
        tr.row-anomali { background: #FFFBEB; }
        tr.row-anomali:hover { background: #FEF3C7 !important; }
        tr.row-anomali td:first-child { box-shadow: inset 3px 0 0 #F59E0B; }
        tr.row-biasa:hover { background: #F8FAFD; }

        .sc { display: inline-block; min-width: 38px; text-align: center; padding: 3px 7px; border-radius: 7px; font-weight: 700; background: #EEF1F6; color: var(--ink-2); }
        .sc.hi  { background: var(--act-bg);  color: var(--act); }
        .sc.mid { background: var(--warn-bg); color: var(--warn); }
        .avatar { width: 38px; height: 38px; border-radius: 50%; background: var(--brand-soft); border: 1px solid #D5E3F7; display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--brand); flex-shrink: 0; }

        /* ---------- Perapian tampilan mobile ---------- */
        @media (max-width: 639px) {
            .hero { padding: 22px 18px; border-radius: 16px; }
            .hero-ring.r1 { width: 260px; height: 260px; right: -100px; top: -110px; }
            .hero-ring.r2 { display: none; }
            .card { border-radius: 12px; }
            #tabel-riwayat th { padding: 10px 14px; }
            #tabel-riwayat td { padding: 12px 14px; }
            .legend-skor { gap: 8px 16px; }
        }

        @media print {
            header, form, nav, .no-print { display: none !important; }
            body { background: #fff; }
            .card { box-shadow: none; }
        }
    </style>
</head>
<body class="flex min-h-screen">

@php
    $sekarang  = now('Asia/Jakarta')->locale('id');
    $adaFilter = request()->hasAny(['nama', 'kelas', 'status', 'risiko_ai']);

    // $daftarKelas dari controller berisi teks biasa (hasil pluck), bukan objek.
    // collect()->map(...) di bawah juga aman kalau suatu saat berisi objek ber-properti "kelas".
    $opsiKelas = collect($daftarKelas ?? [])
        ->map(fn ($k) => is_object($k) ? $k->kelas : $k)
        ->filter()
        ->values();

    // Tautan halaman dengan filter tetap terbawa
    $pageUrl = fn ($p) => url('/riwayat') . '?' . http_build_query(array_merge(request()->except('page'), ['page' => $p]));

    // Chip filter aktif
    $filterAktif = [];
    if (request('nama'))      $filterAktif['nama']      = 'Nama: ' . request('nama');
    if (request('kelas'))     $filterAktif['kelas']     = 'Kelas: ' . request('kelas');
    if (request('status'))    $filterAktif['status']    = 'Status: ' . request('status');
    if (request('risiko_ai')) $filterAktif['risiko_ai'] = 'Risiko AI: ' . (request('risiko_ai') === 'YES' ? 'Berisiko' : 'Aman');

    $hapusFilter = function ($key) {
        $q = http_build_query(request()->except([$key, 'page']));
        return url('/riwayat') . ($q ? '?' . $q : '');
    };

    // Warna skor subskala: [batas tinggi]; Prososial dibaca terbalik
    $skor = function ($nilai, $batas) {
        return (int) $nilai >= $batas ? 'hi' : '';
    };
@endphp

@include('partials.sidebar_dashboard_gurubk')

{{-- ================= MAIN ================= --}}
<main class="flex-1 min-w-0 flex flex-col">
 <header class="h-16 bg-white/90 backdrop-blur-md border-b border-[#E3E8F0] flex items-center justify-between px-4 md:px-8 sticky top-0 z-30">
        <div class="flex items-center gap-3">
            <button id="hamburger-btn" onclick="openSidebar()" aria-label="Buka menu"
                class="w-9 h-9 rounded-lg border border-[#E3E8F0] flex items-center justify-center hover:bg-[#E8F0FB] transition-colors lg:hidden">
                <span class="material-symbols-outlined text-[#475569]" style="font-size:20px">menu</span>
            </button>
            <div>
                <h2 class="text-base md:text-lg font-bold text-[#14233B] leading-tight">Riwayat Skrining</h2>
                <p class="text-xs text-[#6B7A90] hidden sm:block">Semua data SDQ dan analisis AI</p>
            </div>
        </div>
        <span class="text-xs font-medium text-[#475569] hidden sm:flex items-center gap-2 px-3 py-2 rounded-lg bg-[#F3F5F9] border border-[#E3E8F0]">
            <span class="material-symbols-outlined" style="font-size:16px">calendar_today</span>
            {{ $sekarang->isoFormat('dddd, D MMMM Y') }}
        </span>
    </header>

    <div class="flex-1 p-4 md:p-8 space-y-5 md:space-y-6 max-w-[1400px] w-full mx-auto">

        {{-- ===== Banner ===== --}}
        <section class="hero">
            <div class="hero-ring r1"></div><div class="hero-ring r2"></div>
            <div class="relative max-w-2xl">
                <span class="hero-chip">
                    <span class="material-symbols-outlined" style="font-size:16px">clinical_notes</span>
                    {{ $hasilSdq->total() }} data skrining{{ $adaFilter ? ' (difilter)' : '' }}
                </span>
                <h3 class="text-2xl md:text-3xl font-extrabold mt-3 leading-tight">Riwayat Skrining</h3>
                <p class="text-sm text-blue-100 mt-2 leading-relaxed">Telusuri hasil SDQ setiap siswa. Gunakan filter untuk mempersempit berdasarkan nama, kelas, status, atau risiko dari AI.</p>
            </div>
        </section>

        {{-- ===== Filter ===== --}}
        <form method="GET" action="/riwayat" class="card p-4 md:p-5 no-print">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-end">

                <div class="lg:col-span-4">
                    <label for="f-nama" class="lbl">Nama siswa</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94A3B8] pointer-events-none" style="font-size:18px">search</span>
                        <input id="f-nama" type="text" name="nama" value="{{ request('nama') }}" placeholder="Cari nama siswa..." class="field pl-10 pr-4">
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <label for="f-kelas" class="lbl">Kelas</label>
                    <select id="f-kelas" name="kelas" class="field px-3 cursor-pointer">
                        <option value="">Semua kelas</option>
                        @foreach($opsiKelas as $k)
                            <option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="lg:col-span-2">
                    <label for="f-status" class="lbl">Status SDQ</label>
                    <select id="f-status" name="status" class="field px-3 cursor-pointer">
                        <option value="">Semua status</option>
                        <option value="Normal"     {{ request('status') == 'Normal'     ? 'selected' : '' }}>Normal</option>
                        <option value="Borderline" {{ request('status') == 'Borderline' ? 'selected' : '' }}>Borderline</option>
                        <option value="Abnormal"   {{ request('status') == 'Abnormal'   ? 'selected' : '' }}>Abnormal</option>
                    </select>
                </div>

                <div class="lg:col-span-2">
                    <label for="f-risiko" class="lbl">Risiko AI</label>
                    <select id="f-risiko" name="risiko_ai" class="field px-3 cursor-pointer">
                        <option value="">Semua</option>
                        <option value="YES" {{ request('risiko_ai') == 'YES' ? 'selected' : '' }}>Berisiko</option>
                        <option value="NO"  {{ request('risiko_ai') == 'NO'  ? 'selected' : '' }}>Aman</option>
                    </select>
                </div>

                <div class="lg:col-span-2 flex items-center gap-3 sm:col-span-2">
                    <button type="submit" class="btn-primary flex-1">
                        <span class="material-symbols-outlined" style="font-size:18px">filter_list</span>
                        Terapkan
                    </button>
                    @if($adaFilter)
                        <a href="/riwayat" class="text-sm font-medium text-[#6B7A90] hover:text-[#14233B] transition-colors">Reset</a>
                    @endif
                </div>
            </div>

            @if($adaFilter)
            <div class="mt-4 pt-4 border-t border-[#E3E8F0] flex flex-wrap items-center gap-2">
                <span class="text-xs text-[#6B7A90]">Filter aktif:</span>
                @foreach($filterAktif as $key => $label)
                    <a href="{{ $hapusFilter($key) }}" title="Hapus filter ini"
                       class="inline-flex items-center gap-1 pl-2.5 pr-1.5 py-1 rounded-full bg-[#E8F0FB] border border-[#CFE0F7] text-xs font-semibold text-[#174E9E] hover:bg-[#DCE8FA] transition-colors">
                        {{ $label }}
                        <span class="material-symbols-outlined" style="font-size:14px">close</span>
                    </a>
                @endforeach
            </div>
            @endif
        </form>

        {{-- ===== Tabel ===== --}}
        <section class="card overflow-hidden">
            <div class="px-4 sm:px-5 md:px-6 py-4 md:py-5 border-b border-[#E3E8F0] flex items-center justify-between flex-wrap gap-3">
                <div class="flex items-start gap-3">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">table_chart</span></span>
                    <div>
                        <h4 class="h-title" style="font-size:1rem">Semua Data Skrining</h4>
                        <p class="h-sub">
                            @if($adaFilter)
                                <strong class="text-[#14233B]">{{ $hasilSdq->total() }}</strong> data cocok dengan filter
                            @else
                                Total <strong class="text-[#14233B]">{{ $hasilSdq->total() }}</strong> data tersimpan
                            @endif
                        </p>
                    </div>
                </div>
                <span class="text-xs text-[#6B7A90]">Halaman {{ $hasilSdq->currentPage() }} dari {{ $hasilSdq->lastPage() }}</span>
            </div>

            {{-- Keterangan --}}
            <div class="legend-skor px-4 sm:px-5 md:px-6 py-3 bg-[#F7F9FC] border-b border-[#E3E8F0] flex flex-wrap items-center gap-x-6 gap-y-2 text-[11px] text-[#6B7A90]">
                <span class="flex flex-wrap items-center gap-x-3 gap-y-1">
                    <span class="font-semibold text-[#475569]">Skor:</span>
                    <span><strong class="text-[#14233B]">E</strong> Emosional</span>
                    <span><strong class="text-[#14233B]">C</strong> Perilaku</span>
                    <span><strong class="text-[#14233B]">H</strong> Hiperaktivitas</span>
                    <span><strong class="text-[#14233B]">P</strong> Teman sebaya</span>
                    <span><strong class="text-[#14233B]">Pr</strong> Prososial</span>
                </span>
                <span class="flex flex-wrap items-center gap-x-4 gap-y-1">
                    <span class="flex items-center gap-1.5"><span class="w-1 h-3.5 rounded-sm bg-[#0A78B5] inline-block"></span>Terdeteksi risiko oleh AI</span>
                    <span class="flex items-center gap-1.5"><span class="w-1 h-3.5 rounded-sm bg-[#F59E0B] inline-block"></span>SDQ normal tetapi AI berisiko</span>
                </span>
            </div>

            <div class="overflow-x-auto scrollbar-thin">
                <table id="tabel-riwayat" class="w-full text-sm">
                    <thead>
                        <tr>
                            <th style="width:48px">No</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Skor SDQ</th>
                            <th>Status SDQ</th>
                            <th>Naive Bayes</th>
                            <th>Keputusan</th>
                            <th>Risiko AI</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E3E8F0]">
                        @forelse($hasilSdq as $i => $s)
                        @php
                            $isRisikoAI = ($s->risiko_ai ?? '') === 'YES';
                            $isAnomali  = $isRisikoAI && $s->hasil_label === 'Normal';
                            $rowClass   = $isAnomali ? 'row-anomali' : ($isRisikoAI ? 'row-risiko' : 'row-biasa');
                            $nis        = $s->user?->nis ?: '-';
                            $tgl        = $s->created_at->copy()->timezone('Asia/Jakarta')->locale('id');
                            $keputusan  = $s->keputusan_akhir ?? $s->hasil_label;

                            $sdqBadge = match($s->hasil_label) {
                                'Normal' => 'b-ok', 'Borderline' => 'b-warn', 'Abnormal' => 'b-act', default => 'b-none',
                            };
                            $nbBadge = match($s->hasil_naive_bayes ?? '') {
                                'Normal' => 'b-ok', 'Borderline' => 'b-warn', 'High Risk' => 'b-act', default => 'b-none',
                            };
                            $kaBadge = match($keputusan) {
                                'Normal' => 'b-ok', 'Borderline' => 'b-warn', 'High Risk', 'Abnormal' => 'b-act', default => 'b-none',
                            };
                        @endphp
                        <tr class="{{ $rowClass }} transition-colors">
                            <td class="text-xs text-[#6B7A90]">{{ ($hasilSdq->currentPage() - 1) * $hasilSdq->perPage() + $i + 1 }}</td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <span class="avatar">{{ strtoupper(substr($s->nama ?? 'S', 0, 2)) }}</span>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-[#14233B] flex items-center gap-1">
                                            {{ $s->nama }}
                                            @if($isAnomali)
                                                <span class="material-symbols-outlined text-[#D97706]" style="font-size:15px;font-variation-settings:'FILL' 1" title="SDQ normal tetapi AI mendeteksi risiko">warning</span>
                                            @elseif($isRisikoAI)
                                                <span class="material-symbols-outlined text-[#0A78B5]" style="font-size:15px;font-variation-settings:'FILL' 1" title="Risiko terdeteksi oleh AI">psychology</span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-[#6B7A90] mt-0.5">NIS {{ $nis }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-[#475569] font-medium whitespace-nowrap">{{ $s->kelas }}</td>
                            <td>
                                <div class="flex flex-nowrap items-center gap-1 mb-1.5 whitespace-nowrap">
                                    <span class="sc {{ $skor($s->skor_emotional, 7) }}" title="Emosional">E:{{ $s->skor_emotional }}</span>
                                    <span class="sc {{ $skor($s->skor_conduct, 5) }}" title="Perilaku">C:{{ $s->skor_conduct }}</span>
                                    <span class="sc {{ $skor($s->skor_hyperactivity, 6) }}" title="Hiperaktivitas">H:{{ $s->skor_hyperactivity }}</span>
                                    <span class="sc {{ $skor($s->skor_peer, 5) }}" title="Teman sebaya">P:{{ $s->skor_peer }}</span>
                                    <span class="sc {{ (int) $s->skor_prosocial <= 4 ? 'mid' : '' }}" title="Prososial">Pr:{{ $s->skor_prosocial }}</span>
                                </div>
                                <p class="text-xs text-[#6B7A90] whitespace-nowrap">Total <strong class="text-[#14233B]">{{ $s->total_kesulitan }}/40</strong></p>
                            </td>
                            <td><span class="badge {{ $sdqBadge }}">{{ $s->hasil_label }}</span></td>
                            <td>
                                @if($s->hasil_naive_bayes)
                                    <span class="badge {{ $nbBadge }}">{{ $s->hasil_naive_bayes }}</span>
                                @else
                                    <span class="text-xs text-[#6B7A90]">-</span>
                                @endif
                            </td>
                            <td><span class="badge {{ $kaBadge }}">{{ $keputusan }}</span></td>
                            <td>
                                @if($isRisikoAI)
                                    <span class="badge b-ai">Berisiko</span>
                                @elseif(($s->risiko_ai ?? '') === 'NO')
                                    <span class="badge b-ok">Aman</span>
                                @else
                                    <span class="text-xs text-[#6B7A90]">-</span>
                                @endif
                            </td>
                            <td class="text-xs text-[#475569] whitespace-nowrap">
                                {{ $tgl->translatedFormat('j M Y') }}
                                <span class="block text-[#94A3B8] mt-0.5">{{ $tgl->format('H.i') }} WIB</span>
                            </td>
                            <td>
                                <a href="/riwayat/{{ $s->id }}" class="btn-line">
                                    Detail
                                    <span class="material-symbols-outlined" style="font-size:15px">chevron_right</span>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="px-5 py-16 text-center">
                                <span class="material-symbols-outlined text-[#CBD5E1]" style="font-size:40px">search_off</span>
                                <p class="text-sm font-semibold text-[#14233B] mt-2">Tidak ada data yang cocok</p>
                                <p class="text-xs text-[#6B7A90] mt-1">Coba ubah kata kunci atau filter yang dipakai.</p>
                                @if($adaFilter)
                                    <a href="/riwayat" class="inline-block mt-4 text-xs font-semibold text-[#1D5FBF] hover:underline">Reset semua filter</a>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginasi --}}
            <div class="px-4 sm:px-5 md:px-6 py-4 border-t border-[#E3E8F0] flex items-center justify-center sm:justify-between flex-wrap gap-3 no-print">
                <p class="text-xs text-[#6B7A90] text-center sm:text-left">
                    @if($hasilSdq->total() > 0)
                        Menampilkan <span class="font-bold text-[#14233B]">{{ $hasilSdq->firstItem() }}–{{ $hasilSdq->lastItem() }}</span>
                        dari <span class="font-bold text-[#14233B]">{{ $hasilSdq->total() }}</span> data
                    @else
                        Tidak ada data
                    @endif
                </p>

                @if($hasilSdq->lastPage() > 1)
                <nav class="flex items-center justify-center gap-1.5 flex-wrap" aria-label="Paginasi riwayat skrining">
                    @if($hasilSdq->onFirstPage())
                        <span class="pg off"><span class="material-symbols-outlined" style="font-size:18px">chevron_left</span></span>
                    @else
                        <a href="{{ $pageUrl($hasilSdq->currentPage() - 1) }}" class="pg" aria-label="Halaman sebelumnya">
                            <span class="material-symbols-outlined" style="font-size:18px">chevron_left</span>
                        </a>
                    @endif

                    @for($page = 1; $page <= $hasilSdq->lastPage(); $page++)
                        @if($page == $hasilSdq->currentPage())
                            <span class="pg on" aria-current="page">{{ $page }}</span>
                        @elseif($page == 1 || $page == $hasilSdq->lastPage() || abs($page - $hasilSdq->currentPage()) <= 1)
                            <a href="{{ $pageUrl($page) }}" class="pg">{{ $page }}</a>
                        @elseif(abs($page - $hasilSdq->currentPage()) == 2)
                            <span class="w-8 h-8 flex items-center justify-center text-xs text-[#94A3B8]">…</span>
                        @endif
                    @endfor

                    @if($hasilSdq->hasMorePages())
                        <a href="{{ $pageUrl($hasilSdq->currentPage() + 1) }}" class="pg" aria-label="Halaman berikutnya">
                            <span class="material-symbols-outlined" style="font-size:18px">chevron_right</span>
                        </a>
                    @else
                        <span class="pg off"><span class="material-symbols-outlined" style="font-size:18px">chevron_right</span></span>
                    @endif
                </nav>
                @endif
            </div>
        </section>

        <footer class="pt-4 border-t border-[#E3E8F0] flex justify-between items-center flex-wrap gap-2">
            <p class="text-xs text-[#6B7A90]">© 2026 SMPN 216 Jakarta — Portal Skrining Kesehatan Mental Siswa</p>
            <p class="text-xs text-[#6B7A90]">Powered by SDQ + Gaussian Naive Bayes</p>
        </footer>

    </div>
</main>

</body>
</html>