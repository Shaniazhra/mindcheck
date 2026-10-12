<!DOCTYPE html>
<html lang="id">
<head>
    <title>{{ ($modeEdit ?? false) ? 'Edit Laporan BK' : 'Buat Laporan BK' }} — {{ $s->nama }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ \App\Models\Pengaturan::url('logo', 'logo-smpn216.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,500;8..60,600;8..60,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            --ai: #0A78B5;
            --ai-bg: #E2F2FA;
        }

        body {
            color: var(--ink);
            background: radial-gradient(900px 400px at 85% -80px, #DCE8FA 0%, transparent 70%), var(--bg);
            background-attachment: fixed;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        :focus-visible {
            outline: 2px solid var(--brand);
            outline-offset: 2px;
        }

        .card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 14px;
            box-shadow: 0 1px 2px rgba(15,39,71,.05), 0 8px 24px -16px rgba(15,39,71,.18);
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
            font-weight: 600;
            color: var(--ink);
        }

        .h-sub {
            color: var(--ink-3);
            margin-top: 2px;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-weight: 700;
            white-space: nowrap;
        }

        .b-ok { background: var(--ok-bg); color: var(--ok); }
        .b-warn { background: var(--warn-bg); color: var(--warn); }
        .b-act { background: var(--act-bg); color: var(--act); }
        .b-ai { background: var(--ai-bg); color: var(--ai); }
        .b-none { background: #E8ECF2; color: var(--ink-2); }

        .field-label {
            display: block;
            margin-bottom: 7px;
            color: var(--ink);
            font-size: 13px;
            font-weight: 700;
        }

        .field-help {
            margin-top: 6px;
            color: var(--ink-3);
            font-size: 11.5px;
            line-height: 1.55;
        }

        .input,
        .textarea {
            width: 100%;
            border: 1px solid var(--line);
            background: #fff;
            color: var(--ink);
            transition: border-color .15s, box-shadow .15s;
        }

        .input {
            height: 44px;
            padding: 0 13px;
        }

        .textarea {
            min-height: 180px;
            padding: 12px 13px;
            resize: vertical;
            line-height: 1.65;
        }

        .input:focus,
        .textarea:focus {
            outline: none;
            border-color: #8FB4E8;
            box-shadow: 0 0 0 3px rgba(29,95,191,.09);
        }

        .input[readonly] {
            background: #F7F9FC;
            color: var(--ink-2);
            cursor: default;
        }

        .btn-primary,
        .btn-ghost,
        .btn-danger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 9px 16px;
            font-weight: 600;
            transition: .15s;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--brand);
            color: #fff;
            box-shadow: 0 6px 14px -8px var(--brand);
        }

        .btn-primary:hover { background: #174C99; }

        .btn-ghost {
            background: #fff;
            border: 1px solid var(--line);
            color: var(--ink-2);
        }

        .btn-ghost:hover {
            background: var(--brand-soft);
            color: var(--brand);
        }

        .btn-danger {
            background: #fff;
            border: 1px solid #F0CACA;
            color: #B42318;
        }

        .btn-danger:hover {
            background: #FFF4F4;
        }

        .info-box {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 14px;
            box-shadow: 0 1px 2px rgba(15,39,71,.05), 0 8px 24px -16px rgba(15,39,71,.18);
        }

        .auto-box {
            border: 1px solid #B7DDF0;
            background: linear-gradient(135deg, #F4FBFE 0%, #E2F2FA 100%);
            border-radius: 14px;
        }

        .status-box {
            border-radius: 12px;
            padding: 12px 14px;
            display: flex;
            align-items: flex-start;
            gap: 9px;
        }

        .status-info {
            background: #E8F0FB;
            border: 1px solid #C9DBF5;
            color: #244A78;
        }

        .status-success {
            background: var(--ok-bg);
            border: 1px solid #BFE6D4;
            color: #0B6B49;
        }

        .status-error {
            background: var(--warn-bg);
            border: 1px solid #F4DFB6;
            color: #8A4F08;
        }

        .history-card {
            border: 1px solid var(--line);
            border-radius: 12px;
            background: #fff;
            transition: border-color .15s, box-shadow .15s;
        }

        .history-card:hover {
            border-color: #B9D0F2;
            box-shadow: 0 8px 24px -20px rgba(15,39,71,.35);
        }

        .history-text {
            white-space: pre-line;
            line-height: 1.65;
        }


        /* Hero ringkasan siswa — mengikuti style Detail Skrining */
        .report-hero {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            padding: 28px;
            color: #fff;
            background: linear-gradient(115deg, #0F2747 0%, #173D73 52%, #2F79D7 100%);
            box-shadow: 0 12px 28px -14px rgba(15,39,71,.42);
        }

        .report-hero::before {
            content: '';
            position: absolute;
            width: 330px;
            height: 330px;
            border: 1px solid rgba(255,255,255,.14);
            border-radius: 50%;
            right: -40px;
            top: -210px;
        }

        .report-hero::after {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            border: 1px solid rgba(255,255,255,.13);
            border-radius: 50%;
            right: 130px;
            bottom: -205px;
        }

        .report-hero .hero-orbit {
            position: absolute;
            width: 170px;
            height: 170px;
            border: 1px solid rgba(255,255,255,.13);
            border-radius: 50%;
            right: 210px;
            bottom: -85px;
        }

        .report-avatar {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.28);
            font-family: var(--font-sans);
            font-size: 20px;
            font-weight: 700;
            backdrop-filter: blur(4px);
        }

        .report-name {
            font-family: var(--font-serif) !important;
            font-size: 29px;
            line-height: 1.1;
            font-weight: 600;
            color: #fff;
        }

        .report-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            min-height: 32px;
            padding: 6px 11px;
            border-radius: 9px;
            color: #fff;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.25);
            font-size: 11.5px;
            font-weight: 600;
            white-space: nowrap;
            backdrop-filter: blur(4px);
        }

        .report-pill .material-symbols-outlined {
            font-size: 15px;
            color: #EAF2FF;
        }

        .report-score {
            position: relative;
            z-index: 2;
            width: 112px;
            flex-shrink: 0;
            text-align: center;
        }

        .score-ring {
            width: 106px;
            height: 106px;
            margin: 0 auto 7px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .score-ring svg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            transform: rotate(-90deg);
        }

        .score-ring .score-number {
            position: relative;
            z-index: 1;
            font-size: 30px;
            line-height: 1;
            font-weight: 700;
            color: #fff;
        }

        .score-ring .score-number small {
            display: block;
            margin-top: 3px;
            font-size: 9px;
            line-height: 1;
            font-weight: 500;
            color: rgba(255,255,255,.82);
        }

        .score-label {
            color: rgba(255,255,255,.88);
            font-size: 11px;
            line-height: 1.35;
        }

        .score-badge {
            display: inline-flex;
            margin-top: 4px;
            padding: 4px 10px;
            border-radius: 999px;
            background: #fff;
            font-size: 11px;
            font-weight: 700;
        }

        @media (max-width: 767px) {
            .report-hero { padding: 22px 20px; }
            .report-name { font-size: 24px; }
            .report-score { width: 100%; display: flex; align-items: center; justify-content: center; gap: 14px; }
            .score-ring { margin: 0; }
            .score-meta { text-align: left; }
        }

        /* ===== Perapian tampilan mobile ===== */
        @media (max-width: 639px) {
            .card,
            .auto-box { border-radius: 12px; }

            .report-hero { padding: 20px 16px; border-radius: 16px; }
            .report-hero::before { width: 240px; height: 240px; right: -90px; top: -150px; }
            .report-hero::after,
            .report-hero .hero-orbit { display: none; }
            .report-avatar { width: 52px; height: 52px; border-radius: 14px; font-size: 17px; }
            .report-name { font-size: 22px; }
            .report-pill { min-height: 28px; padding: 5px 9px; font-size: 11px; }
            .report-score { padding-top: 14px; border-top: 1px solid rgba(255,255,255,.18); }
            .score-ring { width: 92px; height: 92px; }
            .score-ring .score-number { font-size: 26px; }

            /* 16px mencegah iPhone zoom otomatis saat mengetik */
            .input,
            .textarea { font-size: 16px; }
            .textarea { min-height: 150px; }

            .form-actions { flex-wrap: nowrap; }
            .form-actions > * { flex: 1 1 0; }

            .hist-actions { width: 100%; flex-direction: row; }
            .hist-actions > * { flex: 1 1 0; }

            .back-wrap > a { width: 100%; }
        }

        @media print {
            .report-hero {
                color: #14233B;
                background: #fff;
                border: 1px solid #DCE5F2;
                box-shadow: none;
            }
            .report-hero::before,
            .report-hero::after,
            .report-hero .hero-orbit { display: none; }
            .report-name { color: #14233B; }
            .report-pill { color: #475569; background: #F8FAFC; border-color: #DCE5F2; }
            .report-pill .material-symbols-outlined { color: #475569; }
            .score-ring .score-number { color: #14233B; }
            .score-ring .score-number small,
            .score-label { color: #475569; }
        }

        @media print {
            #sidebar,
            #sidebar-overlay,
            header,
            .no-print {
                display: none !important;
            }

            body {
                background: #fff;
            }

            .card,
            .info-box,
            .auto-box,
            .history-card {
                box-shadow: none !important;
            }
        }
    </style>

    @vite('resources/css/tema.css')
</head>

<body class="flex min-h-screen">

@php
    $keputusan = $s->keputusan_akhir ?? $s->hasil_label;

    $sdqBadge = match($s->hasil_label ?? '') {
        'Normal' => 'b-ok',
        'Borderline' => 'b-warn',
        'Abnormal' => 'b-act',
        default => 'b-none',
    };

    $nbBadge = match($s->hasil_naive_bayes ?? '') {
        'Normal' => 'b-ok',
        'Borderline' => 'b-warn',
        'High Risk' => 'b-act',
        default => 'b-none',
    };

    $kaBadge = match($keputusan ?? '') {
        'Normal' => 'b-ok',
        'Borderline' => 'b-warn',
        'High Risk', 'Abnormal' => 'b-act',
        default => 'b-none',
    };

    $tglSkrining = $s->created_at
        ? $s->created_at->copy()->timezone('Asia/Jakarta')->locale('id')
        : null;

    $tglLaporan = $laporan->tanggal_laporan
        ? \Carbon\Carbon::parse($laporan->tanggal_laporan)->timezone('Asia/Jakarta')->locale('id')
        : now('Asia/Jakarta')->locale('id');

    $modeEdit = $modeEdit ?? false;
@endphp

@include('partials.sidebar_dashboard_gurubk')

<main class="flex-1 min-w-0 flex flex-col">

    <header class="h-16 bg-white/90 backdrop-blur-md border-b border-[#E3E8F0] flex items-center justify-between px-4 md:px-8 sticky top-0 z-30">
        <div class="flex items-center gap-3 min-w-0">
            <button id="hamburger-btn" onclick="openSidebar()" aria-label="Buka menu"
                class="w-9 h-9 border border-[#E3E8F0] flex items-center justify-center hover:bg-[#E8F0FB] transition-colors lg:hidden flex-shrink-0">
                <span class="material-symbols-outlined text-[#475569]" style="font-size:20px">menu</span>
            </button>

            <a href="/riwayat/{{ $s->id }}" title="Kembali ke detail" aria-label="Kembali"
                class="w-9 h-9 border border-[#E3E8F0] flex items-center justify-center hover:bg-[#E8F0FB] transition-colors flex-shrink-0">
                <span class="material-symbols-outlined text-[#475569]" style="font-size:20px">arrow_back</span>
            </a>

            <div class="truncate">
                <p class="text-xs text-[#6B7A90] truncate">
                    <a href="/riwayat" class="hover:text-[#1D5FBF] transition-colors">Riwayat Skrining</a>
                    <span class="mx-1">/</span>
                    <span class="text-[#14233B] font-medium">Laporan BK</span>
                </p>
                <h2 class="text-base md:text-lg font-bold text-[#14233B] truncate leading-tight">
                    {{ $modeEdit ? 'Edit Laporan BK' : 'Buat Laporan BK' }}
                </h2>
            </div>
        </div>

        @if(!$modeEdit && $laporan->exists && filled($laporan->rekomendasi))
            <a href="/riwayat/{{ $s->id }}/laporan/pdf" target="_blank" class="btn-ghost flex-shrink-0 ml-2 no-print">
                <span class="material-symbols-outlined" style="font-size:18px">picture_as_pdf</span>
                <span class="hidden sm:inline">Unduh PDF</span>
            </a>
        @endif
    </header>

    <div class="flex-1 p-4 md:p-8 space-y-5 md:space-y-6 max-w-6xl w-full mx-auto">

        @if(session('info'))
            <div class="status-box status-info no-print" role="status">
                <span class="material-symbols-outlined flex-shrink-0" style="font-size:20px">info</span>
                <p class="text-sm font-medium leading-relaxed">{{ session('info') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="status-box status-error no-print" role="alert">
                <span class="material-symbols-outlined flex-shrink-0" style="font-size:20px">error</span>
                <div class="text-sm font-medium leading-relaxed">
                    <p class="font-bold mb-1">Laporan belum dapat disimpan.</p>
                    <ul class="list-disc ml-4 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Ringkasan siswa --}}
        @php
            $totalSkor = max(0, min(40, (int) ($s->total_kesulitan ?? 0)));
            $circ = 2 * M_PI * 42;
            $dash = $circ * $totalSkor / 40;

            $nis = optional($s->user)->nis ?? $s->nis ?? null;
            $noTelp = optional($s->user)->no_telp ?? null;

            // Warna cincin (terang, untuk latar biru tua)
            $ringColor = match($s->hasil_label ?? '') {
                'Normal' => '#34D399',
                'Borderline' => '#FBBF24',
                'Abnormal' => '#FCA5A5',
                default => '#CBD5E1',
            };

            // Warna teks badge (lebih gelap, agar terbaca di latar putih)
            $badgeColor = match($s->hasil_label ?? '') {
                'Normal' => '#0F8A5F',
                'Borderline' => '#B7690B',
                'Abnormal' => '#C8303C',
                default => '#475569',
            };
        @endphp

        <section class="report-hero">
            <span class="hero-orbit"></span>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-5 md:gap-7">
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-4">
                        <div class="report-avatar">
                            {{ strtoupper(substr($s->nama, 0, 2)) }}
                        </div>

                        <div class="min-w-0">
                            <p class="text-xs text-white/70 mb-1">Laporan Konseling Siswa</p>
                            <h3 class="report-name truncate">{{ $s->nama }}</h3>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2 mt-4">
                        <span class="report-pill">
                            <span class="material-symbols-outlined">school</span>
                            Kelas {{ $s->kelas ?? '-' }}
                        </span>

                        @if($nis)
                            <span class="report-pill">
                                <span class="material-symbols-outlined">badge</span>
                                NIS {{ $nis }}
                            </span>
                        @endif

                        @if($tglSkrining)
                            <span class="report-pill">
                                <span class="material-symbols-outlined">calendar_month</span>
                                {{ $tglSkrining->translatedFormat('j F Y') }}
                            </span>
                            <span class="report-pill">
                                <span class="material-symbols-outlined">schedule</span>
                                {{ $tglSkrining->format('H.i') }} WIB · {{ $tglSkrining->diffForHumans() }}
                            </span>
                        @endif

                        @if($noTelp)
                            <span class="report-pill">
                                <span class="material-symbols-outlined">phone</span>
                                {{ $noTelp }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="report-score">
                    <div class="score-ring">
                        <svg viewBox="0 0 100 100" aria-hidden="true">
                            <circle cx="50" cy="50" r="42"
                                    fill="none"
                                    stroke="rgba(255,255,255,.20)"
                                    stroke-width="8"/>
                            <circle cx="50" cy="50" r="42"
                                    fill="none"
                                    stroke="{{ $ringColor }}"
                                    stroke-width="8"
                                    stroke-linecap="round"
                                    stroke-dasharray="{{ $dash }} {{ $circ - $dash }}"/>
                        </svg>
                        <div class="score-number">
                            {{ $totalSkor }}
                            <small>dari 40</small>
                        </div>
                    </div>

                    <div class="score-meta">
                        <p class="score-label">Total skor kesulitan</p>
                        <span class="score-badge" style="color:{{ $badgeColor }}">
                            SDQ: {{ $s->hasil_label ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1.15fr)_minmax(320px,.85fr)] gap-5 md:gap-6 items-start">

            {{-- Form laporan --}}
            <section class="card p-4 sm:p-5 md:p-6">
                <div class="flex items-start gap-3 mb-6">
                    <span class="ico">
                        <span class="material-symbols-outlined" style="font-size:20px">description</span>
                    </span>
                    <div>
                        <h3 class="h-title text-lg">{{ $modeEdit ? 'Edit Laporan Konseling' : 'Laporan Konseling' }}</h3>
                        <p class="h-sub text-xs md:text-sm">
                            Tulis rekomendasi profesional berdasarkan hasil skrining dan kondisi siswa.
                        </p>
                    </div>
                </div>

                @if(!$modeEdit && $laporan->exists && filled($laporan->rekomendasi))
                    <div class="status-box status-success mb-5">
                        <span class="material-symbols-outlined flex-shrink-0" style="font-size:20px">check_circle</span>
                        <p class="text-xs md:text-sm leading-relaxed">
                            Laporan untuk skrining ini sudah tersimpan. Kamu dapat memperbaruinya melalui riwayat laporan di bawah.
                        </p>
                    </div>
                @endif

                @if($modeEdit)
                    <div class="status-box status-info mb-5">
                        <span class="material-symbols-outlined flex-shrink-0" style="font-size:20px">edit_note</span>
                        <p class="text-xs md:text-sm leading-relaxed">
                            Kamu sedang mengedit laporan yang sudah tersimpan. Perubahan akan menggantikan isi laporan tersebut.
                        </p>
                    </div>
                @endif

                <form method="POST"
                      action="{{ $modeEdit ? '/riwayat/'.$s->id.'/laporan/'.$laporan->id : '/riwayat/'.$s->id.'/laporan' }}"
                      class="space-y-5">
                    @csrf
                    @if($modeEdit)
                        @method('PUT')
                    @endif

                    <div>
                        <label for="tanggal_laporan" class="field-label">Tanggal Laporan</label>
                        <input
                            type="date"
                            id="tanggal_laporan"
                            name="tanggal_laporan"
                            class="input"
                            value="{{ old('tanggal_laporan', $tglLaporan->format('Y-m-d')) }}"
                            required
                        >
                        <p class="field-help">Tanggal pencatatan laporan oleh Guru BK.</p>
                    </div>

                    {{--
                        Observasi sengaja tidak ditampilkan.
                        Backend saat ini tetap menerima field observasi secara nullable,
                        sehingga halaman tidak perlu mengubah controller/database.
                    --}}

                    <div>
                        <label for="rekomendasi" class="field-label">
                            Rekomendasi Guru BK <span class="text-[#B42318]">*</span>
                        </label>
                        <textarea
                            id="rekomendasi"
                            name="rekomendasi"
                            class="textarea"
                            minlength="10"
                            maxlength="5000"
                            placeholder="Tuliskan rekomendasi tindak lanjut yang akan dilakukan berdasarkan kondisi siswa..."
                            required
                        >{{ old('rekomendasi', $laporan->rekomendasi) }}</textarea>
                        <p class="field-help">Rekomendasi ini menjadi isi resmi laporan dan akan digunakan saat laporan diunduh sebagai PDF.</p>
                    </div>

                    <div class="form-actions pt-2 flex flex-wrap items-center justify-end gap-2 no-print">
                        <a href="{{ $modeEdit ? '/riwayat/'.$s->id.'/laporan' : '/riwayat/'.$s->id }}" class="btn-ghost">
                            <span class="material-symbols-outlined" style="font-size:18px">close</span>
                            Batal
                        </a>
                        <button type="submit" class="btn-primary">
                            <span class="material-symbols-outlined" style="font-size:18px">save</span>
                            {{ $modeEdit ? 'Simpan Perubahan' : 'Simpan Laporan' }}
                        </button>
                    </div>
                </form>
            </section>

            {{-- Referensi sistem --}}
            <aside class="auto-box p-4 sm:p-5 md:p-6">
                <div class="flex items-start gap-3">
                    <span class="ico" style="background:var(--ai-bg);color:var(--ai)">
                        <span class="material-symbols-outlined" style="font-size:20px">psychology</span>
                    </span>
                    <div class="min-w-0">
                        <h3 class="h-title text-base">Saran Sistem</h3>
                        <p class="h-sub text-xs leading-relaxed">
                            Referensi otomatis berdasarkan hasil skrining. Isi ini tidak menggantikan penilaian Guru BK.
                        </p>
                    </div>
                </div>

                <div class="mt-5 rounded-xl bg-white/80 border border-[#C9E4F0] p-4">
                    <p class="text-xs leading-relaxed text-[#334155] whitespace-pre-line">{{ $rekomendasiOtomatis ?? 'Belum ada saran sistem.' }}</p>
                </div>

                <div class="mt-4 flex items-start gap-2 text-[11.5px] leading-relaxed text-[#0A5F86]">
                    <span class="material-symbols-outlined flex-shrink-0" style="font-size:17px">info</span>
                    <p>Guru BK tetap menentukan rekomendasi akhir yang dicatat pada laporan.</p>
                </div>
            </aside>
        </div>

        {{-- Riwayat laporan siswa --}}
        <section id="riwayat-laporan" class="card p-4 sm:p-5 md:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                <div class="flex items-start gap-3">
                    <span class="ico">
                        <span class="material-symbols-outlined" style="font-size:20px">history</span>
                    </span>
                    <div>
                        <h3 class="h-title text-lg">Riwayat Laporan</h3>
                        <p class="h-sub text-xs md:text-sm">Laporan yang pernah dibuat untuk siswa ini.</p>
                    </div>
                </div>

                @if(count($riwayatLaporan ?? []))
                    <span class="badge b-none self-start">{{ count($riwayatLaporan) }} laporan</span>
                @endif
            </div>

            @if(empty($riwayatLaporan) || count($riwayatLaporan) === 0)
                <div class="rounded-xl border border-dashed border-[#CBD5E1] bg-[#F8FAFC] p-6 text-center">
                    <span class="material-symbols-outlined text-[#94A3B8]" style="font-size:30px">folder_open</span>
                    <p class="text-sm font-semibold text-[#475569] mt-2">Belum ada laporan tersimpan.</p>
                    <p class="text-xs text-[#94A3B8] mt-1">Laporan yang sudah disimpan akan muncul di bagian ini.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($riwayatLaporan as $item)
                        @php
                            $tglItem = $item->tanggal_laporan
                                ? \Carbon\Carbon::parse($item->tanggal_laporan)->timezone('Asia/Jakarta')->locale('id')
                                : null;
                            $hasilItem = $item->hasilSdq;
                            $isCurrent = $hasilItem && (int)$hasilItem->id === (int)$s->id;
                        @endphp

                        <article class="history-card p-4 {{ $isCurrent ? 'border-[#9DBDEB] bg-[#F8FBFF]' : '' }}">
                            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                        @if($tglItem)
                                            <span class="text-xs font-bold text-[#14233B]">{{ $tglItem->translatedFormat('j F Y') }}</span>
                                        @endif

                                        @if($isCurrent)
                                            <span class="badge b-ok">Skrining ini</span>
                                        @endif

                                        @if($hasilItem)
                                            <span class="badge {{ match($hasilItem->hasil_label ?? '') { 'Normal' => 'b-ok', 'Borderline' => 'b-warn', 'Abnormal' => 'b-act', default => 'b-none' } }}">
                                                {{ $hasilItem->hasil_label ?? '-' }}
                                            </span>
                                        @endif
                                    </div>

                                    <p class="history-text text-xs md:text-sm text-[#475569]">
                                        {{ $item->rekomendasi }}
                                    </p>
                                </div>

                                <div class="hist-actions flex flex-wrap md:flex-col gap-2 md:min-w-[130px] md:items-stretch no-print">
                                    @if($hasilItem)
                                        <a href="/riwayat/{{ $hasilItem->id }}/laporan/{{ $item->id }}/edit" class="btn-ghost !px-3 !py-2 text-xs">
                                            <span class="material-symbols-outlined" style="font-size:16px">edit</span>
                                            Edit
                                        </a>
                                        <a href="/riwayat/{{ $hasilItem->id }}/laporan/pdf" target="_blank" class="btn-primary !px-3 !py-2 text-xs">
                                            <span class="material-symbols-outlined" style="font-size:16px">picture_as_pdf</span>
                                            PDF
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        <div class="back-wrap flex justify-start no-print">
            <a href="/riwayat/{{ $s->id }}" class="btn-ghost">
                <span class="material-symbols-outlined" style="font-size:18px">arrow_back</span>
                Kembali ke Detail Skrining
            </a>
        </div>

    </div>
</main>

</body>
</html>