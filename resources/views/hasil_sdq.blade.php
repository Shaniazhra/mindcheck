@php
    $logoUrl = \App\Models\Pengaturan::url('logo', 'logo-smpn216.png');

    $finalLabel = $samuel['keputusan_akhir'] ?? $label;
    // "High Risk" dipetakan ke "Abnormal" agar konsisten. Label klinis tidak ditampilkan kepada siswa.
    $displayLabel = $finalLabel === 'High Risk' ? 'Abnormal' : $finalLabel;

    // Warna dan bahasa dibuat lembut agar tidak menimbulkan kecemasan
    $tema = match($displayLabel) {
        'Normal' => [
            'fg'       => '#1B7F5A',
            'tagBg'    => '#D1FAE5',
            'tag'      => 'Baik',
            'icon'     => 'sentiment_satisfied',
            'judul'    => 'Kondisimu terlihat baik',
            'deskripsi'=> 'Terima kasih telah menjawab dengan jujur. Dari jawabanmu, kondisimu saat ini terlihat baik. Teruslah menjaga keseimbangan emosi dan hubunganmu dengan orang-orang di sekitarmu.',
            'langkah3' => 'Tidak ada yang perlu kamu lakukan sekarang. Jika suatu hari ingin bercerita, ruang BK selalu terbuka untukmu.',
        ],
        'Borderline' => [
            'fg'       => '#B45309',
            'tagBg'    => '#FEF3C7',
            'tag'      => 'Perlu diperhatikan',
            'icon'     => 'self_improvement',
            'judul'    => 'Terima kasih telah bersedia bercerita',
            'deskripsi'=> 'Ada beberapa hal yang dapat dibicarakan secara perlahan. Merasa lelah atau cemas sesekali adalah hal yang wajar. Guru BK dengan senang hati menemanimu jika kamu membutuhkan teman bicara.',
            'langkah3' => 'Guru BK dapat mengajakmu berbincang secara pribadi. Kamu juga boleh datang ke ruang BK kapan pun kamu mau.',
        ],
        'Abnormal' => [
            'fg'       => '#0369A1',
            'tagBg'    => '#E0F2FE',
            'tag'      => 'Perlu ditemani',
            'icon'     => 'diversity_3',
            'judul'    => 'Kamu tidak sendirian',
            'deskripsi'=> 'Terima kasih telah menjawab dengan jujur. Ada beberapa hal yang akan lebih baik dibicarakan bersama. Hal ini bukan sesuatu yang perlu ditakuti. Guru BK siap mendampingimu dengan penuh perhatian, kapan pun kamu bersedia.',
            'langkah3' => 'Guru BK akan mengajakmu berbincang secara pribadi dan mendampingimu. Kamu juga boleh datang ke ruang BK kapan pun kamu siap.',
        ],
        default => [
            'fg'       => '#1D5FBF',
            'tagBg'    => '#E8F0FB',
            'tag'      => 'Selesai',
            'icon'     => 'task_alt',
            'judul'    => 'Terima kasih telah menjawab',
            'deskripsi'=> 'Jawabanmu sudah kami terima dan tersimpan dengan aman.',
            'langkah3' => 'Jika ingin bercerita, ruang BK selalu terbuka untukmu.',
        ],
    };

    $nama      = auth()->check() ? auth()->user()->name : '';
    $namaDepan = \Illuminate\Support\Str::words($nama, 1, '');
    $sekarang  = now('Asia/Jakarta')->locale('id');

    // Pesan penyemangat, berganti tiap hari
    $afirmasi = [
        'Setiap langkah kecil yang kamu ambil hari ini tetap berarti. Teruslah melangkah dengan percaya diri.',
        'Kamu mampu melewati hari ini. Tidak perlu sempurna, cukup lakukan yang terbaik yang kamu bisa.',
        'Bercerita kepada orang yang dipercaya adalah tanda keberanian. Kamu hebat telah melangkah sejauh ini.',
        'Kamu berharga, apa pun hasil dan nilaimu. Terima kasih telah berusaha dengan sungguh-sungguh.',
        'Hari yang berat pasti akan berlalu. Kamu tidak sendirian, selalu ada yang siap membantumu.',
        'Beristirahat sejenak bukan berarti menyerah. Itu cara memberi tenaga agar kamu dapat melangkah lagi.',
        'Kamu memiliki kekuatan dan kebaikan yang membuat lingkungan di sekitarmu menjadi lebih baik.',
    ];
    $pesanHariIni = $afirmasi[now('Asia/Jakarta')->dayOfYear % count($afirmasi)];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Skrining | SMPN 216 Jakarta</title>
    <link rel="icon" type="image/png" href="{{ $logoUrl }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Source+Serif+4:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    @vite('resources/css/tema.css')
    
    <style>
        /* ============ Warna (sama dengan halaman Kuesioner SDQ dan halaman Guru BK) ============ */
        :root {
            --navy: #0F2747;
            --navy-deep: #0B1F3A;
            --navy-mid: #15407F;
            --brand: #1D5FBF;
            --brand-deep: #174C99;
            --brand-mid: #2B78E0;
            --brand-soft: #E8F0FB;
            --bg: #F3F6FB;
            --ink: #14233B;
            --ink-2: #475569;
            --ink-3: #6B7A90;
            --line: #E3E8F0;
            --tone-fg: #1D5FBF;
            --tone-bg: #E8F0FB;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        html, body { min-height: 100%; }
        body {
            font-family: 'Inter', system-ui, sans-serif; 
            color: var(--ink);
            background: radial-gradient(900px 400px at 85% -80px, #DCE8FA 0%, transparent 70%), var(--bg);
            background-attachment: fixed;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4 {
        font-family: 'Source Serif 4', Georgia, serif;
    }
        a { color: inherit; text-decoration: none; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; font-size: 20px; line-height: 1; }
        .fill { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        :focus-visible { outline: 2px solid var(--brand-mid); outline-offset: 2px; border-radius: 8px; }

        /* Muncul pelan saat halaman dibuka */
        .rise { animation: rise .6s cubic-bezier(.2,.7,.2,1) both; animation-delay: var(--d, 0s); }
        @keyframes rise { from { opacity: 0; transform: translateY(14px); } }

        /* ============ Header ============ */
        .topbar {
            position: sticky; top: 0; z-index: 30;
            height: 64px; padding: 0 16px;
            display: flex; align-items: center; justify-content: space-between; gap: 12px;
            background: rgba(255,255,255,.92);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--line);
        }
        .brand { display: flex; align-items: center; gap: 12px; min-width: 0; }
        .brand-logo {
            width: 40px; height: 40px; flex-shrink: 0;
            background: transparent; border: none; box-shadow: none;
            padding: 0; display: flex; align-items: center; justify-content: center;
        }
        .brand-logo img { width: 100%; height: 100%; object-fit: contain; }
        .brand-name { font-size: .95rem; font-weight: 700; line-height: 1.2; }
        .brand-sub { font-size: .72rem; color: var(--ink-3); margin-top: 1px; }
        .date-pill {
            display: none; align-items: center; gap: 8px;
            padding: 8px 12px; border-radius: 8px;
            background: var(--bg); border: 1px solid var(--line);
            font-size: .75rem; font-weight: 500; color: var(--ink-2); white-space: nowrap;
        }
        .date-pill .material-symbols-outlined { font-size: 16px; }
        @media (min-width: 640px) { .date-pill { display: flex; } }
        @media (min-width: 768px) { .topbar { padding: 0 32px; } }

        /* ============ Halaman ============ */
        /* Konten di tengah dengan lebar dibatasi, tidak mepet kiri-kanan */
        .wrap { width: 100%; max-width: 1040px; margin: 0 auto; padding: 28px 16px 40px; }
        @media (min-width: 768px) { .wrap { padding: 44px 40px 48px; } }

        /* ============ Hero hasil ============ */
        .hero {
            position: relative; overflow: hidden;
            border-radius: 20px; padding: 24px 28px; color: #fff;
            background: linear-gradient(120deg, var(--navy-deep) 0%, var(--navy-mid) 55%, var(--brand-mid) 100%);
            box-shadow: 0 18px 40px -18px rgba(21,64,127,.65);
        }
        .hero::after {
            content: ''; position: absolute; inset: 0; pointer-events: none;
            background: linear-gradient(135deg, rgba(255,255,255,.1) 0%, transparent 42%);
        }
        .hero > * { position: relative; z-index: 1; }
        .hero-in { display: flex; align-items: flex-start; gap: 18px; }
        .hero-in > div { flex: 1; min-width: 0; }
        .tone-icon {
            width: 54px; height: 54px; flex-shrink: 0;
            border-radius: 16px; background: #fff;
            display: flex; align-items: center; justify-content: center;
            color: var(--tone-fg);
            box-shadow: 0 14px 28px -14px rgba(0,0,0,.5);
            animation: pop .55s .15s cubic-bezier(.34,1.56,.64,1) both;
        }
        .tone-icon .material-symbols-outlined { font-size: 29px; }
        @keyframes pop { from { transform: scale(.6); opacity: 0; } to { transform: none; opacity: 1; } }

        .hero .kicker { font-size: .75rem; font-weight: 600; color: #CFE0FA; }
        .hero h1 {
            margin-top: 4px;
            font-size: clamp(1.2rem, 2.2vw, 1.5rem);
            font-weight: 700; line-height: 1.25; letter-spacing: -.01em;
        }
        .hero .desc { margin-top: 10px; font-size: .88rem; line-height: 1.7; color: #DCE8FA; }
        .tags { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 16px; }
        .tag-tone {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 12px; border-radius: 999px;
            background: var(--tone-bg); color: var(--tone-fg);
            font-size: .74rem; font-weight: 800;
        }
        .tag-tone .material-symbols-outlined { font-size: 16px; }
        .tag {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 12px; border-radius: 999px;
            background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.22);
            font-size: .74rem; font-weight: 600; color: #fff;
        }
        .tag .material-symbols-outlined { font-size: 16px; opacity: .9; }

        /* ============ Dua kolom: langkah selanjutnya + yang dapat dilakukan ============ */
        .cols { display: grid; grid-template-columns: minmax(0, 1fr); gap: 36px; margin-top: 40px; }
        @media (min-width: 900px) {
            .cols { grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: 0; }
            .cols > section:first-child { padding-right: 48px; }
            .cols > section:last-child { padding-left: 48px; border-left: 1px solid var(--line); }
        }
        .sec-title {
            display: flex; align-items: center; gap: 12px;
            font-size: .72rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; color: var(--ink-3);
        }
        .sec-title::after { content: ''; flex: 1; height: 1px; background: var(--line); }

        .timeline { list-style: none; margin-top: 20px; }
        .timeline li { position: relative; padding: 0 0 22px 52px; min-height: 34px; }
        .timeline li:last-child { padding-bottom: 0; }
        .timeline li:not(:last-child)::before {
            content: ''; position: absolute; left: 15px; top: 36px; bottom: 4px; width: 2px;
            background: linear-gradient(var(--brand-mid), #BCD0F0); border-radius: 2px;
        }
        .tn {
            position: absolute; left: 0; top: 0;
            width: 32px; height: 32px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            background: var(--brand); color: #fff;
            font-size: .85rem; font-weight: 800;
            box-shadow: 0 8px 16px -8px var(--brand);
        }
        .timeline h3 { font-size: .95rem; font-weight: 700; line-height: 1.4; padding-top: 4px; }
        .timeline p { margin-top: 3px; font-size: .85rem; color: var(--ink-2); line-height: 1.7; }

        .todo { list-style: none; margin-top: 8px; }
        .todo li { display: flex; gap: 14px; align-items: flex-start; padding: 16px 0; border-bottom: 1px solid var(--line); }
        .todo li:last-child { border-bottom: 0; }
        .t-ico {
            width: 42px; height: 42px; flex-shrink: 0; border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            background: var(--brand-soft); color: var(--brand);
        }
        .t-ico .material-symbols-outlined { font-size: 22px; font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .todo b { display: block; font-size: .92rem; font-weight: 700; line-height: 1.4; }
        .todo span.s { display: block; margin-top: 2px; font-size: .85rem; color: var(--ink-2); line-height: 1.7; }

        /* ============ Pesan penyemangat ============ */
        .pesan {
            margin-top: 40px;
            display: flex; align-items: flex-start; gap: 14px;
            padding: 18px 22px; border-radius: 18px;
            background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);
            border: 1px solid #FDE68A;
        }
        .pesan > div { min-width: 0; }
        .pesan .p-ico {
            width: 44px; height: 44px; flex-shrink: 0; border-radius: 14px;
            background: rgba(255,255,255,.85); color: #D97706;
            display: flex; align-items: center; justify-content: center;
        }
        .pesan .p-ico .material-symbols-outlined { font-size: 24px; }
        .pesan .lbl { font-size: .74rem; font-weight: 800; color: #B45309; }
        .pesan p { margin-top: 3px; font-size: .95rem; font-weight: 600; line-height: 1.7; color: var(--ink); }

        /* ============ Dukungan ============ */
        .support {
            margin-top: 14px;
            display: flex; align-items: flex-start; gap: 12px;
            padding: 15px 18px; border-radius: 16px;
            background: #fff; border: 1px solid var(--line);
        }
        .support > p { min-width: 0; }
        .support .material-symbols-outlined { color: #0369A1; font-size: 22px; flex-shrink: 0; margin-top: 1px; }
        .support p { font-size: .85rem; line-height: 1.7; color: var(--ink-2); }
        .support b { color: var(--ink); }

        /* ============ Tombol ============ */
        .actions { display: flex; align-items: center; gap: 12px; margin-top: 32px; }
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 14px 28px; min-height: 50px; border-radius: 999px;
            font-size: .92rem; font-weight: 700;
            cursor: pointer; border: 1.5px solid transparent;
            transition: background .15s, transform .12s, border-color .15s, color .15s;
        }
        .btn:active { transform: scale(.98); }
        .btn .material-symbols-outlined { font-size: 19px; }
        .btn-primary { background: var(--brand); color: #fff; box-shadow: 0 10px 20px -12px var(--brand); }
        .btn-primary:hover { background: var(--brand-deep); }
        .btn-ghost { background: #fff; color: var(--ink-2); border-color: var(--line); }
        .btn-ghost:hover { color: var(--brand); border-color: #B9D0F2; background: var(--brand-soft); }

        .note { margin-top: 22px; font-size: .75rem; line-height: 1.7; color: var(--ink-3); }

        footer {
            margin-top: 30px; padding-top: 14px; border-top: 1px solid var(--line);
            display: flex; justify-content: space-between; flex-wrap: wrap; gap: 6px;
            font-size: .72rem; color: var(--ink-3);
        }

        /* ============ Perataan paragraf ============
           Dasarnya rata kiri supaya jarak antarkata rapi di kolom sempit dan di HP.
           Rata kanan-kiri (justify) hanya dipakai di layar lebar, pada paragraf yang
           lebarnya sudah dibatasi, supaya jarak antarkata tidak melebar atau mepet.
           Judul, label, tag, dan tombol tetap rata kiri/tengah. */
        .hero .desc,
        .timeline p,
        .todo span.s,
        .pesan p:not(.lbl),
        .support p,
        .note {
            text-align: left;
            overflow-wrap: break-word;
            word-spacing: normal;
            text-wrap: pretty;
        }
        @media (min-width: 900px) {
            .hero .desc            { max-width: 720px; text-align: justify; text-justify: inter-word; }
            .pesan p:not(.lbl)     { max-width: 900px; text-align: justify; text-justify: inter-word; }
            .support p             { max-width: 900px; text-align: justify; text-justify: inter-word; }
            .note                  { max-width: 900px; text-align: justify; text-justify: inter-word; }
        }

        /* ============ Tablet ke bawah ============ */
        @media (max-width: 899px) {
            .hero { padding: 24px 22px; }
            .cols { margin-top: 32px; }
        }

        /* ============ HP ============ */
        @media (max-width: 640px) {
            .topbar { height: 60px; padding: 0 12px; gap: 10px; }
            .brand { gap: 10px; }
            .brand-logo { width: 36px; height: 36px; }
            .brand-name { font-size: .9rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
            .brand-sub { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

            .wrap { padding: 20px 16px calc(28px + env(safe-area-inset-bottom, 0px)); }

            .hero { padding: 20px 16px; border-radius: 18px; }
            .hero-in { flex-direction: column; gap: 12px; }
            .tone-icon { width: 46px; height: 46px; border-radius: 14px; }
            .tone-icon .material-symbols-outlined { font-size: 25px; }
            .hero h1 { font-size: 1.2rem; }
            .hero .desc { margin-top: 8px; font-size: .85rem; line-height: 1.7; }
            .tags { margin-top: 14px; gap: 6px; }
            .tag-tone, .tag { padding: 6px 11px; font-size: .72rem; }

            .cols { gap: 28px; margin-top: 28px; }
            .timeline { margin-top: 16px; }
            .timeline li { padding-left: 46px; padding-bottom: 18px; }
            .timeline p { font-size: .82rem; }
            .todo li { gap: 12px; padding: 14px 0; }
            .t-ico { width: 38px; height: 38px; border-radius: 12px; }
            .t-ico .material-symbols-outlined { font-size: 20px; }
            .todo span.s { font-size: .82rem; }

            .pesan { margin-top: 28px; padding: 16px; gap: 12px; border-radius: 16px; }
            .pesan .p-ico { width: 40px; height: 40px; border-radius: 12px; }
            .pesan p { font-size: .9rem; }
            .support { padding: 14px 16px; border-radius: 14px; }
            .support p { font-size: .82rem; }

            .actions { flex-direction: column-reverse; align-items: stretch; margin-top: 24px; }
            .btn { width: 100%; }
            .note { font-size: .72rem; }

            footer { flex-direction: column; align-items: center; text-align: center; margin-top: 26px; }
        }
        @media (prefers-reduced-motion: reduce) {
            .rise, .tone-icon { animation: none !important; }
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <header class="topbar">
        <a href="/dashboard-siswa" class="brand" aria-label="Ke halaman hasil skrining saya">
            <span class="brand-logo"><img src="{{ $logoUrl }}" alt="Logo SMPN 216"></span>
            <span style="min-width:0">
                <span class="brand-name" style="display:block">SMPN 216 Jakarta</span>
                <span class="brand-sub" style="display:block">Skrining Kesehatan Mental</span>
            </span>
        </a>
        <span class="date-pill">
            <span class="material-symbols-outlined">calendar_today</span>
            {{ $sekarang->isoFormat('dddd, D MMMM Y') }}
        </span>
    </header>

    <main class="wrap">

        {{-- ===== Hasil ===== --}}
        <section class="hero rise" style="--tone-fg: {{ $tema['fg'] }}; --tone-bg: {{ $tema['tagBg'] }};">
            <div class="hero-in">
                <span class="tone-icon" aria-hidden="true">
                    <span class="material-symbols-outlined fill">{{ $tema['icon'] }}</span>
                </span>
                <div>
                    <p class="kicker">Skrining selesai{{ $namaDepan !== '' ? ', terima kasih ' . $namaDepan : '' }}</p>
                    <h1>{{ $tema['judul'] }}</h1>
                    <p class="desc">{{ $tema['deskripsi'] }}</p>
                    <div class="tags">
                        <span class="tag-tone"><span class="material-symbols-outlined fill">check_circle</span>{{ $tema['tag'] }}</span>
                        <span class="tag"><span class="material-symbols-outlined">lock</span>Hanya kamu dan Guru BK yang dapat melihat</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===== Langkah selanjutnya + yang dapat dilakukan ===== --}}
        <div class="cols rise" style="--d:.1s">
            <section aria-labelledby="judul-langkah">
                <h2 class="sec-title" id="judul-langkah">Apa yang terjadi selanjutnya</h2>
                <ol class="timeline">
                    <li>
                        <span class="tn">1</span>
                        <h3>Jawabanmu telah tersimpan</h3>
                        <p>Terima kasih. Jawabanmu tersimpan dengan aman dan bersifat rahasia.</p>
                    </li>
                    <li>
                        <span class="tn">2</span>
                        <h3>Guru BK meninjau hasilnya</h3>
                        <p>Detail analisis dikirimkan kepada Guru BK untuk dipahami bersama, bukan untuk menilai atau menghakimimu.</p>
                    </li>
                    <li>
                        <span class="tn">3</span>
                        <h3>Kamu dapat berbincang kapan saja</h3>
                        <p>{{ $tema['langkah3'] }}</p>
                    </li>
                </ol>
            </section>

            <section aria-labelledby="judul-todo">
                <h2 class="sec-title" id="judul-todo">Yang dapat kamu lakukan</h2>
                <ul class="todo">
                    <li>
                        <span class="t-ico"><span class="material-symbols-outlined">forum</span></span>
                        <div><b>Datang ke ruang BK</b><span class="s">Terbuka untuk semua siswa kapan saja. Kamu boleh datang sekadar untuk berbincang.</span></div>
                    </li>
                    <li>
                        <span class="t-ico"><span class="material-symbols-outlined">diversity_3</span></span>
                        <div><b>Bercerita kepada orang terdekat</b><span class="s">Misalnya keluarga atau wali kelas yang kamu percayai.</span></div>
                    </li>
                    <li>
                        <span class="t-ico"><span class="material-symbols-outlined">spa</span></span>
                        <div><b>Sayangi dirimu</b><span class="s">Beristirahatlah cukup dan lakukan hal-hal kecil yang kamu sukai.</span></div>
                    </li>
                </ul>
            </section>
        </div>

        {{-- ===== Pesan penyemangat ===== --}}
        <section class="pesan rise" style="--d:.18s">
            <span class="p-ico"><span class="material-symbols-outlined fill">wb_sunny</span></span>
            <div>
                <p class="lbl">Semangat untukmu hari ini</p>
                <p>{{ $pesanHariIni }}</p>
            </div>
        </section>

        {{-- ===== Dukungan ===== --}}
        <section class="support rise" style="--d:.22s">
            <span class="material-symbols-outlined fill">support_agent</span>
            <p><b>Membutuhkan teman bicara sekarang?</b> Jika kamu merasa sangat tertekan atau membutuhkan bantuan segera, temuilah Guru BK, wali kelas, atau orang dewasa yang kamu percayai. Kamu boleh meminta ditemani kapan saja.</p>
        </section>

        {{-- ===== Tombol ===== --}}
        <div class="actions rise" style="--d:.26s">
            <a href="/dashboard-siswa" class="btn btn-primary">
                Lihat hasil lengkapku
                <span class="material-symbols-outlined">arrow_forward</span>
            </a>
        </div>

        <p class="note">Skrining ini bukan tes dan bukan diagnosis. Hasilnya hanya dapat dilihat olehmu dan Guru BK.</p>

        <footer>
            <span>© 2026 SMPN 216 Jakarta — Portal Skrining Kesehatan Mental Siswa</span>
            <span>Hasil skrining bersifat rahasia</span>
        </footer>

    </main>

</body>
</html>