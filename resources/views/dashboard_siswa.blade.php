@php
    $logoUrl = \App\Models\Pengaturan::url('logo', 'logo-smpn216.png');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | SMPN 216 Jakarta</title>
    <link rel="icon" type="image/png" href="{{ $logoUrl }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Source+Serif+4:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/tema.css')
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #0F2747; --brand: #1D5FBF; --brand-deep: #174E9E; --brand-soft: #E8F0FB; --bg: #F3F5F9;
            --ink: #14233B; --ink-2: #475569; --ink-3: #6B7A90; --line: #E3E8F0;
            --ok: #0F8A5F;   --ok-bg: #E3F5ED;
            --warn: #B7690B; --warn-bg: #FDF1DC;
            --bad: #B93838;  --bad-bg: #FCE9E9;
        }

        html { scroll-behavior: smooth; scroll-padding-top: 80px; }
        body { font-family: var(--font-sans); color: var(--ink);
            background: radial-gradient(900px 400px at 85% -80px, #DCE8FA 0%, transparent 70%), var(--bg); background-attachment: fixed; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        :focus-visible { outline: 2px solid var(--brand); outline-offset: 2px; }

        .card { background: #fff; border: 1px solid var(--line); border-radius: 14px; box-shadow: 0 1px 2px rgba(15,39,71,.05), 0 8px 24px -16px rgba(15,39,71,.18); }
        .ico { width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: var(--brand-soft); color: var(--brand); }
        .h-title { font-size: .95rem; font-weight: 700; color: var(--ink); }
        .h-sub { font-size: .78rem; color: var(--ink-3); margin-top: 2px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: .72rem; font-weight: 700; white-space: nowrap; }
        .b-ok { background: var(--ok-bg); color: var(--ok); }
        .b-warn { background: var(--warn-bg); color: var(--warn); }
        .b-bad { background: var(--bad-bg); color: var(--bad); }

        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 22px; min-height: 46px; border-radius: 12px; font-size: .875rem; font-weight: 700; transition: transform .12s ease, background .15s ease, border-color .15s ease, color .15s ease; border: 1px solid transparent; cursor: pointer; }
        .btn:active { transform: scale(.98); }
        .btn-primary { background: var(--brand); color: #fff; box-shadow: 0 10px 20px -12px var(--brand); }
        .btn-primary:hover { background: var(--brand-deep); }
        .btn-ghost { background: #fff; color: var(--ink-2); border-color: var(--line); }
        .btn-ghost:hover { color: var(--brand); border-color: #B9D0F2; background: var(--brand-soft); }
        .btn-white { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 13px 22px; min-height: 48px; border-radius: 12px; background: #fff; color: var(--navy); font-size: .9rem; font-weight: 700; box-shadow: 0 10px 20px -10px rgba(0,0,0,.25); transition: background .15s, transform .12s; }
        .btn-white:hover { background: var(--brand-soft); }
        .btn-white:active { transform: scale(.98); }

        /* Hero */
        .hero { position: relative; overflow: hidden; border-radius: 20px; padding: 28px; color: #fff; background: linear-gradient(120deg, #0B1F3A 0%, #15407F 55%, #2B78E0 100%); box-shadow: 0 18px 40px -18px rgba(21,64,127,.65); }
        .hero-ring { position: absolute; border-radius: 50%; border: 1px solid rgba(255,255,255,.14); pointer-events: none; }
        .hero-ring.r1 { width: 380px; height: 380px; right: -90px; top: -150px; background: radial-gradient(circle, rgba(255,255,255,.12), transparent 70%); }
        .hero-ring.r2 { width: 230px; height: 230px; right: 190px; bottom: -130px; }
        .hero-chip { display: inline-flex; align-items: center; gap: 7px; padding: 7px 12px; border-radius: 10px; background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2); font-size: .76rem; font-weight: 600; line-height: 1.2; }
        @media (max-width: 639px) { .hero { padding: 22px 18px; border-radius: 16px; } }

        /* Kartu info */
        .tile { display: flex; align-items: center; gap: 12px; padding: 16px; }
        .tile b { display: block; font-size: .95rem; color: var(--ink); line-height: 1.25; }
        .tile .s { display: block; font-size: .75rem; color: var(--ink-3); margin-top: 3px; line-height: 1.4; }

        /* Langkah */
        .step { display: flex; gap: 14px; align-items: flex-start; padding: 18px; }
        .step-n { width: 32px; height: 32px; border-radius: 50%; background: var(--brand-soft); color: var(--brand); font-weight: 800; font-size: .9rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .step b { display: block; font-size: .92rem; color: var(--ink); margin-bottom: 3px; }
        .step p { font-size: .8rem; line-height: 1.6; color: var(--ink-2); margin: 0; }

        /* Pengingat */
        .remind { padding: 18px 20px; display: flex; flex-direction: column; gap: 16px; }
        @media (min-width: 768px) { .remind { flex-direction: row; align-items: center; justify-content: space-between; } }
        .remind.due { border-color: #9DBDEB; background: linear-gradient(135deg, #F4F8FE 0%, #EAF2FD 100%); box-shadow: 0 0 0 3px rgba(29,95,191,.08), 0 12px 28px -16px rgba(29,95,191,.4); }
        .remind.due .ico { background: var(--brand); color: #fff; }
        .rbar { height: 8px; border-radius: 999px; background: #E7ECF4; overflow: hidden; }
        .rbar > i { display: block; height: 100%; border-radius: 999px; background: linear-gradient(90deg, #5B9DF5, var(--brand)); transition: width 1s cubic-bezier(.4,0,.2,1); }

        /* Menu bawah (HP) */
        .bottom-nav { position: fixed; z-index: 40; left: 50%; transform: translateX(-50%); bottom: calc(14px + env(safe-area-inset-bottom)); width: calc(100% - 28px); max-width: 440px; display: flex; align-items: center; justify-content: space-between; gap: 4px; padding: 8px; background: #fff; border-radius: 999px; box-shadow: 0 14px 34px -10px rgba(15,39,71,.38), 0 2px 6px rgba(15,39,71,.08); }
        .bn-item { display: flex; align-items: center; justify-content: center; gap: 8px; height: 46px; min-width: 46px; padding: 0 12px; border-radius: 999px; color: var(--brand); font-size: .85rem; font-weight: 600; white-space: nowrap; background: transparent; border: 0; cursor: pointer; transition: background .2s ease, color .2s ease, padding .2s ease; }
        .bn-item .material-symbols-outlined { font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
        .bn-item .label { display: none; }
        .bn-item:not(.active):hover { background: var(--brand-soft); }
        .bn-item.active { background: var(--brand); color: #fff; padding: 0 18px; }
        .bn-item.active .label { display: inline; }
        @media (min-width: 1024px) { .bottom-nav { display: none; } }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            .bn-item, .rbar > i { transition: none !important; }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/icons.css') }}">
    <script src="{{ asset('js/icons.js') }}" defer></script>
</head>
<body class="flex min-h-screen">

@php
    $riwayat = isset($riwayat) ? collect($riwayat)->values() : collect();
    $h       = $hasilTerakhir ?? $riwayat->first();

    $intervalHari = 90;   // saran jarak antar pengisian (hari)

    // Pola risiko AI pada hasil Normal diperlakukan sebagai "Perlu diperhatikan"
    $kunci = $h
        ? ((($h->risiko_ai ?? '') === 'YES' && $h->hasil_label === 'Normal') ? 'Borderline' : ($h->hasil_label ?? 'Normal'))
        : null;

    $status = [
        'Normal'     => ['Normal', 'b-ok', 'Kondisimu terlihat baik.', 'Teruslah menjaga kebiasaan baikmu dan bercerita kepada orang yang kamu percaya.'],
        'Borderline' => ['Perlu diperhatikan', 'b-warn', 'Ada beberapa hal yang perlu diperhatikan.', 'Tidak perlu khawatir. Guru BK dengan senang hati menemanimu berbincang kapan saja.'],
        'Abnormal'   => ['Perlu dukungan', 'b-bad', 'Kamu tidak sendirian.', 'Guru BK siap mendampingimu. Datanglah ke ruang BK kapan pun kamu merasa nyaman.'],
    ];
    $st = $kunci ? ($status[$kunci] ?? $status['Normal']) : null;

    $sekarang  = now('Asia/Jakarta')->locale('id');
    $jam       = (int) $sekarang->format('H');
    $sapaan    = $jam < 11 ? 'Selamat pagi' : ($jam < 15 ? 'Selamat siang' : ($jam < 18 ? 'Selamat sore' : 'Selamat malam'));
    $namaDepan = \Illuminate\Support\Str::words(Auth::user()->name ?? '', 1, '');
    $tglSkrining = $h ? $h->created_at->copy()->timezone('Asia/Jakarta')->locale('id') : null;

    $infoUlang = null;
    if ($h) {
        $hariSejak = (int) floor($sekarang->copy()->startOfDay()->diffInDays($tglSkrining->copy()->startOfDay(), true));
        $sisaHari  = $intervalHari - $hariSejak;
        $infoUlang = [
            'tgl'        => $tglSkrining->translatedFormat('j F Y'),
            'sisa'       => max(0, $sisaHari),
            'sudah'      => $sisaHari <= 0,
            'berikutnya' => $tglSkrining->copy()->addDays($intervalHari)->translatedFormat('j F Y'),
            'persen'     => min(100, round($hariSejak / $intervalHari * 100)),
            'lalu'       => $hariSejak === 0 ? 'hari ini' : $hariSejak . ' hari lalu',
        ];
    }
@endphp

@include('partials.sidebar_dashboard_siswa')

<main class="flex-1 min-w-0 flex flex-col pb-28 lg:pb-0">

    <header class="h-16 bg-white/90 backdrop-blur-md border-b border-[#E3E8F0] flex items-center justify-between px-4 md:px-8 sticky top-0 z-30">
        <a href="{{ url('/') }}" class="flex items-center gap-2.5 min-w-0 lg:hidden">
            <span class="w-9 h-9 rounded-xl overflow-hidden border border-[#E3E8F0] flex-shrink-0">
                <img src="{{ $logoUrl }}" alt="Logo SMPN 216" class="w-full h-full object-contain">
            </span>
            <span class="font-bold text-[15px] truncate">SMPN 216 Jakarta</span>
        </a>
        <div class="hidden lg:block">
            <h2 class="text-base md:text-lg font-bold text-[#14233B] leading-tight">Dashboard</h2>
            <p class="text-xs text-[#6B7A90]">{{ $h ? 'Ringkasan skrining dan jadwal pengisianmu' : 'Selamat datang, mulai skrining pertamamu' }}</p>
        </div>
        <span class="text-xs font-medium text-[#475569] hidden sm:flex items-center gap-2 px-3 py-2 rounded-lg bg-[#F3F5F9] border border-[#E3E8F0]">
            <span class="material-symbols-outlined" style="font-size:16px">calendar_today</span>
            {{ $sekarang->isoFormat('dddd, D MMMM Y') }}
        </span>
    </header>

    <div class="flex-1 px-4 md:px-8 py-4 md:py-8 space-y-5 md:space-y-6 w-full max-w-[1100px] mx-auto">

        @if(session('info'))
        <div class="bg-[#E8F0FB] border border-[#CFE0F7] text-[#1D4F9C] text-sm font-medium px-4 py-3 rounded-xl flex items-center gap-2" role="status">
            <span class="material-symbols-outlined" style="font-size:20px">info</span>
            {{ session('info') }}
        </div>
        @endif

        @if($h)

            {{-- ===== Sudah mengisi ===== --}}
            <section class="hero">
                <div class="hero-ring r1"></div><div class="hero-ring r2"></div>
                <div class="relative flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="min-w-0 max-w-2xl">
                        <h3 class="text-xl md:text-2xl font-bold leading-tight">{{ $sapaan }}, {{ $namaDepan }}</h3>
                        <p class="text-sm text-blue-100 mt-2 leading-relaxed">
                            <strong class="text-white">{{ $st[2] }}</strong> {{ $st[3] }}
                        </p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="hero-chip"><span class="material-symbols-outlined" style="font-size:16px">school</span>Kelas {{ Auth::user()->kelas }}</span>
                            <span class="hero-chip"><span class="material-symbols-outlined" style="font-size:16px">calendar_month</span>Terakhir mengisi {{ $tglSkrining->translatedFormat('j F Y') }}</span>
                        </div>
                    </div>
                    <a href="/hasil-skrining" class="btn-white flex-shrink-0 w-full sm:w-auto lg:self-center">
                        <span class="material-symbols-outlined" style="font-size:20px">clinical_notes</span>
                        Lihat hasil lengkap
                    </a>
                </div>
            </section>

            {{-- Ringkasan --}}
            <section class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4" aria-label="Ringkasan hasil">
                <div class="card tile">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:22px">speed</span></span>
                    <div><b>{{ $h->total_kesulitan }} <span class="text-xs font-semibold text-[#6B7A90]">dari 40</span></b><span class="s">Total skor kesulitan</span></div>
                </div>
                <div class="card tile">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:22px">fact_check</span></span>
                    <div><span class="badge {{ $st[1] }}">{{ $st[0] }}</span><span class="s">Hasil skrining terakhir</span></div>
                </div>
                <div class="card tile">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:22px">history</span></span>
                    <div><b>{{ $riwayat->count() }} kali</b><span class="s">Total pengisian kuesioner</span></div>
                </div>
            </section>

            {{-- Pengingat isi ulang --}}
            <section class="card remind {{ $infoUlang['sudah'] ? 'due' : '' }}" aria-labelledby="judul-ulang">
                <div class="flex items-start gap-3 min-w-0 flex-1">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:22px">{{ $infoUlang['sudah'] ? 'notifications_active' : 'event_repeat' }}</span></span>
                    <div class="min-w-0 flex-1">
                        <h4 id="judul-ulang" class="h-title">{{ $infoUlang['sudah'] ? 'Sudah waktunya mengisi ulang' : 'Pengisian berikutnya' }}</h4>
                        <p class="h-sub" style="line-height:1.6">
                            @if($infoUlang['sudah'])
                                Terakhir kamu mengisi pada {{ $infoUlang['tgl'] }} ({{ $infoUlang['lalu'] }}). Mengisi berkala membantu kamu dan Guru BK melihat perkembanganmu.
                            @else
                                Terakhir mengisi pada {{ $infoUlang['tgl'] }} ({{ $infoUlang['lalu'] }}). Disarankan mengisi lagi sekitar <strong class="text-[#14233B]">{{ $infoUlang['berikutnya'] }}</strong>, kira-kira {{ $infoUlang['sisa'] }} hari lagi. Kalau merasa ada perubahan, kamu boleh mengisi lebih awal.
                            @endif
                        </p>
                        <div class="mt-3 max-w-md">
                            <div class="rbar" role="img" aria-label="{{ $infoUlang['persen'] }} persen menuju waktu isi ulang"><i data-bar style="width:{{ $infoUlang['persen'] }}%"></i></div>
                            <div class="flex justify-between text-[11px] text-[#6B7A90] mt-1.5">
                                <span>Terakhir mengisi</span><span>{{ $infoUlang['sudah'] ? 'Waktunya isi ulang' : 'Disarankan isi ulang' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="/sdq" class="btn {{ $infoUlang['sudah'] ? 'btn-primary' : 'btn-ghost' }} w-full md:w-auto flex-shrink-0">
                    <span class="material-symbols-outlined" style="font-size:19px">assignment</span>
                    {{ $infoUlang['sudah'] ? 'Isi kuesioner sekarang' : 'Isi lebih awal' }}
                </a>
            </section>

            {{-- Bantuan --}}
            <section class="card p-4 md:p-5 flex gap-3 items-start" style="background:linear-gradient(135deg,#F4F8FE 0%,#EAF2FD 100%);border-color:#CFE0F7">
                <span class="ico"><span class="material-symbols-outlined" style="font-size:22px">forum</span></span>
                <div>
                    <h4 class="h-title">Ingin bercerita?</h4>
                    <p class="text-[13px] leading-relaxed text-[#475569] mt-1">Ruang BK terbuka untuk semua siswa, kapan saja. Kamu tidak perlu menunggu hasil skrining untuk datang berbincang.</p>
                </div>
            </section>

        @else

            {{-- ===== Belum mengisi ===== --}}
            <section class="hero">
                <div class="hero-ring r1"></div><div class="hero-ring r2"></div>
                <div class="relative flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="min-w-0 max-w-2xl">
                        <h3 class="text-xl md:text-2xl font-bold leading-tight">{{ $sapaan }}, {{ $namaDepan }}</h3>
                        <p class="text-sm text-blue-100 mt-2 leading-relaxed">
                            <strong class="text-white">Selamat datang di MindCheck.</strong>
                            Kamu belum mengisi skrining. Isi kuesioner singkat agar hasilmu bisa tampil di halaman Hasil Skrining.
                        </p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="hero-chip"><span class="material-symbols-outlined" style="font-size:16px">school</span>Kelas {{ Auth::user()->kelas }}</span>
                            <span class="hero-chip"><span class="material-symbols-outlined" style="font-size:16px">assignment_late</span>Belum ada hasil skrining</span>
                        </div>
                    </div>
                    <a href="/sdq" class="btn-white flex-shrink-0 w-full sm:w-auto lg:self-center">
                        <span class="material-symbols-outlined" style="font-size:20px">play_arrow</span>
                        Mulai isi kuesioner
                    </a>
                </div>
            </section>

            <section class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4" aria-label="Tentang kuesioner">
                <div class="card tile">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:22px">quiz</span></span>
                    <div><b>25 pernyataan</b><span class="s">Jawab sesuai yang kamu rasakan</span></div>
                </div>
                <div class="card tile">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:22px">schedule</span></span>
                    <div><b>10 sampai 15 menit</b><span class="s">Bisa dikerjakan dengan santai</span></div>
                </div>
                <div class="card tile">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:22px">lock</span></span>
                    <div><b>Rahasia</b><span class="s">Hanya kamu dan Guru BK yang melihat</span></div>
                </div>
            </section>

            <section aria-labelledby="judul-cara">
                <div class="mb-3">
                    <h4 id="judul-cara" class="h-title">Caranya mudah</h4>
                    <p class="h-sub">Hanya tiga langkah</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4">
                    <div class="card step">
                        <span class="step-n">1</span>
                        <div><b>Isi kuesioner</b><p>Jawab 25 pernyataan dengan jujur. Tidak ada jawaban benar atau salah.</p></div>
                    </div>
                    <div class="card step">
                        <span class="step-n">2</span>
                        <div><b>Kirim jawabanmu</b><p>Periksa kembali jawabanmu, lalu kirim.</p></div>
                    </div>
                    <div class="card step">
                        <span class="step-n">3</span>
                        <div><b>Lihat hasilnya</b><p>Hasilmu tampil di halaman Hasil Skrining.</p></div>
                    </div>
                </div>
            </section>

            <section class="card p-4 md:p-5 flex gap-3 items-start" style="background:linear-gradient(135deg,#F4F8FE 0%,#EAF2FD 100%);border-color:#CFE0F7">
                <span class="ico"><span class="material-symbols-outlined" style="font-size:22px">favorite</span></span>
                <div>
                    <h4 class="h-title">Ini bukan tes</h4>
                    <p class="text-[13px] leading-relaxed text-[#475569] mt-1">Tidak ada nilai dan tidak ada jawaban yang salah. Skrining ini membantumu mengenali perasaanmu dan membantu Guru BK mendampingimu dengan lebih baik.</p>
                </div>
            </section>

        @endif

        <footer class="pt-4 border-t border-[#E3E8F0] flex justify-between items-center flex-wrap gap-2">
            <p class="text-xs text-[#6B7A90]">© 2026 SMPN 216 Jakarta — Portal Skrining Kesehatan Mental Siswa</p>
            <p class="text-xs text-[#6B7A90]">Powered by SDQ + Analisis AI</p>
        </footer>

    </div>
</main>

<nav class="bottom-nav" aria-label="Menu utama">
    <a href="/dashboard-siswa" class="bn-item active" aria-label="Dashboard" title="Dashboard" aria-current="page">
        <span class="material-symbols-outlined" style="font-size:22px">home</span>
        <span class="label">Dashboard</span>
    </a>
    <a href="/sdq" class="bn-item" aria-label="Isi Kuesioner" title="Isi Kuesioner">
        <span class="material-symbols-outlined" style="font-size:22px">assignment</span>
        <span class="label">Kuesioner</span>
    </a>
    <a href="/hasil-skrining" class="bn-item" aria-label="Hasil Skrining" title="Hasil Skrining">
        <span class="material-symbols-outlined" style="font-size:22px">clinical_notes</span>
        <span class="label">Hasil</span>
    </a>
    <form method="POST" action="/logout" class="contents">
        @csrf
        <button type="submit" class="bn-item" aria-label="Keluar" title="Keluar">
            <span class="material-symbols-outlined" style="font-size:22px">logout</span>
            <span class="label">Keluar</span>
        </button>
    </form>
</nav>

<script>
    (function () {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        document.querySelectorAll('[data-bar]').forEach(function (el) {
            var w = el.style.width;
            el.style.width = '0';
            requestAnimationFrame(function () {
                requestAnimationFrame(function () { el.style.width = w; });
            });
        });
    })();
</script>

</body>
</html>