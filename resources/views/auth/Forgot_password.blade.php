<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password | MindCheck SMPN 216 Jakarta</title>
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
            --leaf: #4C7A52;
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
            margin: 0; padding: 0; min-height: 100%;
            background: var(--bg); color: var(--ink);
            font-family: 'Inter', system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        a { color: inherit; text-decoration: none; }
        h1, h2, h3 { font-family: 'Source Serif 4', Georgia, serif; }
        :focus-visible { outline: 3px solid var(--blue); outline-offset: 2px; border-radius: 4px; }

        .page { min-height: 100vh; background: #fff; }
        .card { position: relative; width: 100%; min-height: 100vh; background: #fff; display: flex; }
        .card::before {
            content: ""; position: absolute; top: 0; left: 0; right: 0; height: 5px; z-index: 5;
            background: linear-gradient(90deg, var(--navy) 0%, var(--blue) 50%, var(--leaf) 100%);
        }

        /* ===== Brand ===== */
        .brand { display: flex; align-items: center; gap: 12px; }
        .brand-mark {
            width: 48px; height: 48px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;
        }
        .brand-mark img { width: 100%; height: 100%; object-fit: contain; }
        .brand-text { line-height: 1.25; }
        .school-name { font-family: 'Source Serif 4', Georgia, serif; font-size: 16px; font-weight: 600; color: #fff; }
        .school-sub { font-size: 12px; font-weight: 500; color: #C5D5E3; }

        /* ===== Panel kiri ===== */
        .panel {
            width: 42%; min-width: 360px; max-width: 600px; flex-shrink: 0;
            position: sticky; top: 0; align-self: flex-start; height: 100vh; overflow-y: auto;
            color: #EAF2F8; padding: 56px 56px 40px;
            display: flex; flex-direction: column; justify-content: space-between;
            background: url('{{ asset("gedung_216.jpeg") }}') center/cover no-repeat;
        }
        .panel::before {
            content: ""; position: absolute; inset: 0;
            background: linear-gradient(180deg, rgba(22,50,75,.88) 0%, rgba(22,50,75,.82) 45%, rgba(14,35,56,.96) 100%);
        }
        .panel > * { position: relative; z-index: 1; }
        .panel h2 { font-size: 30px; line-height: 1.3; font-weight: 600; margin: 44px 0 14px; color: #fff; }
        .panel .lead { margin: 0; font-size: 13.5px; line-height: 1.75; color: #D2E0EC; }
        .prep { margin-top: 28px; padding-top: 22px; border-top: 1px solid rgba(255,255,255,.2); }
        .prep h3 { margin: 0 0 14px; font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; color: #fff; }
        .prep ol { list-style: none; counter-reset: s; margin: 0; padding: 0; display: grid; gap: 14px; }
        .prep li { counter-increment: s; display: flex; gap: 12px; align-items: flex-start; font-size: 13px; line-height: 1.55; color: #D2E0EC; }
        .prep li::before {
            content: counter(s); width: 24px; height: 24px; border-radius: 50%; flex-shrink: 0;
            background: rgba(255,255,255,.14); border: 1px solid rgba(255,255,255,.28);
            font-size: 12px; font-weight: 600; color: #fff;
            display: flex; align-items: center; justify-content: center;
        }
        .panel-foot { margin-top: 28px; font-size: 12px; line-height: 1.6; color: #A9BDCF; }
        .panel-foot strong { display: block; color: #fff; font-weight: 600; margin-bottom: 2px; }

        /* ===== Sisi form ===== */
        .form-side {
            flex: 1; min-width: 0; padding: 64px 56px 48px;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            background: linear-gradient(180deg, var(--blue-soft) 0%, #fff 260px);
        }
        .form-side > * { width: 100%; max-width: 480px; text-align: left; }

        .mobile-brand {
            display: none; position: relative; align-items: center; gap: 14px;
            padding: 34px 20px 30px;
            background: url('{{ asset("gedung_216.jpeg") }}') center/cover no-repeat; overflow: hidden;
        }
        .mobile-brand::before {
            content: ""; position: absolute; inset: 0;
            background: linear-gradient(180deg, rgba(22,50,75,.72) 0%, rgba(22,50,75,.9) 100%);
        }
        .mobile-brand::after {
            content: ""; position: absolute; left: 0; right: 0; bottom: 0; height: 5px;
            background: linear-gradient(90deg, var(--navy) 0%, var(--blue) 50%, var(--leaf) 100%);
        }
        .mobile-brand > * { position: relative; z-index: 1; }
        .mobile-brand .brand-mark { width: 52px; height: 52px; }
        .mobile-brand .brand-text { display: flex; flex-direction: column; gap: 3px; }
        .mobile-brand .school-name { font-size: 17px; text-shadow: 0 1px 6px rgba(0,0,0,.35); }
        .mobile-brand .school-sub { font-size: 12px; }

        .back-home {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 13px; font-weight: 500; color: var(--ink-soft); margin-bottom: 22px; transition: color .15s ease;
        }
        .back-home:hover { color: var(--navy); }

        .form-side h1 { font-size: 28px; line-height: 1.25; font-weight: 600; margin: 0 0 8px; letter-spacing: -.2px; color: var(--navy); }
        .form-side .sub { font-size: 14px; color: var(--ink-soft); margin: 0 0 26px; line-height: 1.65; }

        .error-box, .success-box {
            font-size: 13px; border-radius: 8px; padding: 13px 16px; margin-bottom: 22px;
            display: flex; align-items: flex-start; gap: 10px; font-weight: 500; line-height: 1.55;
        }
        .error-box { background: var(--error-bg); color: var(--error-ink); border: 1px solid rgba(180,69,63,.25); border-left: 4px solid var(--error-ink); }
        .success-box { background: var(--ok-bg); color: var(--ok-ink); border: 1px solid rgba(47,107,69,.25); border-left: 4px solid var(--ok-ink); }
        .error-box svg, .success-box svg { flex-shrink: 0; margin-top: 2px; }

        .field { margin-bottom: 18px; }
        .field > label { display: block; font-size: 13px; font-weight: 600; color: var(--navy); margin-bottom: 7px; }
        .field input {
            width: 100%; border: 1.5px solid var(--line); background: var(--bg); border-radius: 8px;
            padding: 12px 15px; font-size: 14.5px; font-family: inherit; color: var(--ink);
            transition: border-color .15s ease, background .15s ease, box-shadow .15s ease; appearance: none;
        }
        .field input::placeholder { color: #8FA4B6; }
        .field input:hover { border-color: #B9D0E2; }
        .field input:focus { outline: none; border-color: var(--blue); background: #fff; box-shadow: 0 0 0 4px rgba(78,143,196,.15); }
        .field .hint { display: block; margin-top: 7px; font-size: 12px; line-height: 1.55; color: var(--ink-soft); }

        .btn-submit {
            width: 100%; background: var(--navy); color: #fff; border: 1.5px solid var(--navy);
            font-family: inherit; font-weight: 600; font-size: 15px; padding: 14px; border-radius: 8px;
            cursor: pointer; margin-top: 2px; transition: background .15s ease, transform .12s ease;
        }
        .btn-submit:hover { background: var(--navy-deep); }
        .btn-submit:active { transform: scale(.99); }
        .btn-submit:disabled { opacity: .7; cursor: wait; }

        .help-note {
            display: flex; gap: 10px; align-items: flex-start; margin-top: 18px;
            padding: 14px 16px; border-radius: 8px; background: #F7FAFC; border: 1px solid var(--line);
            font-size: 12.5px; line-height: 1.65; color: var(--ink-soft);
        }
        .help-note svg { flex-shrink: 0; margin-top: 2px; }
        .help-note strong { color: var(--navy); font-weight: 600; }

        .footer-link { text-align: center; font-size: 14px; color: var(--ink-soft); margin: 26px 0 0; padding-top: 22px; border-top: 1px solid var(--line); }
        .footer-link a { color: var(--navy); font-weight: 700; border-bottom: 1.5px solid var(--blue); padding-bottom: 1px; }
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
            .form-side { padding: 26px 22px 40px; background: #fff; justify-content: flex-start; }
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
        @media (prefers-reduced-motion: reduce) { * { transition: none !important; } }
    </style>
</head>
<body>

<div class="page">
    <div class="card">

@include('partials.panel_forgotpassword_siswa')

        {{-- Form --}}
        <main class="form-side">

            <a href="/login" class="back-home">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 6l-6 6 6 6"/></svg>
                Kembali ke halaman masuk
            </a>

            <h1>Lupa password?</h1>
            <p class="sub">Masukkan email akunmu. Kami akan mengirim tautan untuk membuat password baru.</p>

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

            <form method="POST" action="{{ route('password.email') }}" id="forgotForm">
                @csrf

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                           autocomplete="email" placeholder="username@gmail.com">
                    <span class="hint">Gunakan email yang sama dengan saat kamu mendaftar.</span>
                </div>

                <button type="submit" class="btn-submit" id="btnSubmit">Kirim tautan</button>

                <div class="help-note">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke="#4E8FC4" stroke-width="1.7"/><path d="M12 8v5M12 16h.01" stroke="#4E8FC4" stroke-width="1.8" stroke-linecap="round"/></svg>
                    <span><strong>Email tidak masuk?</strong> Cek folder spam atau promosi. Kalau masih belum ada, atau kamu lupa email yang dipakai, temui admin sekolah untuk dibantu mengatur ulang password.</span>
                </div>
            </form>

            <p class="footer-link">
                Sudah ingat passwordnya? <a href="/login">Masuk di sini</a>
            </p>

        </main>
    </div>
</div>

<script>
    // Cegah klik ganda saat form dikirim
    document.getElementById('forgotForm').addEventListener('submit', function () {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.textContent = 'Mengirim...';
    });
</script>

</body>
</html>