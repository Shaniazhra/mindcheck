<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | MindCheck SMPN 216 Jakarta</title>
    <link rel="icon" type="image/png" href="{{ \App\Models\Pengaturan::url('logo', 'logo-smpn216.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,500;8..60,600;8..60,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/tema.css')

    <style>
        :root {
            --navy: #16324B;
            --navy-deep: #0E2338;
            --blue: #4E8FC4;
            --blue-soft: #DCEBF6;
            --bg: #F5F9FC;
            --white: #FFFFFF;
            --leaf: #4C7A52;
            --leaf-soft: #E5EFE6;
            --ink: #16324B;
            --ink-soft: #52687D;
            --line: #D8E6F0;
            --error-bg: #FBEAEA;
            --error-ink: #B4453F;
            --ok-bg: #E7F5EC;
            --ok-ink: #2F6B45;
        }

        * { box-sizing: border-box; }

        html, body {
            margin: 0;
            padding: 0;
            min-height: 100%;
            background: var(--bg);
            color: var(--ink);
            font-family: 'Inter', system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        a { color: inherit; text-decoration: none; }
        h1, h2, h3, .serif { font-family: 'Source Serif 4', Georgia, serif; }

        :focus-visible {
            outline: 3px solid var(--blue);
            outline-offset: 2px;
            border-radius: 4px;
        }

        .page { min-height: 100vh; background: #fff; }

        .card {
            position: relative;
            width: 100%;
            min-height: 100vh;
            background: #fff;
            display: flex;
        }

        .card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            z-index: 5;
            background: linear-gradient(90deg, var(--navy) 0%, var(--blue) 50%, var(--leaf) 100%);
        }

        /* ===== Brand (dipakai di panel & mobile) ===== */
        .brand { display: flex; align-items: center; gap: 12px; }

        .brand-mark {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .brand-mark img { width: 100%; height: 100%; object-fit: contain; }
        .brand-text { line-height: 1.25; }

        .school-name {
            font-family: 'Source Serif 4', Georgia, serif;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
        }

        .school-sub {
            font-size: 12px;
            font-weight: 500;
            color: #C5D5E3;
        }

        /* ===== Panel kiri ===== */
        .panel {
            width: 42%;
            min-width: 360px;
            max-width: 600px;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            align-self: flex-start;
            height: 100vh;
            overflow-y: auto;
            color: #EAF2F8;
            padding: 56px 56px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: url('{{ asset("gedung_216.jpeg") }}') center/cover no-repeat;
        }

        .panel::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(22,50,75,.88) 0%, rgba(22,50,75,.82) 45%, rgba(14,35,56,.96) 100%);
        }

        .panel > * { position: relative; z-index: 1; }

        .panel h2 {
            font-size: 30px;
            line-height: 1.3;
            font-weight: 600;
            margin: 44px 0 14px;
            color: #fff;
        }

        .panel .lead {
            margin: 0;
            font-size: 13.5px;
            line-height: 1.75;
            color: #D2E0EC;
        }

        .prep {
            margin-top: 28px;
            padding-top: 22px;
            border-top: 1px solid rgba(255,255,255,.2);
        }

        .prep h3 {
            margin: 0 0 14px;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
        }

        .prep ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: 12px;
        }

        .prep li {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            font-size: 13px;
            line-height: 1.55;
            color: #D2E0EC;
        }

        .prep li svg { flex-shrink: 0; margin-top: 2px; }

        .panel-foot {
            margin-top: 28px;
            font-size: 12px;
            line-height: 1.6;
            color: #A9BDCF;
        }

        .panel-foot strong {
            display: block;
            color: #fff;
            font-weight: 600;
            margin-bottom: 2px;
        }

        /* ===== Sisi form ===== */
        .form-side {
            flex: 1;
            min-width: 0;
            padding: 64px 56px 48px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, var(--blue-soft) 0%, #fff 260px);
        }

        .form-side > * {
            width: 100%;
            max-width: 480px;
            text-align: left;
        }

        .mobile-brand {
            display: none;
            position: relative;
            align-items: center;
            gap: 14px;
            padding: 34px 20px 30px;
            background: url('{{ asset("gedung_216.jpeg") }}') center/cover no-repeat;
            overflow: hidden;
        }

        .mobile-brand::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(22,50,75,.72) 0%, rgba(22,50,75,.9) 100%);
        }

        .mobile-brand::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--navy) 0%, var(--blue) 50%, var(--leaf) 100%);
        }

        .mobile-brand > * { position: relative; z-index: 1; }
        .mobile-brand .brand-mark { width: 52px; height: 52px; }
        .mobile-brand .brand-text { display: flex; flex-direction: column; gap: 3px; }

        .mobile-brand .school-name {
            font-size: 17px;
            text-shadow: 0 1px 6px rgba(0,0,0,.35);
        }

        .mobile-brand .school-sub { font-size: 12px; }

        .back-home {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 500;
            color: var(--ink-soft);
            margin-bottom: 22px;
            transition: color .15s ease;
        }

        .back-home:hover { color: var(--navy); }

        .form-side h1 {
            font-size: 28px;
            line-height: 1.25;
            font-weight: 600;
            margin: 0 0 8px;
            letter-spacing: -.2px;
            color: var(--navy);
        }

        .form-side .sub {
            font-size: 14px;
            color: var(--ink-soft);
            margin: 0 0 26px;
            line-height: 1.65;
        }

        .error-box, .success-box {
            font-size: 13px;
            border-radius: 8px;
            padding: 13px 16px;
            margin-bottom: 22px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-weight: 500;
        }

        .error-box {
            background: var(--error-bg);
            color: var(--error-ink);
            border: 1px solid rgba(180,69,63,.25);
            border-left: 4px solid var(--error-ink);
        }

        .success-box {
            background: var(--ok-bg);
            color: var(--ok-ink);
            border: 1px solid rgba(47,107,69,.25);
            border-left: 4px solid var(--ok-ink);
        }

        .error-box svg, .success-box svg { flex-shrink: 0; margin-top: 2px; }

        .field { margin-bottom: 18px; }

        .field > label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 7px;
        }

        .field input {
            width: 100%;
            border: 1.5px solid var(--line);
            background: var(--bg);
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14.5px;
            font-family: inherit;
            color: var(--ink);
            transition: border-color .15s ease, background .15s ease, box-shadow .15s ease;
            appearance: none;
        }

        .field input::placeholder { color: #8FA4B6; }
        .field input:hover { border-color: #B9D0E2; }

        .field input:focus {
            outline: none;
            border-color: var(--blue);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(78,143,196,.15);
        }

        .pw-wrap { position: relative; }
        .pw-wrap input { padding-right: 46px; }

        .pw-toggle {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            background: none;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            color: var(--ink-soft);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pw-toggle:hover { color: var(--navy); background: var(--blue-soft); }

        .field-meta {
            display: flex;
            justify-content: flex-end;
            margin: -6px 0 20px;
        }

        .field-meta a {
            font-size: 13px;
            font-weight: 600;
            color: var(--blue);
        }

        .field-meta a:hover { text-decoration: underline; text-underline-offset: 3px; }

        .btn-submit {
            width: 100%;
            background: var(--navy);
            color: #fff;
            border: 1.5px solid var(--navy);
            font-family: inherit;
            font-weight: 600;
            font-size: 15px;
            padding: 14px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 2px;
            transition: background .15s ease, transform .12s ease;
        }

        .btn-submit:hover { background: var(--navy-deep); }
        .btn-submit:active { transform: scale(.99); }
        .btn-submit:disabled { opacity: .7; cursor: wait; }

        .privacy-note {
            display: flex;
            gap: 9px;
            align-items: flex-start;
            margin-top: 16px;
            font-size: 12px;
            line-height: 1.6;
            color: var(--ink-soft);
        }

        .privacy-note svg { flex-shrink: 0; margin-top: 2px; }

        .footer-link {
            text-align: center;
            font-size: 14px;
            color: var(--ink-soft);
            margin: 26px 0 0;
            padding-top: 22px;
            border-top: 1px solid var(--line);
        }

        .footer-link a {
            color: var(--navy);
            font-weight: 700;
            border-bottom: 1.5px solid var(--blue);
            padding-bottom: 1px;
        }

        .footer-link a:hover { color: var(--blue); }

        /* ===== Responsif ===== */
        @media (max-width: 1100px) {
            .panel { width: 38%; min-width: 320px; padding: 48px 36px 32px; }
            .form-side { padding: 56px 40px 44px; }
        }

        @media (max-width: 760px) {
            .card { flex-direction: column; }
            .card::before { display: none; }
            .panel { display: none; }
            .mobile-brand { display: flex; }
            .form-side {
                padding: 26px 22px 40px;
                background: #fff;
                justify-content: flex-start;
            }
            .back-home { margin-bottom: 18px; }
            .form-side h1 { font-size: 23px; }
        }

        @media (max-width: 480px) {
            .form-side { padding: 22px 16px 34px; }
            .form-side h1 { font-size: 21px; }
            .form-side .sub { font-size: 13px; margin-bottom: 22px; }
            .field input { padding: 11px 13px; font-size: 14px; }
            .btn-submit { padding: 13px; font-size: 14px; }
        }

        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; }
        }
    </style>
</head>
<body>

<div class="page">
    <div class="card">

        @include('partials.panel_login_siswa')

        {{-- Form --}}
        <main class="form-side">

            <a href="/" class="back-home">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 6l-6 6 6 6"/></svg>
                Kembali ke beranda
            </a>

            <h1>Selamat datang</h1>
            <p class="sub">Masuk dengan akun kamu untuk melanjutkan skrining kesehatan mental.</p>

            @if(session('success'))
                <div class="success-box" role="status">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 12l2 2 4-4" stroke="#2F6B45" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="9" stroke="#2F6B45" stroke-width="1.6"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="error-box" role="alert">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" stroke="#B4453F" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="/login" id="loginForm">
                @csrf

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           autocomplete="email" placeholder="username@gmail.com">
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="pw-wrap">
                        <input type="password" id="password" name="password" required
                               autocomplete="current-password" placeholder="Masukkan password">
                        <button type="button" class="pw-toggle" onclick="togglePw('password', this)" aria-label="Tampilkan atau sembunyikan password">
                            <svg class="eye-off" width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M1 1l22 22" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                            <svg class="eye-on" width="18" height="18" viewBox="0 0 24 24" fill="none" style="display:none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/></svg>
                        </button>
                    </div>
                </div>

                <div class="field-meta">
                    <a href="/forgot-password">Lupa password?</a>
                </div>

                <button type="submit" class="btn-submit" id="btnSubmit">Masuk</button>

                <p class="privacy-note">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 2L3 6v6c0 5 3.8 8.7 9 10 5.2-1.3 9-5 9-10V6l-9-4z" stroke="#4E8FC4" stroke-width="1.7" stroke-linejoin="round"/></svg>
                    <span>Data yang kamu isi bersifat rahasia dan hanya digunakan untuk keperluan layanan Bimbingan &amp; Konseling.</span>
                </p>
            </form>

            <p class="footer-link">
                Belum punya akun? <a href="/register">Daftar di sini</a>
            </p>

        </main>
    </div>
</div>

<script>
    function togglePw(id, btn) {
        const input = document.getElementById(id);
        const off = btn.querySelector('.eye-off');
        const on  = btn.querySelector('.eye-on');

        if (input.type === 'password') {
            input.type = 'text';
            off.style.display = 'none';
            on.style.display  = 'block';
        } else {
            input.type = 'password';
            off.style.display = 'block';
            on.style.display  = 'none';
        }
    }

    // Cegah klik ganda saat form dikirim
    document.getElementById('loginForm').addEventListener('submit', function () {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.textContent = 'Memproses...';
    });
</script>

</body>
</html>