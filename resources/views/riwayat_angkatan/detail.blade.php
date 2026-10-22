<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelas {{ $kode }} | SMPN 216 Jakarta</title>
    <link rel="icon" type="image/png" href="{{ asset('logo-smpn216.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,500;8..60,600;8..60,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700&display=swap" rel="stylesheet">
    @vite('resources/css/tema.css')

    {{-- CSS khusus halaman Kelas. Font, ukuran font, radius, dan CSS sidebar ikut tema.css --}}
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
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .scrollbar-thin::-webkit-scrollbar { width: 6px; height: 6px; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 99px; }

        :focus-visible { outline: 2px solid var(--brand); outline-offset: 2px; }

        .page-content { background: transparent; }

        .table-card {
            background: #fff;
            border: 1px solid #E3E8F0;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(15,39,71,.025);
        }

        .h-title { color: var(--ink); }
        .h-sub   { color: var(--ink-3); margin-top: 2px; }

        /* Badge status (ukuran font dari tema.css) */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-weight: 700;
            white-space: nowrap;
        }
        .b-ok   { background: var(--ok-bg);   color: var(--ok); }
        .b-warn { background: var(--warn-bg); color: var(--warn); }
        .b-act  { background: var(--act-bg);  color: var(--act); }
        .b-none { background: #E8ECF2;        color: var(--ink-2); }

        /* Tombol Detail (ukuran font dan radius dari tema.css) */
        .btn-line {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            border: 1px solid var(--line);
            background: #fff;
            font-weight: 600;
            color: var(--brand);
            transition: .15s;
            white-space: nowrap;
        }
        .btn-line:hover { background: var(--brand-soft); border-color: #B9D0F2; }

        /* Tombol lulus (hijau, ukuran dan sudut ikut tema) */
        .btn-lulus {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            border-radius: var(--r-btn);
            background: #16A34A;
            color: #fff;
            font-size: 13.5px;
            font-weight: 600;
            transition: .15s;
        }
        .btn-lulus:hover { background: #15803D; }

        @media (max-width: 639px) {
            .table-card { border-radius: 12px; }
        }
    </style>
</head>

<body class="flex min-h-screen">

@include('partials.sidebar_dashboard_gurubk')

{{-- MAIN --}}
<main class="flex-1 min-w-0 flex flex-col">

    <div class="page-content flex-1 overflow-y-auto scrollbar-thin p-4 md:p-8 space-y-5 md:space-y-6">

        {{-- TOMBOL LULUS --}}
        @if(preg_match('/^9-\d+$/', trim($kode)) && $siswaList->count() > 0)

            <form action="{{ route('kelas.lulus', ['kode' => $kode]) }}"
                  method="POST"
                  onsubmit="return confirm('Yakin semua siswa aktif di kelas {{ $kode }} sudah lulus? Data SDQ tetap akan disimpan.');">

                @csrf

                <button type="submit" class="btn-lulus w-full sm:w-auto">

                    <span class="material-symbols-outlined align-middle mr-1.5" style="font-size:18px">
                        school
                    </span>

                    Tandai Semua Siswa Lulus

                </button>

            </form>

        @endif

        {{-- TABEL --}}
        <section class="table-card">

            <div class="px-4 sm:px-5 py-4 border-b border-[#E3E8F0] flex items-center justify-between">

                <div>
                    <h3 class="h-title">
                        Data Siswa
                    </h3>

                    <p class="h-sub">
                        Daftar siswa dan hasil skrining terakhir
                    </p>
                </div>

            </div>

            <div class="overflow-x-auto scrollbar-thin">

                <table class="tbl w-full min-w-[640px]">

                    <thead>
                        <tr class="bg-[#EFF6FF] text-[#1E40AF] uppercase tracking-wide whitespace-nowrap">

                            <th class="px-4 sm:px-5 py-3 text-left font-semibold">
                                Nama
                            </th>

                            <th class="px-4 sm:px-5 py-3 text-left font-semibold">
                                NIS
                            </th>

                            <th class="px-4 sm:px-5 py-3 text-left font-semibold">
                                Hasil Terakhir
                            </th>

                            <th class="px-4 sm:px-5 py-3 text-left font-semibold">
                                Total Skor
                            </th>

                            <th class="px-4 sm:px-5 py-3 text-left font-semibold">
                                Tanggal Isi
                            </th>

                            <th class="px-4 sm:px-5 py-3 text-left font-semibold">
                                Aksi
                            </th>

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#E2E8F0]">

                        @forelse($siswaList as $siswa)

                            @php
                                $h = $siswa->hasil_terakhir;

                                $badge = match($h->hasil_label ?? null) {
                                    'Normal'     => 'b-ok',
                                    'Borderline' => 'b-warn',
                                    'Abnormal'   => 'b-act',
                                    default      => 'b-none',
                                };
                            @endphp

                            <tr class="hover:bg-[#F8FAFC] transition-colors">

                                <td class="px-4 sm:px-5 py-3.5 font-semibold text-[#1E293B] whitespace-nowrap">
                                    {{ $siswa->name }}
                                </td>

                                <td class="px-4 sm:px-5 py-3.5 text-[#64748B] whitespace-nowrap">
                                    {{ $siswa->nis ?? '-' }}
                                </td>

                                <td class="px-4 sm:px-5 py-3.5">

                                    @if($h)

                                        <span class="badge {{ $badge }}">
                                            {{ $h->hasil_label }}
                                        </span>

                                    @else

                                        <span class="text-[12px] text-[#94A3B8] italic whitespace-nowrap">
                                            Belum mengisi
                                        </span>

                                    @endif

                                </td>

                                <td class="px-4 sm:px-5 py-3.5 text-[#64748B] whitespace-nowrap">
                                    {{ $h ? $h->total_kesulitan . '/40' : '-' }}
                                </td>

                                <td class="px-4 sm:px-5 py-3.5 text-[#64748B] whitespace-nowrap">
                                    {{ $h ? $h->created_at->format('d/m/Y') : '-' }}
                                </td>

                                <td class="px-4 sm:px-5 py-3.5 text-left">

                                    @if($h)

                                        <a href="/riwayat/{{ $h->id }}"
                                           class="btn-line">

                                            Detail

                                            <span class="material-symbols-outlined" style="font-size:15px">
                                                chevron_right
                                            </span>

                                        </a>

                                    @else

                                        <span class="text-[#CBD5E1]">
                                            -
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="px-5 py-16 text-center text-[#64748B]">

                                    Tidak ada siswa di kelas ini

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>

        <footer class="pt-4 border-t border-[#E3E8F0] flex justify-between items-center flex-wrap gap-2">

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