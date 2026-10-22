@php
    $logoUrl    = \App\Models\Pengaturan::url('logo', 'logo-smpn216.png');
    $heroSlides = \App\Models\Pengaturan::heroSlides();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindCheck | SMPN 216 Jakarta</title>
    <meta name="description" content="Portal skrining kesehatan mental siswa SMPN 216 Jakarta menggunakan instrumen SDQ. Hasil bersifat rahasia dan hanya dapat diakses Guru BK.">
    <link rel="icon" type="image/png" href="{{ $logoUrl }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,500;8..60,600;8..60,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root{--navy:#16324B;--navy-deep:#0E2338;--blue:#4E8FC4;--blue-soft:#DCEBF6;--bg:#F5F9FC;--white:#fff;--leaf:#4C7A52;--leaf-soft:#E5EFE6;--ink:#16324B;--ink-soft:#52687D;--line:#D8E6F0;--max:1120px;--r-btn:11px;--r-field:10px;--r-sm:9px}
        *{box-sizing:border-box}
        html{scroll-behavior:smooth;scroll-padding-top:24px}
        html,body{margin:0;padding:0;background:var(--bg);color:var(--ink);overflow-x:hidden}
        body{font-family:'Inter',system-ui,sans-serif;-webkit-font-smoothing:antialiased}
        h1,h2,h3,h4{font-family:'Source Serif 4',Georgia,serif}
        a{color:inherit;text-decoration:none}
        :focus-visible{outline:3px solid var(--blue);outline-offset:2px;border-radius:3px}
        .page-wrap{min-height:100vh;display:flex;flex-direction:column;background:linear-gradient(180deg,var(--blue-soft) 0%,var(--bg) 260px)}
        .container{max-width:var(--max);margin:0 auto;padding:0 24px;width:100%;position:relative;z-index:1}

        /* Masthead & top bar */
        .masthead-bar{background:var(--navy);color:#EAF2F8;font-size:12px;letter-spacing:.3px;padding:7px 0}
        .masthead-bar .container{display:flex;align-items:center;justify-content:space-between}
        .masthead-bar .tag{opacity:.88}
        .topbar-wrap{z-index:30}
        .topbar{position:relative;display:flex;align-items:center;justify-content:space-between;gap:20px;padding:18px 0;border-bottom:1px solid var(--line)}
        .brand{display:flex;align-items:center;gap:14px}
        .brand-mark{width:52px;height:52px;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;background:transparent;border:none}
        .brand-mark img{width:100%;height:100%;object-fit:contain;border-radius:50%;background:transparent}
        .brand-text{line-height:1.25}
        .school-name{font-family:'Source Serif 4',Georgia,serif;font-size:18px;font-weight:600;color:var(--navy)}
        .school-sub{font-size:12px;font-weight:500;color:var(--ink-soft)}
        .main-nav{display:flex;align-items:center;gap:26px}
        .main-nav a.link{font-size:13.5px;font-weight:500;color:var(--ink-soft);padding:6px 0;border-bottom:2px solid transparent;transition:color .15s ease,border-color .15s ease}
        .main-nav a.link:hover{color:var(--navy);border-color:var(--blue)}
        .nav-actions{display:flex;gap:10px;margin-left:6px}
        .nav-toggle{display:none;width:44px;height:44px;padding:0;border:none;border-radius:var(--r-sm);background:transparent;cursor:pointer;flex-shrink:0;align-items:center;justify-content:center;flex-direction:column;gap:5px;-webkit-tap-highlight-color:transparent}
        .nav-toggle:hover .bar{background:var(--blue)}
        .nav-toggle .bar{display:block;width:20px;height:2px;background:var(--navy);border-radius:2px;transition:transform .25s ease,opacity .2s ease}
        .nav-toggle[aria-expanded="true"] .bar:nth-child(1){transform:translateY(7px) rotate(45deg)}
        .nav-toggle[aria-expanded="true"] .bar:nth-child(2){opacity:0}
        .nav-toggle[aria-expanded="true"] .bar:nth-child(3){transform:translateY(-7px) rotate(-45deg)}

        .btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:11px 26px;border-radius:var(--r-btn);font-size:13.5px;font-weight:600;border:1.5px solid var(--navy);cursor:pointer;transition:transform .12s ease,background .15s ease,color .15s ease;white-space:nowrap}
        .btn:active{transform:scale(.98)}
        .btn-solid{background:var(--navy);color:#fff}
        .btn-solid:hover{background:var(--navy-deep)}
        .btn-light{background:#fff;color:var(--navy);border-color:#fff}
        .btn-light:hover{background:var(--blue-soft);border-color:var(--blue-soft)}
        .btn-ghost-light{background:transparent;color:#fff;border-color:rgba(255,255,255,.55)}
        .btn-ghost-light:hover{background:rgba(255,255,255,.12)}

        /* Banner */
        .banner{position:relative;width:100%;min-height:500px;display:flex;align-items:center;background:var(--navy);overflow:hidden}
        .banner::before{content:"";position:absolute;inset:0;z-index:1;background:linear-gradient(180deg,rgba(22,50,75,.35) 0%,rgba(22,50,75,.72) 55%,rgba(22,50,75,.93) 100%)}
        .banner::after{content:"";position:absolute;left:0;right:0;bottom:0;height:6px;z-index:1;background:linear-gradient(90deg,var(--navy) 0%,var(--blue) 50%,var(--leaf) 100%)}
        .banner-slides{position:absolute;inset:0;z-index:0}
        .banner-slide{position:absolute;inset:0;background-size:cover;background-position:center;opacity:0;transition:opacity 1.8s ease-in-out}
        .banner-slide.is-active{opacity:1}
        .banner-content{position:relative;z-index:2;width:100%;padding:72px 0 120px;color:#fff}
        .hero{max-width:640px}
        .hero-tag{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.35);border-radius:3px;padding:7px 14px;font-size:12.5px;font-weight:500;color:#EAF2F8;margin-bottom:22px}
        .hero-tag .dot{width:7px;height:7px;border-radius:50%;background:#8FD19E}
        .hero h1{font-size:46px;line-height:1.2;margin:0 0 20px;font-weight:600;letter-spacing:-.3px;color:#fff;text-shadow:0 2px 10px rgba(0,0,0,.45)}
        .hero p.lead{font-size:16px;color:#EAF2F8;max-width:540px;margin:0 0 30px;line-height:1.8;text-shadow:0 1px 6px rgba(0,0,0,.35)}
        .hero p.lead:last-child{margin-bottom:0}
        .hero-actions{display:flex;gap:14px;flex-wrap:wrap;margin-bottom:26px}

        /* Pintu masuk (kartu diam, tanpa gerak saat hover) */
        .doors{margin-top:-50px;position:relative;z-index:3;padding-bottom:56px}
        .doors-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}
        .door{display:flex;gap:18px;align-items:flex-start;background:var(--white);border:1px solid var(--line);border-radius:18px;padding:28px;box-shadow:0 20px 44px -22px rgba(22,50,75,.35)}
        .door-icon{width:48px;height:48px;border-radius:14px;background:var(--blue-soft);display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .door.staff .door-icon{background:var(--navy)}
        .door h3{margin:0 0 6px;font-size:21px;font-weight:600;color:var(--navy)}
        .door p{margin:0 0 12px;font-size:13.5px;line-height:1.7;color:var(--ink-soft)}
        .door .go{font-size:13.5px;font-weight:600;color:var(--blue);border-bottom:1.5px solid currentColor;padding-bottom:1px}
        .door.staff .go{color:var(--leaf)}

        /* Sections */
        .section{padding:72px 0}
        .section-white{background:var(--white);border-top:1px solid var(--line);border-bottom:1px solid var(--line)}
        .section-head{max-width:640px;margin-bottom:40px}
        .section-head h2{font-size:32px;line-height:1.25;font-weight:600;margin:0 0 12px;color:var(--navy)}
        .section-head p{margin:0;font-size:15px;line-height:1.75;color:var(--ink-soft)}
        .info-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:32px}
        .info-card{display:flex;gap:14px;align-items:flex-start}
        .info-icon{width:42px;height:42px;border-radius:50%;background:var(--blue-soft);display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .info-card h3{margin:0 0 6px;font-size:17px;font-weight:600;color:var(--navy)}
        .info-card p{margin:0;font-size:13.5px;line-height:1.7;color:var(--ink-soft)}
        .about-grid{display:grid;grid-template-columns:5fr 7fr;gap:56px;align-items:start}
        .about-grid .section-head{margin-bottom:0}
        .about-facts{margin-top:26px;padding:18px 20px;background:var(--leaf-soft);border-left:3px solid var(--leaf);border-radius:3px;font-size:13.5px;line-height:1.7;color:#2F4F34}
        .domain-list{list-style:none;margin:0;padding:0;border-top:1px solid var(--line)}
        .domain-list li{display:grid;grid-template-columns:210px 1fr;gap:20px;padding:18px 0;border-bottom:1px solid var(--line)}
        .domain-list .name{font-family:'Source Serif 4',Georgia,serif;font-size:17px;font-weight:600;color:var(--navy)}
        .domain-list .desc{font-size:13.5px;line-height:1.7;color:var(--ink-soft)}
        .steps{display:grid;grid-template-columns:repeat(4,1fr);gap:0;counter-reset:step;list-style:none;margin:0;padding:0}
        .steps li{position:relative;padding:26px 24px 0 0;border-top:3px solid var(--line);counter-increment:step}
        .steps li::before{content:counter(step);position:absolute;top:-17px;left:0;width:31px;height:31px;border-radius:50%;background:var(--navy);color:#fff;font-size:13px;font-weight:600;display:flex;align-items:center;justify-content:center;box-shadow:0 0 0 5px var(--bg)}
        .steps li:last-child{border-top-color:var(--leaf)}
        .steps h3{margin:6px 0 8px;font-size:17px;font-weight:600;color:var(--navy)}
        .steps p{margin:0;font-size:13.5px;line-height:1.7;color:var(--ink-soft)}
        .faq{max-width:780px;border-top:1px solid var(--line)}
        .faq details{border-bottom:1px solid var(--line)}
        .faq summary{list-style:none;cursor:pointer;display:flex;justify-content:space-between;align-items:center;gap:20px;padding:20px 0;font-size:15.5px;font-weight:600;color:var(--navy)}
        .faq summary::-webkit-details-marker{display:none}
        .faq summary::after{content:"";flex-shrink:0;width:28px;height:28px;border-radius:50%;border:1.5px solid var(--line);background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%234E8FC4' stroke-width='2.4' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") center/14px 14px no-repeat;transition:transform .2s ease,background-color .2s ease,border-color .2s ease}
        .faq summary:hover::after{border-color:var(--blue)}
        .faq details[open] summary::after{transform:rotate(180deg);background-color:var(--blue-soft);border-color:var(--blue)}
        .faq .answer{padding:0 46px 22px 0;font-size:14px;line-height:1.8;color:var(--ink-soft)}
        .cta-band{padding:0 0 72px}
        .cta-inner{background:linear-gradient(120deg,var(--navy) 0%,#1F4A73 100%);color:#fff;border-radius:24px;padding:56px;display:flex;align-items:center;justify-content:space-between;gap:36px;position:relative;overflow:hidden}
        .cta-inner::after{content:"";position:absolute;right:-90px;top:-120px;width:340px;height:340px;border-radius:50%;border:1px solid rgba(255,255,255,.14);pointer-events:none}
        .cta-text,.cta-actions{position:relative;z-index:1}
        .cta-inner h2{margin:0 0 10px;font-size:32px;font-weight:600;line-height:1.2}
        .cta-inner p{margin:0;font-size:15px;line-height:1.75;color:#C5D5E3;max-width:540px}
        .cta-actions{display:flex;gap:12px;flex-shrink:0}

        /* Footer */
        footer{background:var(--navy-deep);color:#B9CADA}
        .footer-main{display:grid;grid-template-columns:1.6fr 1fr 1.2fr;gap:48px;padding:52px 0 40px}
        .footer-brand{display:flex;gap:14px;align-items:flex-start}
        .footer-brand .brand-mark{width:48px;height:48px}
        .footer-brand .fname{font-family:'Source Serif 4',Georgia,serif;font-size:18px;font-weight:600;color:#fff;margin-bottom:8px}
        .footer-brand p{margin:0;font-size:13px;line-height:1.75;max-width:360px}
        footer h4{margin:0 0 16px;font-size:14px;font-weight:600;color:#fff}
        footer ul{list-style:none;margin:0;padding:0}
        footer li{margin-bottom:10px;font-size:13px;line-height:1.6}
        footer a:hover{color:#fff;text-decoration:underline;text-underline-offset:3px}
        .footer-notice{border-top:1px solid rgba(255,255,255,.12);padding:20px 0;font-size:12px;line-height:1.7;color:#9FB3C6;text-align:center}
        .footer-bottom{border-top:1px solid rgba(255,255,255,.12);padding:18px 0;font-size:12px;color:#9FB3C6}
        .footer-bottom .container{display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap}

        @media(max-width:1000px){
            .about-grid{grid-template-columns:1fr;gap:36px}
            .steps{grid-template-columns:repeat(2,1fr);row-gap:44px}
            .footer-main{grid-template-columns:1fr 1fr}
            .footer-brand-col{grid-column:1/-1}
            .cta-inner{flex-direction:column;align-items:flex-start;padding:44px 36px}
            .nav-toggle{display:flex}
            .main-nav{display:none;position:absolute;top:100%;left:0;right:0;flex-direction:column;align-items:stretch;gap:0;padding:8px 20px 20px;background:var(--white);border:1px solid var(--line);border-top:none;border-radius:0 0 var(--r-sm) var(--r-sm);box-shadow:0 16px 32px rgba(22,50,75,.16);z-index:40}
            .main-nav.is-open{display:flex}
            .main-nav a.link{display:block;padding:14px 0;font-size:14.5px;border-bottom:1px solid var(--line)}
            .main-nav a.link:hover{border-bottom-color:var(--line);color:var(--blue)}
            .main-nav .nav-actions{margin:16px 0 0;width:100%}
            .main-nav .nav-actions .btn{width:100%;padding:12px 18px;font-size:14px}
        }
        @media(max-width:900px){
            .container{padding:0 20px}
            .masthead-bar{padding:6px 0}
            .masthead-bar .container{flex-direction:column;gap:1px;text-align:center}
            .masthead-bar .tag:last-child{display:none}
            .topbar{padding:14px 0}
            .brand-mark{width:42px;height:42px}
            .brand{gap:10px}
            .school-name{font-size:16px}
            .school-sub{font-size:11px}
            .nav-actions{gap:8px;margin-left:0}
            .nav-actions .btn{padding:9px 16px;font-size:12.5px}
            .banner{min-height:0}
            .banner-content{padding:48px 0 90px}
            .doors{margin-top:-38px;padding-bottom:36px}
            .doors-grid{grid-template-columns:1fr;gap:14px}
            .door{padding:20px}
            .hero{max-width:100%;text-align:center}
            .hero-tag{margin:0 auto 18px}
            .hero h1{font-size:30px;margin:0 0 16px}
            .hero p.lead{font-size:14.5px;line-height:1.7;margin:0 auto 26px}
            .hero-actions{justify-content:center;margin-bottom:22px}
            .section{padding:52px 0}
            .section-head h2{font-size:26px}
            .info-grid{grid-template-columns:1fr;gap:0}
            .info-card{padding:20px 0;border-bottom:1px solid var(--line)}
            .info-card:first-child{padding-top:0}
            .info-card:last-child{border-bottom:none;padding-bottom:0}
            .domain-list li{grid-template-columns:1fr;gap:4px}
            .cta-inner h2{font-size:26px}
            .cta-band{padding-bottom:52px}
        }
        @media(max-width:600px){
            .steps{grid-template-columns:1fr;row-gap:40px}
            .steps li{padding-right:0}
            .footer-main{grid-template-columns:1fr;gap:32px;padding:40px 0 28px}
            .cta-actions{flex-direction:column;width:100%}
            .cta-actions .btn{width:100%}
            .faq .answer{padding-right:0}
        }
        @media(max-width:480px){
            .masthead-bar .tag{font-size:10.5px}
            .school-sub{display:none}
            .banner-content{padding:40px 0 80px}
            .hero h1{font-size:25px;line-height:1.28}
            .hero p.lead{font-size:13.5px}
            .btn{padding:11px 18px;font-size:13px}
            .hero-actions{flex-direction:column;width:100%;gap:10px}
            .hero-actions .btn{width:100%}
            .nav-actions .btn{padding:8px 13px;font-size:12px}
            .cta-inner{padding:36px 24px}
            .footer-bottom .container{flex-direction:column;text-align:center}
        }
        @media(prefers-reduced-motion:reduce){html{scroll-behavior:auto}*{transition:none!important}}
    </style>

    {{-- Tema bersama (font, ukuran font, sudut tombol) — dimuat terakhir, sama seperti di dashboard --}}
    <link rel="stylesheet" href="{{ asset('css/tema.css') }}">
</head>
<body>

    @php
        $isStaff = auth()->check() && in_array(auth()->user()->role, ['admin', 'super_admin']);
        $namaDepan = auth()->check() ? \Illuminate\Support\Str::title(\Illuminate\Support\Str::words(auth()->user()->name, 2, '')) : '';
        $loggedIn = auth()->check();
        $dashboardUrl = $loggedIn && auth()->user()->role === 'super_admin' ? '/super-admin/dashboard' : '/dashboard';
        $doorSiswa = $loggedIn ? ($isStaff ? ['#alur', 'Lihat alur skrining'] : ['/sdq', 'Mulai skrining']) : ['/login', 'Masuk sebagai siswa'];
        $doorStaff = $loggedIn ? ($isStaff ? [$dashboardUrl, 'Buka dashboard'] : ['#faq', 'Lihat pertanyaan umum']) : [route('login.guru'), 'Masuk sebagai Guru BK'];
    @endphp

    <div class="page-wrap">

        {{-- Masthead --}}
        <div class="masthead-bar">
            <div class="container">
                <span class="tag">Dinas Pendidikan Provinsi DKI Jakarta</span>
                <span class="tag">Layanan Bimbingan &amp; Konseling</span>
            </div>
        </div>

        <div class="container topbar-wrap">
            <div class="topbar">
                <a href="/" class="brand" aria-label="Beranda MindCheck">
                    <div class="brand-mark">
                        <img src="{{ $logoUrl }}" alt="Logo SMPN 216 Jakarta">
                    </div>
                    <div class="brand-text">
                        <div class="school-name">SMPN 216 Jakarta</div>
                        <div class="school-sub">Portal Skrining Kesehatan Mental</div>
                    </div>
                </a>

                <button type="button" class="nav-toggle" id="navToggle" aria-label="Buka menu" aria-expanded="false" aria-controls="mainNav">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </button>

                <nav class="main-nav" id="mainNav" aria-label="Navigasi utama">
                    <a href="#tentang" class="link">Tentang SDQ</a>
                    <a href="#alur" class="link">Alur Skrining</a>
                    <a href="#faq" class="link">Pertanyaan Umum</a>
                    <div class="nav-actions">
                        @auth
                            @if($isStaff)
                                <a href="{{ $dashboardUrl }}" class="btn btn-solid">Dashboard</a>
                            @else
                                <a href="/dashboard-siswa" class="btn btn-solid">Dashboard Saya</a>
                            @endif
                        @else
                            <a href="/register" class="btn btn-solid">Daftar Sekarang</a>
                        @endauth
                    </div>
                </nav>
            </div>
        </div>

        {{-- Banner --}}
        <section class="banner">

            {{-- Slide gambar (diatur superadmin lewat Pengaturan Tampilan) --}}
            <div class="banner-slides" data-count="{{ count($heroSlides) }}" aria-hidden="true">
                @foreach($heroSlides as $i => $src)
                    <div class="banner-slide {{ $i === 0 ? 'is-active' : '' }}" style="background-image:url('{{ $src }}')"></div>
                @endforeach
            </div>

            <div class="banner-content">
                <div class="container">
                    <div class="hero">
                        <span class="hero-tag"><span class="dot"></span>
                            {{ $loggedIn ? 'Selamat datang, '.$namaDepan : 'Instrumen Skrining SDQ' }}
                        </span>
                        <h1>Skrining Kesehatan Mental Siswa SMPN 216 Jakarta</h1>
                        <p class="lead">
                            Layanan skrining resmi bagi seluruh siswa SMPN 216 Jakarta menggunakan
                            Strengths and Difficulties Questionnaire (SDQ). Pengisian berlangsung
                            singkat dan hasilnya bersifat rahasia.
                        </p>
                        @auth
                            <div class="hero-actions">
                                @if($isStaff)
                                    <a href="{{ $dashboardUrl }}" class="btn btn-light">Buka Dashboard</a>
                                @else
                                    <a href="/sdq" class="btn btn-light">Mulai Skrining</a>
                                    <a href="/dashboard-siswa" class="btn btn-ghost-light">Dashboard Saya</a>
                                @endif
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        {{-- Pintu masuk: siswa & Guru BK (kartu diam, tidak bergerak saat hover) --}}
        <section class="doors" aria-label="Pilih peran">
            <div class="container">
                <div class="doors-grid">
                    <a class="door" href="{{ $doorSiswa[0] }}">
                        <div class="door-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M4 6.5L12 3l8 3.5-8 3.5-8-3.5z" stroke="#16324B" stroke-width="1.6" stroke-linejoin="round"/>
                                <path d="M7 10v4.5c0 1.2 2.2 2.5 5 2.5s5-1.3 5-2.5V10" stroke="#16324B" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div>
                            <h3>Untuk siswa</h3>
                            <p>Isi kuesioner SDQ dengan jujur. Tidak ada jawaban benar atau salah, dan tidak memengaruhi nilai.</p>
                            <span class="go">{{ $doorSiswa[1] }}</span>
                        </div>
                    </a>
                    <a class="door staff" href="{{ $doorStaff[0] }}">
                        <div class="door-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <rect x="4" y="4" width="16" height="16" rx="2" stroke="#fff" stroke-width="1.6"/>
                                <path d="M8 15v-3M12 15V9M16 15v-5" stroke="#fff" stroke-width="1.6" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div>
                            <h3>Untuk Guru BK &amp; sekolah</h3>
                            <p>Tinjau hasil skrining siswa melalui dashboard dan tentukan tindak lanjut pendampingan.</p>
                            <span class="go">{{ $doorStaff[1] }}</span>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        {{-- Keunggulan --}}
        <section class="section section-white" aria-labelledby="judul-keunggulan">
            <div class="container">
                <div class="section-head">
                    <h2 id="judul-keunggulan">Skrining yang mudah dan aman</h2>
                    <p>Dirancang agar setiap siswa nyaman mengisi, dan agar Guru BK memperoleh gambaran yang jelas untuk memberi pendampingan.</p>
                </div>
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M9 12l2 2 4-4" stroke="#16324B" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="12" cy="12" r="9" stroke="#16324B" stroke-width="1.6"/>
                            </svg>
                        </div>
                        <div>
                            <h3>Instrumen tervalidasi</h3>
                            <p>Menggunakan Strengths and Difficulties Questionnaire (SDQ) yang telah teruji secara akademis dan dipakai luas di sekolah.</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <circle cx="12" cy="12" r="9" stroke="#16324B" stroke-width="1.6"/>
                                <path d="M12 7v5l3 2" stroke="#16324B" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div>
                            <h3>Proses singkat</h3>
                            <p>Skrining dapat diselesaikan dalam waktu kurang lebih 10–15 menit melalui perangkat sekolah maupun pribadi.</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M12 2L3 6v6c0 5 3.8 8.7 9 10 5.2-1.3 9-5 9-10V6l-9-4z" stroke="#16324B" stroke-width="1.6" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div>
                            <h3>Data terlindungi</h3>
                            <p>Seluruh hasil bersifat rahasia dan hanya dapat ditinjau oleh Guru Bimbingan &amp; Konseling (BK).</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Tentang SDQ --}}
        <section class="section" id="tentang" aria-labelledby="judul-tentang">
            <div class="container">
                <div class="about-grid">
                    <div>
                        <div class="section-head">
                            <h2 id="judul-tentang">Apa itu SDQ?</h2>
                            <p>
                                SDQ adalah kuesioner singkat berisi 25 pernyataan untuk melihat kekuatan dan
                                kesulitan emosi serta perilaku remaja. Hasilnya membantu Guru BK mengenali siswa
                                yang mungkin membutuhkan perhatian lebih awal.
                            </p>
                        </div>
                        <div class="about-facts">
                            SDQ adalah alat skrining, bukan alat diagnosis dan bukan penilaian akademik.
                            Tidak ada jawaban benar atau salah, jadi isilah sesuai kondisi yang sebenarnya.
                        </div>
                    </div>
                    <ul class="domain-list">
                        <li><span class="name">Gejala emosional</span><span class="desc">Perasaan cemas, sedih, atau mudah takut yang dialami dalam keseharian.</span></li>
                        <li><span class="name">Masalah perilaku</span><span class="desc">Kecenderungan marah, berbohong, atau melanggar aturan di rumah maupun sekolah.</span></li>
                        <li><span class="name">Hiperaktivitas</span><span class="desc">Kesulitan untuk tenang, fokus, dan menyelesaikan tugas hingga selesai.</span></li>
                        <li><span class="name">Masalah teman sebaya</span><span class="desc">Kesulitan berteman, merasa sendiri, atau kurang diterima di lingkungan pertemanan.</span></li>
                        <li><span class="name">Perilaku prososial</span><span class="desc">Kekuatan siswa dalam peduli, berbagi, dan membantu orang lain.</span></li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- Alur --}}
        <section class="section section-white" id="alur" aria-labelledby="judul-alur">
            <div class="container">
                <div class="section-head">
                    <h2 id="judul-alur">Alur skrining</h2>
                    <p>Empat langkah dari pendaftaran hingga tindak lanjut oleh Guru BK.</p>
                </div>
                <ol class="steps">
                    <li><h3>Daftar atau masuk</h3><p>Buat akun siswa menggunakan data yang benar, atau masuk jika sudah memiliki akun.</p></li>
                    <li><h3>Isi kuesioner SDQ</h3><p>Jawab 25 pernyataan sesuai keadaanmu selama enam bulan terakhir.</p></li>
                    <li><h3>Kirim jawaban</h3><p>Periksa kembali jawabanmu, lalu kirim. Hasil tersimpan dengan aman di sistem.</p></li>
                    <li><h3>Ditinjau Guru BK</h3><p>Guru BK meninjau hasil dan menghubungi siswa bila diperlukan pendampingan.</p></li>
                </ol>
            </div>
        </section>

        {{-- FAQ --}}
        <section class="section" id="faq" aria-labelledby="judul-faq">
            <div class="container">
                <div class="section-head">
                    <h2 id="judul-faq">Pertanyaan umum</h2>
                    <p>Jawaban singkat untuk hal yang paling sering ditanyakan siswa dan orang tua.</p>
                </div>
                <div class="faq">
                    <details>
                        <summary>Apakah skrining ini memengaruhi nilai rapor?</summary>
                        <div class="answer">Tidak. Skrining ini tidak berkaitan dengan nilai akademik maupun peringkat kelas.</div>
                    </details>
                    <details>
                        <summary>Siapa saja yang dapat melihat hasilnya?</summary>
                        <div class="answer">Hanya Guru Bimbingan &amp; Konseling (BK). Hasil tidak dibagikan kepada teman maupun guru mata pelajaran.</div>
                    </details>
                    <details>
                        <summary>Berapa lama waktu pengisian?</summary>
                        <div class="answer">Kurang lebih 10–15 menit. Siapkan waktu yang tenang agar dapat menjawab dengan jujur.</div>
                    </details>
                    <details>
                        <summary>Apakah hasil skrining berarti saya mengalami gangguan?</summary>
                        <div class="answer">Tidak otomatis. Skrining hanya memberi gambaran awal. Kesimpulan lebih lanjut dilakukan Guru BK melalui percakapan langsung, dan bila perlu bersama tenaga profesional.</div>
                    </details>
                    <details>
                        <summary>Apa yang terjadi jika hasil saya menunjukkan perlu pendampingan?</summary>
                        <div class="answer">Guru BK akan mengajak siswa berbincang secara pribadi untuk memahami kebutuhannya dan menentukan dukungan yang sesuai.</div>
                    </details>
                </div>
            </div>
        </section>

        {{-- CTA --}}
        <section class="cta-band" aria-labelledby="judul-cta">
            <div class="container">
                <div class="cta-inner">
                    <div class="cta-text">
                        <h2 id="judul-cta">Siap mengisi skrining?</h2>
                        <p>Luangkan 10–15 menit untuk menjawab dengan jujur. Jawabanmu membantu sekolah mendampingimu dengan lebih baik.</p>
                    </div>
                    <div class="cta-actions">
                        @auth
                            @if($isStaff)
                                <a href="{{ $dashboardUrl }}" class="btn btn-light">Buka Dashboard</a>
                            @else
                                <a href="/sdq" class="btn btn-light">Mulai Skrining</a>
                            @endif
                        @else
                            <a href="/register" class="btn btn-light">Daftar Sekarang</a>
                            <a href="{{ route('login') }}" class="btn btn-ghost-light">Masuk</a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer>
            <div class="container">
                <div class="footer-main">
                    <div class="footer-brand-col">
                        <div class="footer-brand">
                            <a href="/" class="brand-mark" aria-label="Kembali ke halaman utama">
                                <img src="{{ $logoUrl }}" alt="Logo SMPN 216 Jakarta">
                            </a>
                            <div>
                                <div class="fname">SMPN 216 Jakarta</div>
                                <p>Portal skrining kesehatan mental siswa yang dikelola oleh Layanan Bimbingan &amp; Konseling untuk mendukung kesejahteraan seluruh peserta didik.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4>Tautan</h4>
                        <ul>
                            <li><a href="#tentang">Tentang SDQ</a></li>
                            <li><a href="#alur">Alur skrining</a></li>
                            <li><a href="#faq">Pertanyaan umum</a></li>
                            @guest
                                <li><a href="{{ route('login') }}">Masuk</a></li>
                                <li><a href="/register">Daftar</a></li>
                            @endguest
                        </ul>
                    </div>

                    <div>
                        <h4>Layanan BK</h4>
                        <ul>
                            {{-- Ubah teks di bawah sesuai alamat/kontak resmi sekolah --}}
                            <li>Ruang Bimbingan &amp; Konseling, SMPN 216 Jakarta</li>
                            <li>Senin – Jumat, pada jam sekolah</li>
                            <li>Siswa dapat menemui Guru BK secara langsung kapan saja.</li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="footer-notice">
                <div class="container">
                    Hasil skrining SDQ bukan diagnosis. Jika kamu merasa sangat tertekan atau membutuhkan bantuan segera,
                    temui Guru BK, wali kelas, atau orang dewasa yang kamu percaya.
                </div>
            </div>

            <div class="footer-bottom">
                <div class="container">
                    <span>© {{ date('Y') }} SMPN 216 Jakarta — Portal Skrining Kesehatan Mental Siswa</span>
                    <span>Dinas Pendidikan Provinsi DKI Jakarta</span>
                </div>
            </div>
        </footer>

    </div>

    <script>
        // Menu hamburger
        (function () {
            var toggle = document.getElementById('navToggle');
            var nav = document.getElementById('mainNav');
            if (!toggle || !nav) return;

            function setOpen(open) {
                nav.classList.toggle('is-open', open);
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                toggle.setAttribute('aria-label', open ? 'Tutup menu' : 'Buka menu');
            }

            toggle.addEventListener('click', function () { setOpen(!nav.classList.contains('is-open')); });
            nav.querySelectorAll('a').forEach(function (a) { a.addEventListener('click', function () { setOpen(false); }); });
            document.addEventListener('keydown', function (e) { if (e.key === 'Escape') setOpen(false); });
            document.addEventListener('click', function (e) { if (!nav.contains(e.target) && !toggle.contains(e.target)) setOpen(false); });
            window.addEventListener('resize', function () { if (window.innerWidth > 1000) setOpen(false); });
        })();

        // Slider gambar banner (otomatis, tanpa titik navigasi)
        (function () {
            var wrap = document.querySelector('.banner-slides');
            if (!wrap || +wrap.dataset.count < 2) return;   // 1 gambar = tanpa animasi

            var slides = wrap.querySelectorAll('.banner-slide');
            var banner = document.querySelector('.banner');
            var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            var cur = 0, timer = null, DELAY = 6000;

            function show(n) {
                slides[cur].classList.remove('is-active');
                cur = (n + slides.length) % slides.length;
                slides[cur].classList.add('is-active');
            }
            function stop()  { clearInterval(timer); }
            function start() { stop(); if (!reduce) timer = setInterval(function () { show(cur + 1); }, DELAY); }

            banner.addEventListener('mouseenter', stop);
            banner.addEventListener('mouseleave', start);
            document.addEventListener('visibilitychange', function () { document.hidden ? stop() : start(); });

            start();
        })();
    </script>

</body>
</html>