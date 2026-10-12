<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kuesioner — SMPN 216 Jakarta</title>
    @php
        $logoUrl = \App\Models\Pengaturan::url('logo', 'logo-smpn216.png');
    @endphp
    <link rel="icon" type="image/png" href="{{ $logoUrl }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Source+Serif+4:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    @vite('resources/css/tema.css')
    <style>
        /* ============ Token: sama dengan Dashboard Super Admin dan Data Kuesioner ============ */
        /* Font dan ukuran font diatur oleh tema.css; CSS sidebar ada di partial sidebar_superadmin */
        :root {
            --bg: #F3F5F9; --ink: #14233B; --ink-2: #475569; --ink-3: #6B7A90; --line: #E3E8F0;
            --accent: #4B5FD6; --accent-soft: #ECEFFC; --accent-line: #C9D0F6; --accent-glow: #8D9BF0;
            /* Warna status: hijau = Normal, kuning = Borderline, merah = Abnormal */
            --ok: #0F8A5F;   --ok-bg: #E3F5ED;
            --warn: #B7690B; --warn-bg: #FDF1DC;
            --act: #C8303C;  --act-bg: #FDECEE;
        }
        body {
            color: var(--ink);
            background: radial-gradient(900px 420px at 90% -100px, #E1E6FA 0%, transparent 70%), var(--bg);
            background-attachment: fixed;
        }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        :focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }

        .card { background: #fff; border: 1px solid var(--line); border-radius: 14px; box-shadow: 0 1px 2px rgba(15,39,71,.05), 0 8px 24px -16px rgba(15,39,71,.18); }

        /* ---------- Komponen halaman detail ---------- */
        .h-title { font-size: .9rem; font-weight: 700; color: var(--ink); }
        .h-sub { font-size: .75rem; color: var(--ink-3); margin-top: 2px; }
        .ico { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: var(--accent-soft); color: var(--accent); }
        .avatar-lg { width: 52px; height: 52px; border-radius: 50%; background: var(--accent-soft); color: var(--accent); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem; flex-shrink: 0; }
        .kelas-pill { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 999px; background: var(--accent-soft); color: var(--accent); font-size: .74rem; font-weight: 700; }

        /* Badge status: hijau Normal, kuning Borderline, merah Abnormal (sama dengan halaman daftar) */
        .badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 999px; font-size: .76rem; font-weight: 700; white-space: nowrap; }
        .badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
        .badge.nodot::before { display: none; }
        .badge.ok   { background: var(--ok-bg);   color: var(--ok); }
        .badge.warn { background: var(--warn-bg); color: var(--warn); }
        .badge.act  { background: var(--act-bg);  color: var(--act); }
        .badge.none { background: #EDF1F7; color: #475569; }

        .bar { position: relative; height: 8px; border-radius: 99px; background: #EDF1F7; overflow: hidden; }
        .bar > i { position: absolute; left: 0; top: 0; bottom: 0; width: calc(var(--p) * 1%); border-radius: 99px; background: var(--c, var(--accent)); }
        .skor { padding: 14px 16px; border-radius: 12px; border: 1px solid var(--line); background: #fff; transition: border-color .15s, background .15s; }
        .skor:hover { border-color: var(--accent-line); background: #FAFBFF; }
        .prob { padding: 14px 16px; border-radius: 12px; border: 1px solid var(--line); background: #fff; }
        .note { padding: 14px 16px; border-radius: 12px; background: #F7F9FC; border: 1px solid var(--line); }

        /* Angka: ukuran sedang */
        .num-total { font-size: 2rem; font-weight: 700; line-height: 1; letter-spacing: -.01em; color: var(--ink); }
        .num-aspek { font-size: 1.35rem; font-weight: 700; line-height: 1; }
        .num-prob  { font-size: 1.1rem; font-weight: 700; line-height: 1; }

        .btn-del { display: inline-flex; align-items: center; gap: 8px; height: 42px; padding: 0 18px; border: 1px solid #F2C4C4; background: #fff; color: var(--act); font-weight: 600; transition: .15s; }
        .btn-del:hover { background: var(--act-bg); }
        .btn-del:active { transform: scale(.98); }
        .btn-line { display: inline-flex; align-items: center; justify-content: center; gap: 6px; height: 42px; padding: 0 18px; border: 1px solid var(--line); background: #fff; color: var(--ink-2); font-size: .82rem; font-weight: 600; transition: .15s; }
        .btn-line:hover { background: var(--accent-soft); border-color: var(--accent-line); color: var(--accent); }

        /* ---------- Header ---------- */
        .topbar::before { content: ''; position: absolute; left: 0; right: 0; top: 0; height: 3px; background: linear-gradient(90deg, #12143A 0%, var(--accent) 55%, #2B78E0 100%); }

        /* ---------- Mobile ---------- */
        @media (max-width: 639px) {
            .avatar-lg { width: 46px; height: 46px; font-size: .9rem; }
            .num-total { font-size: 1.75rem; }
            .num-aspek { font-size: 1.2rem; }
            .num-prob { font-size: 1rem; }
            .skor { padding: 12px 14px; }
            .prob { padding: 12px 10px; }
            .note { padding: 12px 14px; }
            .card { border-radius: 12px; }
        }
        @media (prefers-reduced-motion: reduce) { .skor, .btn-del, .btn-line { transition: none !important; } }
    </style>
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
                    class="w-9 h-9 rounded-lg border border-[#E3E8F0] flex items-center justify-center hover:bg-[#ECEFFC] transition-colors lg:hidden flex-shrink-0">
                <span class="material-symbols-outlined text-[#475569]" style="font-size:20px">menu</span>
            </button>
            <a href="{{ route('superadmin.kuesioner.index') }}" title="Kembali ke Data Kuesioner" aria-label="Kembali"
               class="w-9 h-9 rounded-lg border border-[#E3E8F0] flex items-center justify-center hover:bg-[#ECEFFC] transition-colors flex-shrink-0">
                <span class="material-symbols-outlined text-[#475569]" style="font-size:20px">arrow_back</span>
            </a>
            <div class="min-w-0">
                <h2 class="text-base md:text-lg font-bold text-[#14233B] leading-tight truncate">Detail Hasil Kuesioner</h2>
                <p class="text-xs text-[#6B7A90] hidden sm:block truncate">{{ $hasil->nama }} — Kelas {{ $hasil->kelas }} — {{ $hasil->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </header>

    {{-- Lebar penuh: margin kiri-kanan sama dengan header (px-4 / md:px-8) --}}
    <div class="flex-1 px-4 md:px-8 py-4 md:py-8 w-full space-y-5 md:space-y-6">

        @if(session('success'))
        <div class="bg-[#E3F5ED] border border-[#A7F3D0] text-[#0F8A5F] text-sm font-semibold rounded-xl px-4 py-3" role="status">
            {{ session('success') }}
        </div>
        @endif

        @php
            $warna = fn ($label) => match($label) {
                'Normal'     => 'ok',
                'Borderline' => 'warn',
                'Abnormal'   => 'act',
                default      => 'none',
            };
            $keputusan = $hasil->keputusan_akhir ?? $hasil->hasil_label;
            $total     = (int) $hasil->total_kesulitan;
            $persen    = min(100, max(0, round($total / 40 * 100)));
            $warnaBar  = match($warna($hasil->hasil_label)) { 'ok' => '#0F8A5F', 'warn' => '#B7690B', 'act' => '#C8303C', default => '#6B7A90' };

            // Skor per aspek (maksimal 10 tiap aspek). Warna mengikuti batas resmi SDQ (Goodman, 1997):
            // b = skor mulai Borderline, a = skor mulai Abnormal; rev = true untuk Prososial (skor rendah yang bermasalah).
            $aspekDef = [
                ['n' => 'Emosional',    'v' => $hasil->skor_emotional,     'icon' => 'sentiment_neutral',  'b' => 6, 'a' => 7, 'rev' => false],
                ['n' => 'Perilaku',     'v' => $hasil->skor_conduct,       'icon' => 'psychology',         'b' => 4, 'a' => 5, 'rev' => false],
                ['n' => 'Hiperaktif',   'v' => $hasil->skor_hyperactivity, 'icon' => 'bolt',               'b' => 6, 'a' => 7, 'rev' => false],
                ['n' => 'Teman sebaya', 'v' => $hasil->skor_peer,          'icon' => 'diversity_3',        'b' => 4, 'a' => 6, 'rev' => false],
                ['n' => 'Prososial',    'v' => $hasil->skor_prosocial,     'icon' => 'volunteer_activism', 'b' => 5, 'a' => 4, 'rev' => true],
            ];
            $warnaStatus = ['ok' => '#0F8A5F', 'warn' => '#B7690B', 'act' => '#C8303C', 'none' => '#6B7A90'];
            $aspek = array_map(function ($d) use ($warnaStatus) {
                if ($d['v'] === null || $d['v'] === '') {
                    $st = 'none';
                } elseif ($d['rev']) {
                    // Prososial: 6-10 normal, 5 borderline, 0-4 abnormal
                    $st = $d['v'] <= $d['a'] ? 'act' : ($d['v'] <= $d['b'] ? 'warn' : 'ok');
                } else {
                    $st = $d['v'] >= $d['a'] ? 'act' : ($d['v'] >= $d['b'] ? 'warn' : 'ok');
                }
                $d['c'] = $warnaStatus[$st];
                return $d;
            }, $aspekDef);

            $nbAda = filled($hasil->hasil_naive_bayes) && stripos((string) $hasil->hasil_naive_bayes, 'tidak tersedia') === false;

            // Flask mengirim peluang dalam persen (0-100). Kalau tersimpan sebagai pecahan (0-1),
            // otomatis dikalikan 100 supaya tampil benar di kedua kasus.
            $pn = (float) ($hasil->prob_normal ?? 0);
            $pb = (float) ($hasil->prob_borderline ?? 0);
            $ph = (float) ($hasil->prob_high_risk ?? 0);
            $kali = (($pn + $pb + $ph) > 0 && ($pn + $pb + $ph) <= 1.5) ? 100 : 1;
            $probs = [
                ['n' => 'Normal',     'v' => $pn * $kali, 'c' => '#0F8A5F'],
                ['n' => 'Borderline', 'v' => $pb * $kali, 'c' => '#B7690B'],
                ['n' => 'High Risk',  'v' => $ph * $kali, 'c' => '#C8303C'],
            ];
        @endphp

        {{-- ===== Ringkasan ===== --}}
        <section class="card p-4 sm:p-5 md:p-6">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-5 lg:gap-8 items-center">

                <div class="lg:col-span-2 flex items-center gap-4 min-w-0">
                    <span class="avatar-lg">{{ strtoupper(substr($hasil->nama, 0, 2)) }}</span>
                    <div class="min-w-0">
                        <h3 class="text-base md:text-lg font-bold text-[#14233B] leading-tight truncate">{{ $hasil->nama }}</h3>
                        <div class="flex flex-wrap items-center gap-x-2 gap-y-1.5 mt-2">
                            @if($hasil->kelas)<span class="kelas-pill">Kelas {{ $hasil->kelas }}</span>@endif
                            <span class="text-xs text-[#6B7A90]">{{ $hasil->created_at->format('d/m/Y, H:i') }} WIB</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-3 pt-5 lg:pt-0 border-t lg:border-t-0 lg:pl-8 lg:border-l border-[#E3E8F0]">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold text-[#475569]">Total skor kesulitan</p>
                            <p class="num-total mt-2">{{ $total }}<span class="text-sm font-medium text-[#6B7A90]">/40</span></p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-semibold text-[#475569] mb-2">Hasil skoring SDQ</p>
                            <span class="badge {{ $warna($hasil->hasil_label) }}">{{ $hasil->hasil_label ?: '-' }}</span>
                        </div>
                    </div>
                    <div class="bar mt-4" style="--p:{{ $persen }};--c:{{ $warnaBar }}" role="img" aria-label="Skor {{ $total }} dari 40"><i></i></div>
                    <p class="text-xs text-[#6B7A90] mt-2.5 leading-relaxed">Gabungan empat aspek kesulitan. Aspek prososial tidak dihitung dalam total.</p>
                </div>
            </div>
        </section>

        {{-- ===== Skor per aspek ===== --}}
        <section class="card p-4 sm:p-5 md:p-6">
            <div class="flex items-start gap-3">
                <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">insights</span></span>
                <div>
                    <h4 class="h-title">Skor per aspek</h4>
                    <p class="h-sub">Setiap aspek bernilai 0 sampai 10. Hijau Normal, kuning Borderline, merah Abnormal.</p>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-5 gap-2.5 sm:gap-3 mt-5">
                @foreach($aspek as $a)
                <div class="skor {{ $loop->last ? 'col-span-2 lg:col-span-1' : '' }}">
                    <div class="flex items-center gap-1.5 text-[#6B7A90]">
                        <span class="material-symbols-outlined" style="font-size:17px;color:{{ $a['c'] }}">{{ $a['icon'] }}</span>
                        <span class="text-xs font-semibold">{{ $a['n'] }}</span>
                    </div>
                    <p class="num-aspek mt-2" style="color:{{ $a['c'] }}">{{ $a['v'] ?? '-' }}<span class="text-xs font-medium text-[#6B7A90]">/10</span></p>
                    <div class="bar mt-3" style="--p:{{ min(100, max(0, ((int) ($a['v'] ?? 0)) * 10)) }};--c:{{ $a['c'] }}"><i></i></div>
                </div>
                @endforeach
            </div>
        </section>

        {{-- ===== Analisis Naive Bayes ===== --}}
        <section class="card p-4 sm:p-5 md:p-6">
            <div class="flex items-start gap-3">
                <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">query_stats</span></span>
                <div>
                    <h4 class="h-title">Analisis Naive Bayes</h4>
                    <p class="h-sub">Peluang tiap kategori hasil menurut model.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-5 lg:gap-8 mt-5">

                {{-- Kiri: peluang tiap kategori --}}
                <div class="lg:col-span-3">
                    @if($nbAda)
                    <div class="grid grid-cols-3 gap-2 sm:gap-3">
                        @foreach($probs as $p)
                        <div class="prob">
                            <p class="text-xs font-semibold text-[#6B7A90]">{{ $p['n'] }}</p>
                            <p class="num-prob mt-1.5" style="color:{{ $p['c'] }}">{{ number_format($p['v'], 1, ',', '.') }}%</p>
                            <div class="bar mt-3" style="--p:{{ min(100, max(0, round($p['v']))) }};--c:{{ $p['c'] }}"><i></i></div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="note flex items-start gap-3">
                        <span class="material-symbols-outlined text-[#6B7A90]" style="font-size:20px">info</span>
                        <p class="text-sm text-[#475569] leading-relaxed">Perhitungan Naive Bayes belum tersedia untuk data ini. Keputusan akhir mengikuti hasil skoring SDQ.</p>
                    </div>
                    @endif
                </div>

                {{-- Kanan: prediksi, keputusan, tindakan --}}
                <div class="lg:col-span-2 pt-5 lg:pt-0 border-t lg:border-t-0 lg:pl-8 lg:border-l border-[#E3E8F0]">
                    <dl class="divide-y divide-[#E3E8F0]">
                        <div class="flex flex-wrap items-center justify-between gap-2 pb-3.5">
                            <dt class="text-sm text-[#6B7A90]">Prediksi Naive Bayes</dt>
                            <dd class="text-sm font-semibold text-[#14233B]">{{ $nbAda ? $hasil->hasil_naive_bayes : 'Tidak tersedia' }}</dd>
                        </div>
                        <div class="flex flex-wrap items-center justify-between gap-2 py-3.5">
                            <dt class="text-sm text-[#6B7A90]">Keputusan akhir</dt>
                            <dd><span class="badge nodot {{ $warna($keputusan) }}">{{ $keputusan ?: '-' }}</span></dd>
                        </div>
                    </dl>

                    <div class="note mt-1 flex items-start gap-3">
                        <span class="ico" style="width:32px;height:32px"><span class="material-symbols-outlined" style="font-size:18px">task_alt</span></span>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-[#6B7A90]">Tindakan yang disarankan</p>
                            <p class="text-sm font-semibold text-[#14233B] mt-1 leading-relaxed">{{ $hasil->tindakan ?: '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===== Aksi ===== --}}
        <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3">
            <a href="{{ route('superadmin.kuesioner.index') }}" class="btn-line">
                <span class="material-symbols-outlined" style="font-size:18px">arrow_back</span>
                Kembali ke daftar
            </a>
            <form method="POST" action="{{ route('superadmin.kuesioner.destroy', $hasil->id) }}"
                  onsubmit="return confirm('Hapus data kuesioner ini secara permanen?\n\nData yang dihapus tidak bisa dikembalikan.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-del w-full sm:w-auto justify-center">
                    <span class="material-symbols-outlined" style="font-size:18px">delete</span>
                    Hapus data ini
                </button>
            </form>
        </div>

        <footer class="pt-4 border-t border-[#E3E8F0] flex flex-col sm:flex-row sm:justify-between items-center text-center gap-1 sm:gap-2">
            <p class="text-xs text-[#6B7A90]">© {{ date('Y') }} SMPN 216 Jakarta — Portal Skrining Kesehatan Mental Siswa</p>
            <p class="text-xs text-[#6B7A90]">Super Admin Panel</p>
        </footer>
    </div>
</main>

{{-- openSidebar() dan closeSidebar() sudah ada di partials.sidebar_superadmin --}}
</body>
</html>