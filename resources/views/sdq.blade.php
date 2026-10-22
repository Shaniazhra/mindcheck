@php
    $logoUrl = \App\Models\Pengaturan::url('logo', 'logo-smpn216.png');

    $soal = [
        1  => "Saya berusaha bersikap baik kepada orang lain. Saya peduli dengan perasaan mereka",
        2  => "Saya gelisah, saya tidak dapat diam untuk waktu lama",
        3  => "Saya sering sakit kepala, sakit perut atau macam-macam sakit lainnya",
        4  => "Kalau saya memiliki mainan, CD, atau makanan, saya biasanya berbagi dengan orang lain",
        5  => "Saya menjadi sangat marah dan sering tidak dapat mengendalikan kemarahan saya",
        6  => "Saya lebih suka sendirian daripada bersama dengan orang-orang yang seumur saya",
        7  => "Saya biasanya melakukan apa yang diperintahkan oleh orang lain",
        8  => "Saya banyak merasa cemas atau khawatir terhadap apa pun",
        9  => "Saya selalu siap menolong jika ada orang yang terluka, kecewa, atau merasa sakit",
        10 => "Bila sedang gelisah atau cemas, badan saya sering bergerak-gerak tanpa saya sadari",
        11 => "Saya mempunyai satu orang teman baik atau lebih",
        12 => "Saya sering bertengkar dengan orang lain. Saya dapat memaksa orang lain melakukan apa yang saya inginkan",
        13 => "Saya sering merasa tidak bahagia, sedih atau menangis",
        14 => "Orang lain seumur saya pada umumnya menyukai saya",
        15 => "Perhatian saya mudah teralihkan, saya sulit memusatkan perhatian pada apa pun",
        16 => "Saya merasa gugup dalam situasi baru, saya mudah kehilangan rasa percaya diri",
        17 => "Saya bersikap baik terhadap anak-anak yang lebih muda dari saya",
        18 => "Saya sering dituduh berbohong atau berbuat curang",
        19 => "Saya sering diganggu atau dipermainkan oleh anak-anak atau remaja lainnya",
        20 => "Saya sering menawarkan diri untuk membantu orang lain (orang tua, guru, anak-anak)",
        21 => "Sebelum melakukan sesuatu saya berpikir dahulu tentang akibatnya",
        22 => "Saya mengambil barang yang bukan milik saya dari rumah, sekolah atau dari mana saja",
        23 => "Saya lebih mudah berteman dengan orang dewasa daripada dengan orang-orang yang seumur saya",
        24 => "Banyak yang saya takuti, saya mudah menjadi takut",
        25 => "Saya menyelesaikan pekerjaan yang sedang saya lakukan. Saya mempunyai perhatian yang baik terhadap apa pun",
    ];

    $pilihan  = [0 => 'Tidak Benar', 1 => 'Agak Benar', 2 => 'Benar'];
    $sekarang = now('Asia/Jakarta')->locale('id');

    // Kalimat penyemangat singkat sesuai posisi pertanyaan
    $semangat = fn ($n) => $n <= 6 ? 'Tidak ada jawaban yang salah'
        : ($n <= 12 ? 'Bagus, teruslah melanjutkan'
        : ($n <= 18 ? 'Sudah melewati setengah perjalanan'
        : ($n <= 24 ? 'Sedikit lagi selesai' : 'Pertanyaan terakhir')));
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuesioner SDQ | SMPN 216 Jakarta</title>
    <link rel="icon" type="image/png" href="{{ $logoUrl }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Source+Serif+4:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    @vite('resources/css/tema.css')
   
   <style>
        /* ============ Warna (sama dengan halaman Guru BK: navy dan biru) ============ */
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
            --warn: #D97706;
            --warn-ink: #B45309;
            --warn-bg: #FEF3C7;
            --warn-line: #FDE68A;
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
        button { font-family: inherit; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; font-size: 20px; line-height: 1; }
        :focus-visible { outline: 2px solid var(--brand-mid); outline-offset: 2px; border-radius: 8px; }

        /* ============ Header ============ */
        .topbar {
            position: sticky; top: 0; z-index: 30;
            height: 64px; padding: 0 16px;
            display: flex; align-items: center; justify-content: space-between; gap: 12px;
            background: rgba(255,255,255,.92);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--line);
        }
        .topbar-left { display: flex; align-items: center; gap: 12px; min-width: 0; }
        .back-btn {
            width: 38px; height: 38px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            border-radius: 10px; border: 1px solid var(--line); background: #fff;
            color: var(--ink-2); transition: background .15s, color .15s;
        }
        .back-btn:hover { background: var(--brand-soft); color: var(--brand); }
        .head-title { font-size: 1rem; font-weight: 700; line-height: 1.2; }
        .head-sub { font-size: .75rem; color: var(--ink-3); margin-top: 2px; }
        .date-pill {
            display: none; align-items: center; gap: 8px;
            padding: 8px 12px; border-radius: 8px;
            background: var(--bg); border: 1px solid var(--line);
            font-size: .75rem; font-weight: 500; color: var(--ink-2); white-space: nowrap;
        }
        .date-pill .material-symbols-outlined { font-size: 16px; }
        @media (min-width: 640px) { .date-pill { display: flex; } }
        @media (min-width: 768px) { .topbar { padding: 0 32px; } }

        /* ============ Progres ============ */
        .progress-wrap { height: 5px; background: var(--line); }
        .progress-fill {
            height: 100%; width: 0%;
            background: linear-gradient(90deg, var(--navy-mid), var(--brand-mid));
            border-radius: 0 99px 99px 0;
            transition: width .35s cubic-bezier(.4,0,.2,1);
        }

        /* ============ Halaman ============ */
        .wrap { max-width: 1120px; margin: 0 auto; padding: 28px 16px 40px; }
        @media (min-width: 768px) { .wrap { padding: 44px 40px 48px; } }

        .step { animation: fade .25s ease both; }
        .step.fwd  { animation: inR .28s cubic-bezier(.2,.7,.2,1) both; }
        .step.back { animation: inL .28s cubic-bezier(.2,.7,.2,1) both; }
        .step[hidden] { display: none !important; }
        @keyframes fade { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: none; } }
        @keyframes inR  { from { opacity: 0; transform: translateX(22px); } to { opacity: 1; transform: none; } }
        @keyframes inL  { from { opacity: 0; transform: translateX(-22px); } to { opacity: 1; transform: none; } }

        /* ============ Kartu (pertanyaan dan layar selesai): tetap ramping agar nyaman dibaca ============ */
        .card {
            position: relative; overflow: hidden;
            max-width: 720px; margin-left: auto; margin-right: auto;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 26px 24px;
            box-shadow: 0 1px 2px rgba(15,39,71,.05), 0 14px 32px -20px rgba(15,39,71,.25);
        }
        .card::before {
            content: ''; position: absolute; left: 0; right: 0; top: 0; height: 4px;
            background: linear-gradient(90deg, var(--navy-mid), var(--brand-mid));
        }

        /* ============ Panduan awal: selebar halaman, tanpa kartu ============ */
        .intro {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 36px;
            align-items: center;
            padding: 4px 0;
        }
        @media (min-width: 900px) {
            .intro { grid-template-columns: minmax(0, 5fr) minmax(0, 6fr); gap: 0; min-height: 440px; }
            .intro-main { padding-right: 56px; }
            .intro-side { padding-left: 56px; border-left: 1px solid var(--line); }
        }

        .eyebrow { display: flex; align-items: center; gap: 12px; }
        .eyebrow-logo {
            width: 46px; height: 46px; flex-shrink: 0;
            background: transparent; border: none; box-shadow: none;
            padding: 0; display: flex; align-items: center; justify-content: center;
        }
        .eyebrow-logo img { width: 100%; height: 100%; object-fit: contain; }
        .eyebrow-text { font-size: .72rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: var(--brand); line-height: 1.4; }
        .eyebrow-text small { display: block; font-size: .72rem; font-weight: 600; letter-spacing: .02em; text-transform: none; color: var(--ink-3); }

        .intro h1 {
            margin-top: 26px;
            font-size: clamp(1.5rem, 2.6vw, 2rem);
            font-weight: 800; line-height: 1.12; letter-spacing: -.02em;
            color: var(--navy);
            outline: none;
        }
        .intro h1 .hl {
            background: linear-gradient(90deg, var(--navy-mid), var(--brand-mid));
            -webkit-background-clip: text; background-clip: text;
            -webkit-text-fill-color: transparent; color: transparent;
        }
        .intro .lead { margin-top: 18px; max-width: 460px; font-size: .95rem; line-height: 1.8; color: var(--ink-2); }

        .intro-cta { margin-top: 30px; display: flex; flex-direction: column; align-items: flex-start; gap: 14px; }
        .btn-lg { padding: 14px 30px; min-height: 52px; font-size: .95rem; border-radius: 999px; }
        .tip { font-size: .78rem; color: var(--ink-3); display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
        kbd.key {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 24px; height: 24px; padding: 0 6px;
            border-radius: 7px;
            background: #fff; border: 1px solid var(--line); border-bottom-width: 2px;
            font-family: inherit; font-size: .72rem; font-weight: 700; color: var(--ink-2);
        }

        /* Ringkasan 4 fakta: garis pemisah, tanpa kotak */
        .facts {
            list-style: none;
            display: grid; grid-template-columns: repeat(2, 1fr);
            border-top: 1px solid var(--line); border-bottom: 1px solid var(--line);
        }
        .facts li { display: flex; flex-direction: column; gap: 10px; padding: 18px 16px 18px 0; }
        .facts li:nth-child(even) { padding-left: 20px; padding-right: 0; border-left: 1px solid var(--line); }
        .facts li:nth-child(n+3) { border-top: 1px solid var(--line); }
        .f-ico {
            width: 38px; height: 38px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            background: var(--brand-soft); color: var(--brand);
        }
        .f-ico .material-symbols-outlined { font-size: 21px; font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .facts b { display: block; font-size: .88rem; font-weight: 700; line-height: 1.3; }
        .facts span.s { display: block; margin-top: 2px; font-size: .75rem; color: var(--ink-3); line-height: 1.5; }

        /* Panduan 3 langkah: garis waktu */
        .guide-title {
            display: flex; align-items: center; gap: 12px;
            margin-top: 30px;
            font-size: .72rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; color: var(--ink-3);
        }
        .guide-title::after { content: ''; flex: 1; height: 1px; background: var(--line); }

        .timeline { list-style: none; margin-top: 18px; }
        .timeline li { position: relative; padding: 0 0 22px 52px; min-height: 34px; }
        .timeline li:last-child { padding-bottom: 0; }
        .timeline li:not(:last-child)::before {
            content: ''; position: absolute; left: 15px; top: 36px; bottom: 4px; width: 2px;
            background: linear-gradient(var(--brand-mid), #BCD0F0);
            border-radius: 2px;
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
        .timeline p { margin-top: 3px; font-size: .85rem; color: var(--ink-2); line-height: 1.7; max-width: 520px; }

        /* ============ Pertanyaan ============ */
        .q-head { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
        .q-count {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 5px 12px; border-radius: 999px;
            background: var(--brand-soft); color: var(--brand);
            font-size: .74rem; font-weight: 700;
        }
        .q-left { font-size: .75rem; color: var(--ink-3); font-weight: 500; text-align: right; }
        .q-text {
            font-size: 1.2rem; font-weight: 700; line-height: 1.55; letter-spacing: -.005em;
            margin: 18px 0 24px; outline: none;
        }

        .options { display: grid; gap: 10px; }
        .opt {
            position: relative;
            display: flex; align-items: center; gap: 14px;
            padding: 15px 16px;
            border: 1.5px solid var(--line); border-radius: 14px; background: #fff;
            font-size: .95rem; font-weight: 600; color: var(--ink);
            cursor: pointer; user-select: none;
            transition: border-color .15s, background .15s, transform .15s, box-shadow .15s;
        }
        .opt:hover { border-color: #9DBDEB; transform: translateY(-1px); box-shadow: 0 8px 18px -12px rgba(29,95,191,.45); }
        .opt input { position: absolute; opacity: 0; width: 0; height: 0; }
        .opt .k {
            width: 26px; height: 26px; flex-shrink: 0;
            display: grid; place-items: center;
            border-radius: 8px; background: var(--bg); border: 1px solid var(--line);
            font-size: .72rem; font-weight: 700; color: var(--ink-3);
            transition: background .15s, color .15s, border-color .15s;
        }
        .opt .t { flex: 1; }
        .mark {
            width: 22px; height: 22px; border-radius: 50%;
            border: 2px solid #B7C5D8;
            display: grid; place-items: center; flex-shrink: 0;
            transition: border-color .15s, background .15s;
        }
        .mark::after {
            content: ''; width: 5px; height: 10px;
            border: solid #fff; border-width: 0 2px 2px 0;
            transform: rotate(45deg) scale(0); margin-top: -2px;
            transition: transform .15s ease;
        }
        .opt.sel { border-color: var(--brand); background: var(--brand-soft); box-shadow: 0 8px 18px -12px rgba(29,95,191,.55); }
        .opt.sel .k { background: var(--brand); border-color: var(--brand); color: #fff; }
        .opt.sel .mark { border-color: var(--brand); background: var(--brand); }
        .opt.sel .mark::after { transform: rotate(45deg) scale(1); }
        .opt input:focus-visible ~ .mark { outline: 2px solid var(--brand-mid); outline-offset: 3px; }

        .warn {
            display: flex; align-items: center; gap: 6px;
            margin-top: 14px; font-size: .78rem; font-weight: 600; color: var(--warn-ink);
        }
        .warn[hidden] { display: none; }
        .warn .material-symbols-outlined { font-size: 17px; }

        /* ============ Tombol ============ */
        .actions { display: flex; align-items: center; gap: 10px; margin-top: 26px; }
        .actions .spacer { flex: 1; }
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 12px 20px; min-height: 46px; border-radius: 12px;
            font-size: .875rem; font-weight: 700;
            cursor: pointer; border: 1px solid transparent;
            transition: background .15s, transform .12s, border-color .15s, color .15s;
        }
        .btn:active { transform: scale(.98); }
        .btn .material-symbols-outlined { font-size: 18px; }
        .btn[hidden] { display: none; }
        .btn-primary { background: var(--brand); color: #fff; box-shadow: 0 10px 20px -12px var(--brand); }
        .btn-primary:hover { background: var(--brand-deep); }
        .btn-primary:disabled { opacity: .7; cursor: default; }
        .btn-ghost { background: #fff; color: var(--ink-2); border-color: var(--line); }
        .btn-ghost:hover { color: var(--brand); border-color: #B9D0F2; background: var(--brand-soft); }

        /* ============ Layar selesai ============ */
        .ico {
            width: 46px; height: 46px; border-radius: 14px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            background: linear-gradient(135deg, var(--navy-mid), var(--brand-mid));
            box-shadow: 0 8px 16px -6px var(--brand);
        }
        .ico .material-symbols-outlined { font-size: 24px; font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .done-title { font-size: 1.2rem; font-weight: 800; line-height: 1.3; }
        .done-text { font-size: .875rem; color: var(--ink-2); line-height: 1.7; margin-top: 12px; }

        .rv-head { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin: 22px 0 10px; }
        .rv-head b { font-size: .8rem; color: var(--ink); }
        .rv-count { font-size: .75rem; font-weight: 700; color: var(--brand); background: var(--brand-soft); padding: 4px 11px; border-radius: 999px; }
        .review { display: grid; grid-template-columns: repeat(auto-fill, minmax(42px, 1fr)); gap: 8px; }
        .rv {
            height: 42px; border-radius: 11px; cursor: pointer;
            border: 1.5px solid var(--warn-line); background: var(--warn-bg); color: var(--warn-ink);
            font-size: .82rem; font-weight: 700;
            transition: transform .12s, background .15s, border-color .15s;
        }
        .rv:hover { transform: translateY(-1px); }
        .rv.ok { border-color: #CFE0F7; background: var(--brand-soft); color: var(--brand); }
        .rv-note { margin-top: 10px; font-size: .78rem; color: var(--ink-3); line-height: 1.6; }
        .rv-note.bad { color: var(--warn-ink); font-weight: 600; }

        /* ============ Footer ============ */
        .foot {
            margin-top: 34px; padding-top: 14px; border-top: 1px solid var(--line);
            display: flex; justify-content: space-between; flex-wrap: wrap; gap: 6px;
            font-size: .72rem; color: var(--ink-3);
        }

        @media (max-width: 899px) {
            .intro-main { padding-bottom: 4px; }
            .intro-side { padding-top: 8px; }
        }
        @media (max-width: 560px) {
            .intro-cta .btn-lg { width: 100%; }
        }
        @media (max-width: 480px) {
            .card { padding: 22px 18px; }
            .q-text { font-size: 1.08rem; }
            .actions .btn { flex: 1; }
            .actions .spacer { display: none; }
        }
        /* ============ Perapian tampilan mobile ============ */
        @media (max-width: 640px) {
            .topbar { height: 60px; padding: 0 12px; gap: 10px; }
            .back-btn { width: 36px; height: 36px; }
            .head-title { font-size: .95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
            .head-sub { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

            .wrap { padding: 20px 16px calc(28px + env(safe-area-inset-bottom, 0px)); }

            /* Panduan awal */
            .intro { gap: 26px; padding: 0; }
            .intro-side { padding-top: 24px; border-top: 1px solid var(--line); }
            .eyebrow-logo { width: 40px; height: 40px; }
            .intro h1 { margin-top: 20px; }
            .intro .lead { margin-top: 12px; font-size: .9rem; line-height: 1.7; max-width: none; }
            .intro-cta { margin-top: 22px; }
            .facts li { padding: 14px 12px 14px 0; gap: 8px; }
            .facts li:nth-child(even) { padding-left: 14px; }
            .f-ico { width: 34px; height: 34px; border-radius: 10px; }
            .f-ico .material-symbols-outlined { font-size: 19px; }
            .facts b { font-size: .82rem; }
            .facts span.s { font-size: .72rem; }
            .guide-title { margin-top: 24px; }
            .timeline li { padding-left: 46px; padding-bottom: 18px; }
            .timeline p { max-width: none; font-size: .82rem; }

            /* Pertanyaan */
            .card { padding: 20px 16px; border-radius: 16px; }
            .q-head { flex-wrap: wrap; row-gap: 6px; }
            .q-left { font-size: .72rem; }
            .q-text { font-size: 1.05rem; line-height: 1.5; margin: 14px 0 18px; }
            .options { gap: 8px; }
            .opt { padding: 14px; gap: 12px; font-size: .9rem; border-radius: 12px; }
            .actions { margin-top: 20px; }

            /* Layar selesai */
            .ico { width: 40px; height: 40px; border-radius: 12px; }
            .done-title { font-size: 1.05rem; }
            .done-text { font-size: .84rem; }
            .review { grid-template-columns: repeat(auto-fill, minmax(38px, 1fr)); gap: 6px; }
            .rv { height: 38px; border-radius: 10px; }

            /* Footer */
            .foot { flex-direction: column; align-items: center; text-align: center; margin-top: 26px; }
        }
        @media (max-width: 380px) {
            .actions { flex-direction: column-reverse; align-items: stretch; }
            .actions .btn { width: 100%; }
        }

        /* Layar sentuh: petunjuk tombol keyboard tidak diperlukan */
        @media (pointer: coarse) {
            .opt .k, .tip { display: none; }
        }
        @media (prefers-reduced-motion: reduce) {
            .step, .step.fwd, .step.back { animation: none; }
            .progress-fill, .mark::after, .opt, .rv { transition: none; }
            .opt:hover, .rv:hover { transform: none; }
        }
    </style>
    {{-- Tanpa JavaScript: tampilkan semua langkah sekaligus agar form tetap bisa diisi --}}
    <noscript><style>.step[hidden] { display: block !important; } .intro[hidden] { display: grid !important; } .step { margin-bottom: 20px; } .btn-ghost, .review, .rv-head, .rv-note { display: none; }</style></noscript>
    <link rel="stylesheet" href="{{ asset('css/icons.css') }}">
    <script src="{{ asset('js/icons.js') }}" defer></script>
</head>
<body>

    {{-- Header --}}
    <header class="topbar">
        <div class="topbar-left">
            <a href="/dashboard-siswa" class="back-btn" id="leaveLink" aria-label="Kembali ke hasil skrining" title="Kembali">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div style="min-width:0">
                <h2 class="head-title">Kuesioner SDQ</h2>
                <p class="head-sub">Jawablah sesuai yang kamu rasakan, tidak ada jawaban yang salah</p>
            </div>
        </div>
        <span class="date-pill">
            <span class="material-symbols-outlined">calendar_today</span>
            {{ $sekarang->isoFormat('dddd, D MMMM Y') }}
        </span>
    </header>

    <div class="progress-wrap" aria-hidden="true"><div class="progress-fill" id="progressFill"></div></div>

    <div class="wrap">

        <form id="sdqForm" action="/sdq/submit" method="POST" novalidate>
            @csrf

            {{-- ===== Langkah 0: panduan awal (dua kolom, selebar halaman) ===== --}}
            <section class="step intro" data-step="0">

                <div class="intro-main">
                    <div class="eyebrow">
                        <span class="eyebrow-logo"><img src="{{ $logoUrl }}" alt="Logo SMPN 216"></span>
                        <span class="eyebrow-text">Skrining Kesehatan Mental<small>SMPN 216 Jakarta</small></span>
                    </div>

                    <h1 tabindex="-1" data-focus>Siap mengisi <span class="hl">kuesioner</span>?</h1>
                    <p class="lead">Kamu akan menjawab 25 pernyataan singkat, satu per satu. Jawablah sesuai dengan yang benar-benar kamu rasakan. Tidak ada jawaban yang benar atau salah.</p>

                    <div class="intro-cta">
                        <button type="button" class="btn btn-primary btn-lg" data-next>
                            Mulai mengisi
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </button>
                        <p class="tip">Tips: tekan <kbd class="key" aria-hidden="true">1</kbd> <kbd class="key" aria-hidden="true">2</kbd> <kbd class="key" aria-hidden="true">3</kbd> pada keyboard untuk menjawab lebih cepat.</p>
                    </div>
                </div>

                <div class="intro-side">
                    <ul class="facts">
                        <li>
                            <span class="f-ico"><span class="material-symbols-outlined">checklist</span></span>
                            <div><b>25 pernyataan</b><span class="s">dijawab satu per satu</span></div>
                        </li>
                        <li>
                            <span class="f-ico"><span class="material-symbols-outlined">schedule</span></span>
                            <div><b>10 sampai 15 menit</b><span class="s">perkiraan waktu pengisian</span></div>
                        </li>
                        <li>
                            <span class="f-ico"><span class="material-symbols-outlined">history</span></span>
                            <div><b>6 bulan terakhir</b><span class="s">sebagai acuan jawabanmu</span></div>
                        </li>
                        <li>
                            <span class="f-ico"><span class="material-symbols-outlined">lock</span></span>
                            <div><b>Rahasia</b><span class="s">hanya dapat dilihat Guru BK</span></div>
                        </li>
                    </ul>

                    <div class="guide-title">Panduan singkat</div>
                    <ol class="timeline">
                        <li>
                            <span class="tn">1</span>
                            <h3>Baca pernyataan</h3>
                            <p>Bacalah dengan tenang, lalu ingat keadaanmu selama 6 bulan terakhir.</p>
                        </li>
                        <li>
                            <span class="tn">2</span>
                            <h3>Pilih jawaban</h3>
                            <p>Pilih Tidak Benar, Agak Benar, atau Benar. Pernyataan berikutnya akan muncul otomatis.</p>
                        </li>
                        <li>
                            <span class="tn">3</span>
                            <h3>Periksa dan kirim</h3>
                            <p>Setelah selesai, periksa kembali jawabanmu, lalu kirim untuk melihat hasilnya.</p>
                        </li>
                    </ol>
                </div>
            </section>

            {{-- ===== Langkah 1-25: pertanyaan ===== --}}
            @foreach($soal as $n => $pertanyaan)
            <section class="step card" data-step="{{ $n }}" hidden>
                <div class="q-head">
                    <span class="q-count">Pertanyaan {{ $n }} dari 25</span>
                    <span class="q-left">{{ $semangat($n) }}</span>
                </div>
                <h2 class="q-text" tabindex="-1" data-focus id="qt{{ $n }}">{{ $pertanyaan }}</h2>

                <div class="options" role="radiogroup" aria-labelledby="qt{{ $n }}">
                    @foreach($pilihan as $nilai => $teks)
                    <label class="opt">
                        <input type="radio" name="sdq{{ $n }}" value="{{ $nilai }}">
                        <span class="k" aria-hidden="true">{{ $nilai + 1 }}</span>
                        <span class="t">{{ $teks }}</span>
                        <span class="mark"></span>
                    </label>
                    @endforeach
                </div>

                <p class="warn" hidden role="alert">
                    <span class="material-symbols-outlined">info</span>
                    Silakan pilih salah satu jawaban terlebih dahulu.
                </p>

                <div class="actions">
                    <button type="button" class="btn btn-ghost" data-prev>
                        <span class="material-symbols-outlined">arrow_back</span>
                        Sebelumnya
                    </button>
                    <span class="spacer"></span>
                    <button type="button" class="btn btn-primary" data-next hidden>
                        Lanjut
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </div>
            </section>
            @endforeach

            {{-- ===== Langkah 26: selesai + cek jawaban ===== --}}
            <section class="step card" data-step="26" hidden>
                <div style="display:flex;align-items:center;gap:14px">
                    <span class="ico"><span class="material-symbols-outlined">task_alt</span></span>
                    <h2 class="done-title" tabindex="-1" data-focus style="outline:none">Selesai, terima kasih telah menjawab dengan jujur</h2>
                </div>
                <p class="done-text">Jika ingin mengubah sesuatu, ketuk nomor pertanyaannya di bawah. Jika sudah yakin, kirim sekarang dan hasilmu akan langsung tampil.</p>

                <div class="rv-head">
                    <b>Periksa jawabanmu</b>
                    <span class="rv-count" id="rvCount">0 dari 25</span>
                </div>
                <div class="review" id="review">
                    @for($i = 1; $i <= 25; $i++)
                        <button type="button" class="rv" data-goto="{{ $i }}" aria-label="Buka pertanyaan {{ $i }}">{{ $i }}</button>
                    @endfor
                </div>
                <p class="rv-note" id="rvNote"></p>

                <div class="actions">
                    <button type="button" class="btn btn-ghost" data-prev>
                        <span class="material-symbols-outlined">arrow_back</span>
                        Sebelumnya
                    </button>
                    <span class="spacer"></span>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        Lihat hasil skrining
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </div>
            </section>

        </form>

        <div class="foot">
            <span>© 2026 SMPN 216 Jakarta — Portal Skrining Kesehatan Mental Siswa</span>
            <span>SDQ © Robert Goodman</span>
        </div>
    </div>

    <script>
    (function () {
        var TOTAL = 25;
        var form  = document.getElementById('sdqForm');
        var steps = Array.prototype.slice.call(form.querySelectorAll('.step'));
        var fill  = document.getElementById('progressFill');
        var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var cur = 0, timer = null, returnTo = null;

        function checked(n) { return form.querySelector('input[name="sdq' + n + '"]:checked'); }

        function answeredCount() {
            var c = 0;
            for (var i = 1; i <= TOTAL; i++) if (checked(i)) c++;
            return c;
        }

        function updateProgress() {
            fill.style.width = (answeredCount() / TOTAL * 100) + '%';
        }

        function paintSelected(step) {
            step.querySelectorAll('.opt').forEach(function (l) {
                l.classList.toggle('sel', l.querySelector('input').checked);
            });
        }

        // Perbarui kotak nomor di layar akhir
        function refreshReview() {
            var done = answeredCount();
            document.querySelectorAll('.rv').forEach(function (b) {
                b.classList.toggle('ok', !!checked(parseInt(b.dataset.goto, 10)));
            });
            document.getElementById('rvCount').textContent = done + ' dari ' + TOTAL;
            var note = document.getElementById('rvNote');
            if (done === TOTAL) {
                note.textContent = 'Semua pertanyaan sudah terjawab.';
                note.className = 'rv-note';
            } else {
                note.textContent = 'Nomor berwarna kuning belum dijawab. Ketuk nomor tersebut untuk menjawabnya.';
                note.className = 'rv-note bad';
            }
        }

        function show(i) {
            clearTimeout(timer);
            var dir = i >= cur ? 'fwd' : 'back';
            cur = Math.max(0, Math.min(steps.length - 1, i));
            steps.forEach(function (s, k) { s.hidden = (k !== cur); });

            var s = steps[cur];
            s.classList.remove('fwd', 'back');
            if (!reduce) { void s.offsetWidth; s.classList.add(dir); }

            paintSelected(s);
            var next = s.querySelector('[data-next]');
            if (cur >= 1 && cur <= TOTAL && next) next.hidden = !checked(cur);
            if (cur === steps.length - 1) refreshReview();

            var w = s.querySelector('.warn');
            if (w) w.hidden = true;

            var f = s.querySelector('[data-focus]');
            if (f) f.focus({ preventScroll: true });
            window.scrollTo({ top: 0, behavior: reduce ? 'auto' : 'smooth' });
        }

        // Klik tombol Mulai / Lanjut / Sebelumnya / nomor pertanyaan
        form.addEventListener('click', function (e) {
            var g = e.target.closest('[data-goto]');
            if (g) { returnTo = steps.length - 1; show(parseInt(g.dataset.goto, 10)); return; }
            if (e.target.closest('[data-next]')) {
                if (returnTo !== null) { var r = returnTo; returnTo = null; show(r); }
                else show(cur + 1);
            } else if (e.target.closest('[data-prev]')) {
                returnTo = null;
                show(cur - 1);
            }
        });

        // Pilih jawaban: tandai, perbarui progres, lalu lanjut otomatis
        form.addEventListener('change', function (e) {
            if (e.target.type !== 'radio') return;
            var s = steps[cur];
            paintSelected(s);
            updateProgress();
            var next = s.querySelector('[data-next]');
            if (next) next.hidden = false;
            var w = s.querySelector('.warn');
            if (w) w.hidden = true;
            clearTimeout(timer);
            var target = cur + 1;
            if (returnTo !== null) { target = returnTo; returnTo = null; }
            timer = setTimeout(function () { show(target); }, reduce ? 0 : 380);
        });

        // Pintasan keyboard: tekan 1, 2, atau 3 untuk memilih jawaban
        document.addEventListener('keydown', function (e) {
            if (cur < 1 || cur > TOTAL) return;
            if (e.ctrlKey || e.metaKey || e.altKey) return;
            var idx = ['1', '2', '3'].indexOf(e.key);
            if (idx === -1) return;
            var radios = steps[cur].querySelectorAll('input[type=radio]');
            if (radios[idx]) { radios[idx].checked = true; radios[idx].dispatchEvent(new Event('change', { bubbles: true })); }
        });

        // Pastikan semua terjawab sebelum dikirim
        form.addEventListener('submit', function (e) {
            for (var i = 1; i <= TOTAL; i++) {
                if (!checked(i)) {
                    e.preventDefault();
                    returnTo = steps.length - 1;
                    show(i);
                    steps[i].querySelector('.warn').hidden = false;
                    return;
                }
            }
            var b = document.getElementById('submitBtn');
            if (b) { b.disabled = true; b.textContent = 'Menyimpan...'; }
        });

        // Tanya dulu jika keluar saat sudah ada jawaban
        document.getElementById('leaveLink').addEventListener('click', function (e) {
            if (answeredCount() > 0 && !confirm('Jawabanmu belum tersimpan. Apakah kamu yakin ingin keluar?')) e.preventDefault();
        });

        show(0);
        updateProgress();
    })();
    </script>

</body>
</html>