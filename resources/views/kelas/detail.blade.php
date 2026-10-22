<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelas {{ $kode }} | SMPN 216 Jakarta</title>
    <link rel="icon" type="image/png" href="{{ asset('logo-smpn216.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Source+Serif+4:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700&display=swap" rel="stylesheet">
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
            background:
                radial-gradient(900px 400px at 85% -80px, #DCE8FA 0%, transparent 70%),
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

        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 99px;
        }

        :focus-visible {
            outline: 2px solid var(--brand);
            outline-offset: 2px;
        }

        /* CSS khusus halaman Kelas */
        .page-content {
            background: transparent;
        }

        /* Kartu: garis tipis, tanpa bayangan */
        .table-card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 14px;
            overflow: hidden;
        }

        .h-title { font-weight: 600; color: var(--ink); }
        .h-sub   { color: var(--ink-3); margin-top: 2px; }

        /* Badge status (pill) */
        .pill {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .p-ok   { background: var(--ok-bg);   color: var(--ok); }
        .p-warn { background: var(--warn-bg); color: var(--warn); }
        .p-act  { background: var(--act-bg);  color: var(--act); }
        .p-none { background: #E8ECF2;        color: var(--ink-2); }

        /* Tabel polos */
        .tbl th {
            padding: 12px 20px;
            text-align: left;
            font-weight: 600;
            color: var(--ink-3);
            background: #F7F9FC;
            border-bottom: 1px solid var(--line);
            white-space: nowrap;
        }

        .tbl td {
            padding: 14px 20px;
            vertical-align: middle;
            color: var(--ink-2);
            white-space: nowrap;
        }

        .tbl tbody tr { border-bottom: 1px solid var(--line); }
        .tbl tbody tr:last-child { border-bottom: none; }
        .tbl tbody tr:hover { background: #F8FAFD; }

        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 13px;
            font-weight: 600;
            color: var(--brand);
            padding: 6px 12px;
            border-radius: var(--r-sm);
            border: 1px solid var(--line);
            background: #fff;
            transition: .15s;
            white-space: nowrap;
        }

        .btn-detail:hover {
            background: var(--brand-soft);
            border-color: #B9D0F2;
        }

        /* ---------- Mobile: tabel biasa, geser ke samping (sama seperti tabel Riwayat) ---------- */
        .tbl { min-width: 720px; }
        .tbl th.no, .tbl td.no { width: 56px; text-align: center; padding-left: 14px; padding-right: 14px; }
        .tbl td.no { color: var(--ink-3); font-variant-numeric: tabular-nums; }

        @media (max-width: 767px) {
            .table-card { border-radius: 12px; }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/icons.css') }}">
    <script src="{{ asset('js/icons.js') }}" defer></script>
</head>

<body class="flex min-h-screen">

@include('partials.sidebar_dashboard_gurubk')

@php
    // Ringkasan kelas (hanya tampilan)
    $jmlSiswa  = $siswaList->count();
    $jmlNormal = $siswaList->filter(fn ($x) => ($x->hasil_terakhir->hasil_label ?? null) === 'Normal')->count();
    $jmlBorder = $siswaList->filter(fn ($x) => ($x->hasil_terakhir->hasil_label ?? null) === 'Borderline')->count();
    $jmlAbn    = $siswaList->filter(fn ($x) => ($x->hasil_terakhir->hasil_label ?? null) === 'Abnormal')->count();
    $jmlBelum  = $siswaList->filter(fn ($x) => empty($x->hasil_terakhir))->count();
@endphp

{{-- MAIN --}}
<main class="flex-1 min-w-0 flex flex-col">

    {{-- Header khusus HP: tombol menu + judul kelas (di desktop sidebar sudah tampil) --}}
    <header class="lg:hidden h-14 bg-white/90 backdrop-blur-md border-b border-[#E3E8F0] flex items-center gap-3 px-4 sticky top-0 z-30">
        <button id="hamburger-btn" onclick="openSidebar()" aria-label="Buka menu"
                class="w-9 h-9 rounded-[9px] border border-[#E3E8F0] flex items-center justify-center hover:bg-[#E8F0FB] transition-colors flex-shrink-0">
            <span class="material-symbols-outlined text-[#475569]" style="font-size:20px">menu</span>
        </button>
        <div class="min-w-0">
            <h2 class="text-base font-bold text-[#14233B] leading-tight truncate">Kelas {{ $kode }}</h2>
            <p class="text-xs text-[#6B7A90] truncate">Siswa dan hasil skrining terakhir</p>
        </div>
    </header>

    <div class="page-content flex-1 overflow-y-auto scrollbar-thin p-4 md:p-8 space-y-5 md:space-y-6">

        {{-- TOMBOL LULUS --}}
        @if(preg_match('/^9-\d+$/', trim($kode)) && $siswaList->count() > 0)

            <form action="{{ route('kelas.lulus', ['kode' => $kode]) }}"
                  method="POST"
                  onsubmit="return confirm('Yakin semua siswa aktif di kelas {{ $kode }} sudah lulus? Data SDQ tetap akan disimpan.');">

                @csrf

                <button type="submit"
                        class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2.5 rounded-lg bg-green-600 text-white text-sm font-semibold hover:bg-green-700 transition">

                    <span class="material-symbols-outlined align-middle mr-1.5" style="font-size:18px">
                        school
                    </span>

                    Tandai Semua Siswa Lulus

                </button>

            </form>

        @endif

        {{-- TABEL --}}
        <section class="table-card">

            <div class="px-4 sm:px-5 md:px-6 py-4 md:py-5 border-b border-[#E3E8F0]">

                <h3 class="h-title">
                    Data Siswa
                </h3>

                <p class="h-sub">
                    Daftar siswa dan hasil skrining terakhir
                </p>

                {{-- Ringkasan kelas --}}
                <div class="flex flex-wrap items-center gap-2 mt-3.5">
                    <span class="text-[13px] font-semibold text-[#14233B] mr-1">{{ $jmlSiswa }} siswa</span>
                    <span class="pill p-ok">{{ $jmlNormal }} Normal</span>
                    <span class="pill p-warn">{{ $jmlBorder }} Borderline</span>
                    <span class="pill p-act">{{ $jmlAbn }} Abnormal</span>
                    <span class="pill p-none">{{ $jmlBelum }} belum mengisi</span>
                </div>

            </div>

            {{-- Tabel (di HP bisa digeser ke samping) --}}
            <div class="overflow-x-auto scrollbar-thin">

                <table class="tbl w-full">

                    <thead>
                        <tr>
                            <th class="no">No</th>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Hasil Terakhir</th>
                            <th>Total Skor</th>
                            <th>Tanggal Isi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($siswaList as $siswa)

                            @php
                                $h = $siswa->hasil_terakhir;

                                $pClass = match($h->hasil_label ?? null) {
                                    'Normal'     => 'p-ok',
                                    'Borderline' => 'p-warn',
                                    'Abnormal'   => 'p-act',
                                    default      => 'p-none',
                                };
                            @endphp

                            <tr>

                                <td class="no">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="font-semibold text-[#14233B]">
                                    {{ $siswa->name }}
                                </td>

                                <td>
                                    {{ $siswa->nis ?? '-' }}
                                </td>

                                <td>
                                    @if($h)
                                        <span class="pill {{ $pClass }}">{{ $h->hasil_label }}</span>
                                    @else
                                        <span class="text-[12px] text-[#94A3B8] italic">Belum mengisi</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $h ? $h->total_kesulitan . '/40' : '-' }}
                                </td>

                                <td>
                                    {{ $h ? $h->created_at->format('d/m/Y') : '-' }}
                                </td>

                                <td>
                                    @if($h)
                                        <a href="/riwayat/{{ $h->id }}" class="btn-detail">
                                            Detail
                                            <span class="material-symbols-outlined" style="font-size:15px">chevron_right</span>
                                        </a>
                                    @else
                                        <span class="text-[#CBD5E1]">-</span>
                                    @endif
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7"
                                    class="!px-5 !py-16 text-center text-[#6B7A90]">
                                    Tidak ada siswa di kelas ini
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>

        <footer class="pt-4 border-t border-[#E3E8F0] flex flex-col sm:flex-row sm:justify-between items-center text-center gap-1 sm:gap-2">

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