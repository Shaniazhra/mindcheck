<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Guru BK — MindCheck SMPN 216 Jakarta</title>
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
            --leaf: #4C7A52;
            --leaf-dark: #3C6342;
            --leaf-soft: #E5EFE6;
            --bg: #F4F8F4;
            --ink: #16324B;
            --ink-soft: #52687D;
            --line: #D5E3D7;
            --error-bg: #FBEAEA;
            --error-ink: #B4453F;
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
        h1, h2, h3 { font-family: 'Source Serif 4', Georgia, serif; }

        :focus-visible { outline: 3px solid var(--leaf); outline-offset: 2px; border-radius: 4px; }

        /* ===== Halaman (layar penuh, seperti login siswa) ===== */
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
            position: absolute; top: 0; left: 0; right: 0;
            height: 5px;
            z-index: 5;
            background: linear-gradient(90deg, var(--leaf) 0%, var(--blue) 50%, var(--navy) 100%);
        }

        /* ===== Brand ===== */
        .brand { display: flex; align-items: center; gap: 14px; }
        .brand-mark {
            width: 52px; height: 52px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }
        .brand-mark img { width: 100%; height: 100%; object-fit: contain; }
        .brand-text { display: flex; flex-direction: column; gap: 3px; line-height: 1.25; }
        .school-name { font-family: 'Source Serif 4', Georgia, serif; font-size: 17px; font-weight: 600; color: #fff; }
        .school-sub { font-size: 12px; font-weight: 500; color: #C9DACD; }

        /* ===== Panel kiri (gambar) ===== */
        .panel {
            position: sticky;
            top: 0;
            align-self: flex-start;
            height: 100vh;
            overflow-y: auto;
            width: 42%;
            min-width: 360px;
            max-width: 600px;
            flex-shrink: 0;
            color: #EAF2EC;
            padding: 56px 56px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: url('{{ asset("gedung_216.jpeg") }}') center/cover no-repeat;
            isolation: isolate;
        }
        .panel::before {
            content: "";
            position: absolute; inset: 0;
            z-index: -1;
            background:
                radial-gradient(300px 220px at 100% 0%, rgba(78,143,196,.3), transparent 65%),
                radial-gradient(280px 220px at 0% 100%, rgba(76,122,82,.35), transparent 65%),
                linear-gradient(180deg, rgba(18,52,44,.9) 0%, rgba(16,46,50,.86) 45%, rgba(10,30,38,.97) 100%);
        }
        .panel-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 40px;
            padding: 7px 14px;
            border-radius: 4px;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.28);
            font-size: 12.5px;
            font-weight: 600;
            color: #fff;
        }
        .panel h2 { font-size: 30px; line-height: 1.25; font-weight: 600; margin: 18px 0 12px; color: #fff; }
        .panel .lead { margin: 0; font-size: 13.5px; line-height: 1.8; color: #D3E3D8; }

        .tools { list-style: none; margin: 28px 0 0; padding: 24px 0 0; border-top: 1px solid rgba(255,255,255,.2); display: grid; gap: 16px; }
        .tools li { display: flex; gap: 12px; align-items: flex-start; font-size: 13px; line-height: 1.6; color: #D3E3D8; }
        .tools li strong { display: block; color: #fff; font-weight: 600; margin-bottom: 1px; }
        .tools .ico {
            width: 34px; height: 34px;
            border-radius: 8px;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.2);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .panel-foot { margin-top: 28px; font-size: 12px; line-height: 1.6; color: #A9C0B0; }

        /* ===== Header mobile (foto, seperti login siswa) ===== */
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
            position: absolute; inset: 0;
            background: linear-gradient(180deg, rgba(18,52,44,.78) 0%, rgba(10,30,38,.93) 100%);
        }
        .mobile-brand::after {
            content: "";
            position: absolute; left: 0; right: 0; bottom: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--leaf) 0%, var(--blue) 50%, var(--navy) 100%);
        }
        .mobile-brand > * { position: relative; z-index: 1; }
        .mobile-brand .brand-mark { width: 52px; height: 52px; }
        .mobile-brand .school-name { font-size: 17px; text-shadow: 0 1px 6px rgba(0,0,0,.35); }
        .mobile-brand .school-sub { font-size: 12px; }

        /* ===== Sisi form (kanan) ===== */
        .form-side {
            flex: 1;
            min-width: 0;
            padding: 64px 56px 48px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, var(--leaf-soft) 0%, #fff 260px);
        }
        .form-inner { width: 100%; max-width: 480px; text-align: left; }

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

        .role-badge {
            display: flex;
            width: fit-content;
            align-items: center;
            gap: 8px;
            padding: 7px 14px 7px 10px;
            margin-bottom: 18px;
            border-radius: 999px;
            background: var(--leaf-soft);
            border: 1px solid #BFD5C3;
            color: #2F4F34;
            font-size: 13px;
            font-weight: 600;
        }

        .form-side h1 {
            font-size: 31px;
            line-height: 1.25;
            font-weight: 600;
            margin: 0 0 8px;
            letter-spacing: -.2px;
            color: var(--navy);
        }
        .form-side .sub { margin: 0 0 26px; font-size: 14px; line-height: 1.65; color: var(--ink-soft); }

        .error-box {
            background: var(--error-bg);
            color: var(--error-ink);
            font-size: 13px;
            font-weight: 500;
            border-radius: 8px;
            padding: 13px 16px;
            margin-bottom: 22px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            border: 1px solid rgba(180,69,63,.25);
            border-left: 4px solid var(--error-ink);
        }
        .error-box svg { flex-shrink: 0; margin-top: 2px; }

        .success-box {
            background: var(--leaf-soft);
            color: #2F4F34;
            font-size: 13px;
            font-weight: 500;
            border-radius: 8px;
            padding: 13px 16px;
            margin-bottom: 22px;
            border: 1px solid #BFD5C3;
            border-left: 4px solid var(--leaf);
        }

        .field { margin-bottom: 18px; }
        .field label { display: block; font-size: 13px; font-weight: 600; color: var(--navy); margin-bottom: 7px; }

        .input-wrap { position: relative; }
        .input-ico {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: #7F9A87;
            display: flex;
            pointer-events: none;
            transition: color .15s ease;
        }
        .input-wrap:focus-within .input-ico { color: var(--leaf); }

        .field input {
            width: 100%;
            border: 1.5px solid var(--line);
            background: #FAFCFA;
            border-radius: 8px;
            padding: 13px 15px 13px 43px;
            font-size: 14.5px;
            font-family: inherit;
            color: var(--ink);
            transition: border-color .15s ease, background .15s ease, box-shadow .15s ease;
        }
        .field input::placeholder { color: #8FA39A; }
        .field input:hover { border-color: #B5CDB9; }
        .field input:focus {
            outline: none;
            border-color: var(--leaf);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(76,122,82,.16);
        }

        .pw-wrap { position: relative; }
        .pw-wrap input { padding-right: 48px; }
        .pw-toggle {
            position: absolute;
            right: 8px; top: 50%;
            transform: translateY(-50%);
            width: 34px; height: 34px;
            background: none; border: none; border-radius: 6px;
            cursor: pointer;
            color: var(--ink-soft);
            display: flex; align-items: center; justify-content: center;
        }
        .pw-toggle:hover { color: var(--navy); background: var(--leaf-soft); }

        .btn-submit {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--leaf);
            color: #fff;
            border: 1.5px solid var(--leaf);
            font-family: inherit;
            font-weight: 600;
            font-size: 15px;
            padding: 14px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 8px;
            box-shadow: 0 8px 18px -10px rgba(60,99,66,.8);
            transition: background .15s ease, transform .12s ease, box-shadow .15s ease;
        }
        .btn-submit svg { transition: transform .15s ease; }
        .btn-submit:hover { background: var(--leaf-dark); border-color: var(--leaf-dark); }
        .btn-submit:hover svg { transform: translateX(3px); }
        .btn-submit:active { transform: scale(.99); }
        .btn-submit:disabled { opacity: .7; cursor: wait; box-shadow: none; }

        .help-note {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-top: 20px;
            padding: 12px 14px;
            background: #F6F9F6;
            border: 1px solid var(--line);
            border-radius: 8px;
            font-size: 12.5px;
            line-height: 1.6;
            color: var(--ink-soft);
        }
        .help-note svg { flex-shrink: 0; margin-top: 2px; }

        .switch-role {
            margin-top: 26px;
            padding-top: 22px;
            border-top: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            font-size: 13.5px;
            color: var(--ink-soft);
        }
        .switch-role a {
            color: var(--navy);
            font-weight: 700;
            border-bottom: 1.5px solid var(--blue);
            padding-bottom: 1px;
            white-space: nowrap;
        }
        .switch-role a:hover { color: var(--blue); }

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
            .form-side { padding: 26px 22px 40px; background: #fff; justify-content: flex-start; }
            .form-inner { max-width: 100%; }
            .form-side h1 { font-size: 24px; }
            .back-home { margin-bottom: 18px; }
        }

        @media (max-width: 480px) {
            .form-side { padding: 22px 16px 34px; }
            .form-side h1 { font-size: 22px; }
            .form-side .sub { font-size: 13px; margin-bottom: 22px; }
            .field input { padding: 12px 13px 12px 41px; font-size: 14px; }
            .pw-wrap input { padding-right: 46px; }
            .btn-submit { padding: 13px; font-size: 14px; }
            .switch-role { flex-direction: column; align-items: flex-start; gap: 8px; }
        }

        @media (prefers-reduced-motion: reduce) { * { transition: none !important; } }
    </style>
</head>
<body>

<div class="page">
    <div class="card">

    @include('partials.panel_login_guru')

        {{-- Form (kanan) --}}
        <main class="form-side">
            <div class="form-inner">

                <a href="/" class="back-home">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 6l-6 6 6 6"/></svg>
                    Kembali ke beranda
                </a>

                <span class="role-badge">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 2L3 6v6c0 5 3.8 8.7 9 10 5.2-1.3 9-5 9-10V6l-9-4z" stroke="#4C7A52" stroke-width="1.8" stroke-linejoin="round"/><path d="M8.5 12l2.5 2.5 4.5-5" stroke="#4C7A52" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Akses Guru BK
                </span>

                <h1>Masuk sebagai Guru BK</h1>
                <p class="sub">Gunakan akun yang diberikan sekolah untuk membuka dashboard hasil skrining siswa.</p>

                @if(session('success'))
                    <div class="success-box" role="status">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="error-box" role="alert">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" stroke="#B4453F" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="/login-guru" id="loginForm">
                    @csrf

                    <div class="field">
                        <label for="email">Email Guru BK</label>
                        <div class="input-wrap">
                            <span class="input-ico" aria-hidden="true">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M3.5 7l8.5 6 8.5-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                   autocomplete="username" placeholder="nama@sekolah.sch.id">
                        </div>
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <div class="input-wrap pw-wrap">
                            <span class="input-ico" aria-hidden="true">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="5" y="11" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M8 11V7a4 4 0 0 1 8 0v4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                            </span>
                            <input type="password" id="password" name="password" required
                                   autocomplete="current-password" placeholder="Masukkan password">
                            <button type="button" class="pw-toggle" onclick="togglePw(this)" aria-label="Tampilkan atau sembunyikan password">
                                <svg class="eye-off" width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M1 1l22 22" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                <svg class="eye-on" width="18" height="18" viewBox="0 0 24 24" fill="none" style="display:none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/></svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit" id="btnSubmit">
                        <span id="btnLabel">Masuk ke dashboard</span>
                    </button>
                </form>

                <div class="help-note">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke="#4C7A52" stroke-width="1.7"/><path d="M12 11v5M12 8h.01" stroke="#4C7A52" stroke-width="1.8" stroke-linecap="round"/></svg>
                    <span>Akun Guru BK diberikan oleh pihak sekolah. Jika belum memiliki akun, hubungi admin sekolah.</span>
                </div>

                <div class="switch-role">
                    <span>Kamu siswa?</span>
                    <a href="/login">Masuk sebagai siswa</a>
                </div>

            </div>
        </main>

    </div>
</div>

<script>
    function togglePw(btn) {
        const input = document.getElementById('password');
        const off = btn.querySelector('.eye-off');
        const on  = btn.querySelector('.eye-on');
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        off.style.display = show ? 'none' : 'block';
        on.style.display  = show ? 'block' : 'none';
    }

    document.getElementById('loginForm').addEventListener('submit', function () {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        document.getElementById('btnLabel').textContent = 'Memproses...';
    });
</script>

</body>
</html>