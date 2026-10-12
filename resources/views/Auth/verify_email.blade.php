<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email — MindCheck SMPN 216 Jakarta</title>
    <link rel="icon" type="image/png" href="{{ \App\Models\Pengaturan::url('logo', 'logo-smpn216.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,500;8..60,600;8..60,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/tema.css')

    {{-- Foto latar panel: gambar pertama dari slider yang diatur Super Admin --}}
    @php $heroBg = \App\Models\Pengaturan::heroSlides()[0] ?? null; @endphp

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
        [hidden] { display: none !important; }

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
            background-color: var(--navy);
            @if ($heroBg)
            background-image: url('{{ $heroBg }}');
            background-size: cover; background-position: center; background-repeat: no-repeat;
            @endif
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

        /* ===== Header mobile ===== */
        .mobile-brand {
            display: none; position: relative; align-items: center; gap: 14px;
            padding: 34px 20px 30px; overflow: hidden;
            background-color: var(--navy);
            @if ($heroBg)
            background-image: url('{{ $heroBg }}');
            background-size: cover; background-position: center; background-repeat: no-repeat;
            @endif
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

        /* ===== Sisi kanan ===== */
        .form-side {
            flex: 1; min-width: 0; padding: 64px 56px 48px;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            background: linear-gradient(180deg, var(--blue-soft) 0%, #fff 260px);
        }
        .form-side > * { width: 100%; max-width: 480px; text-align: left; }

        .mail-ill { display: block; width: 84px; height: auto; margin: 0 0 18px; overflow: visible; animation: mail-float 3.6s ease-in-out infinite; }
        .mail-ill .flap { transform-box: fill-box; transform-origin: 50% 0; animation: mail-flap 3.6s ease-in-out infinite; }
        .mail-ill .badge { transform-box: fill-box; transform-origin: 50% 50%; animation: mail-pop 3.6s ease-in-out infinite; }
        @keyframes mail-float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-5px); } }
        @keyframes mail-flap { 0%, 100% { transform: scaleY(1); } 50% { transform: scaleY(.92); } }
        @keyframes mail-pop { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.07); } }

        .form-side h1 { font-size: 28px; line-height: 1.25; font-weight: 600; margin: 0 0 8px; letter-spacing: -.2px; color: var(--navy); }
        .form-side .sub { font-size: 14px; color: var(--ink-soft); margin: 0 0 22px; line-height: 1.65; }

        /* Alamat tujuan email */
        .mail-to {
            display: flex; align-items: center; gap: 12px; margin: 0 0 22px;
            padding: 14px 16px; border-radius: 8px; background: #F7FAFC; border: 1px solid var(--line);
        }
        .mail-to svg { flex-shrink: 0; }
        .mail-to small { display: block; font-size: 12px; font-weight: 600; color: var(--ink-soft); margin-bottom: 2px; }
        .mail-to strong { display: block; font-size: 15px; font-weight: 600; color: var(--navy); word-break: break-all; line-height: 1.4; }

        .error-box, .success-box {
            font-size: 13px; border-radius: 8px; padding: 13px 16px; margin-bottom: 22px;
            display: flex; align-items: flex-start; gap: 10px; font-weight: 500; line-height: 1.55;
        }
        .error-box { background: var(--error-bg); color: var(--error-ink); border: 1px solid rgba(180,69,63,.25); border-left: 4px solid var(--error-ink); }
        .success-box { background: var(--ok-bg); color: var(--ok-ink); border: 1px solid rgba(47,107,69,.25); border-left: 4px solid var(--ok-ink); }
        .error-box svg, .success-box svg { flex-shrink: 0; margin-top: 2px; }

        /* Status setelah email berhasil diverifikasi */
        .done-box {
            display: flex; align-items: flex-start; gap: 12px; margin: 0 0 22px;
            padding: 16px 18px; border-radius: 8px; background: var(--ok-bg);
            border: 1px solid rgba(47,107,69,.25); border-left: 4px solid var(--ok-ink);
            color: var(--ok-ink); font-size: 14px; line-height: 1.6; font-weight: 500;
        }
        .done-box svg { flex-shrink: 0; margin-top: 2px; }
        .done-box strong { display: block; font-weight: 700; margin-bottom: 2px; }

        .btn-link {
            display: block; text-align: center; width: 100%;
            background: var(--navy); color: #fff; border: 1.5px solid var(--navy);
            font-weight: 600; font-size: 15px; padding: 14px; border-radius: 8px;
            transition: background .15s ease;
        }
        .btn-link:hover { background: var(--navy-deep); }

        /* Panduan: hanya tampil di HP (di desktop sudah ada di panel kiri) */
        .guide { display: none; list-style: none; counter-reset: g; margin: 0 0 22px; padding: 0; }
        .guide li { position: relative; padding: 0 0 14px 38px; font-size: 13.5px; line-height: 1.6; color: var(--ink-soft); counter-increment: g; }
        .guide li:last-child { padding-bottom: 0; }
        .guide li::before {
            content: counter(g); position: absolute; left: 0; top: 0; width: 26px; height: 26px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; background: var(--blue-soft); color: var(--navy);
        }
        .guide b { color: var(--navy); font-weight: 600; }

        .btn-submit {
            width: 100%; background: var(--navy); color: #fff; border: 1.5px solid var(--navy);
            font-family: inherit; font-weight: 600; font-size: 15px; padding: 14px; border-radius: 8px;
            cursor: pointer; margin-top: 2px; transition: background .15s ease, transform .12s ease;
        }
        .btn-submit:hover { background: var(--navy-deep); }
        .btn-submit:active { transform: scale(.99); }
        .btn-submit:disabled { opacity: .7; cursor: not-allowed; }

        .help-note {
            display: flex; gap: 10px; align-items: flex-start; margin-top: 18px;
            padding: 14px 16px; border-radius: 8px; background: #F7FAFC; border: 1px solid var(--line);
            font-size: 12.5px; line-height: 1.65; color: var(--ink-soft);
        }
        .help-note svg { flex-shrink: 0; margin-top: 2px; }
        .help-note strong { color: var(--navy); font-weight: 600; }

        .footer-link { text-align: center; font-size: 14px; line-height: 1.6; color: var(--ink-soft); margin: 26px 0 0; padding-top: 22px; border-top: 1px solid var(--line); }
        .footer-link form { margin: 0; }
        .footer-link button {
            background: none; border: none; padding: 0; font: inherit; font-weight: 700; cursor: pointer;
            color: var(--navy); text-decoration: underline; text-decoration-color: var(--blue);
            text-decoration-thickness: 1.5px; text-underline-offset: 4px;
        }
        .footer-link button:hover { color: var(--blue); }

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
            .form-side h1 { font-size: 23px; }
            .guide { display: block; }
        }
        @media (max-width: 480px) {
            .form-side { padding: 22px 16px 34px; }
            .form-side h1 { font-size: 21px; }
            .form-side .sub { font-size: 13px; margin-bottom: 20px; }
            .mail-to strong { font-size: 14px; }
            .btn-submit, .btn-link { padding: 13px; font-size: 14px; }
        }
        @media (prefers-reduced-motion: reduce) { * { transition: none !important; animation: none !important; } }
    </style>
</head>
<body>

<div class="page">
    <div class="card">

        @include('partials.panel_verifyemail_siswa')

        {{-- Isi --}}
        <main class="form-side">

            {{-- Ilustrasi amplop kecil --}}
            <svg class="mail-ill" viewBox="0 0 120 96" fill="none" aria-hidden="true">
                <rect x="8" y="22" width="92" height="62" rx="9" fill="#DCEBF6"/>
                <path class="flap" d="M8 31l46 31 46-31" stroke="#4E8FC4" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M8 80l34-28M100 80L66 52" stroke="#B9D3EA" stroke-width="2.5" stroke-linecap="round"/>
                <g class="badge">
                <circle cx="98" cy="24" r="17" fill="#4C7A52"/>
                <circle cx="98" cy="24" r="13.5" stroke="rgba(255,255,255,.55)" stroke-width="1.2" stroke-dasharray="2.5 2.5"/>
                <path d="M91 24.5l5 5 9-10" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </g>
            </svg>

            {{-- ===== Keadaan: menunggu email dibuka ===== --}}
            <div id="pendingState">

                <h1>Periksa emailmu</h1>
                <p class="sub">Kami telah mengirim tautan verifikasi. Akunmu akan aktif setelah tautan tersebut dibuka.</p>

                <div class="mail-to">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#4E8FC4" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>
                    <div>
                        <small>Dikirim ke</small>
                        <strong>{{ auth()->user()->email }}</strong>
                    </div>
                </div>

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

                {{-- Panduan (hanya tampil di HP) --}}
                <ol class="guide">
                    <li><b>Buka kotak masuk emailmu</b> dan cari pesan dari MindCheck.</li>
                    <li><b>Klik tombol verifikasi</b> di dalam pesan tersebut.</li>
                    <li><b>Kembali ke sini</b>, halaman ini akan otomatis memberi tahu bila sudah berhasil.</li>
                </ol>

                <form method="POST" action="{{ route('verification.send') }}" id="resendForm">
                    @csrf
                    <button type="submit" class="btn-submit" id="btnResend">
                        <span id="btnLabel">Kirim ulang tautan verifikasi</span>
                    </button>

                    <div class="help-note">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke="#4E8FC4" stroke-width="1.7"/><path d="M12 8v5M12 16h.01" stroke="#4E8FC4" stroke-width="1.8" stroke-linecap="round"/></svg>
                        <span><strong>Salah memasukkan email?</strong> Keluar dulu, lalu daftar ulang atau temui admin sekolah.</span>
                    </div>
                </form>

                <div class="footer-link">
                    <form method="POST" action="/logout">
                        @csrf
                        Bukan kamu? <button type="submit">Keluar</button>
                    </form>
                </div>

            </div>

            {{-- ===== Keadaan: email sudah terverifikasi ===== --}}
            <div id="doneState" hidden>

                <h1>Email berhasil diverifikasi</h1>
                <p class="sub">Akunmu sudah aktif. Silakan masuk untuk mulai mengisi skrining.</p>

                <div class="done-box" role="status" aria-live="polite">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 12l2 2 4-4" stroke="#2F6B45" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="9" stroke="#2F6B45" stroke-width="1.6"/></svg>
                    <span>
                        <strong>Verifikasi berhasil</strong>
                        Kamu akan diarahkan ke halaman masuk sebentar lagi.
                    </span>
                </div>

                <a href="/login" class="btn-link" id="btnMasuk">Masuk sekarang</a>

            </div>

        </main>
    </div>
</div>

<script>
    // ===== Tombol kirim ulang dengan jeda 60 detik =====
    (function () {
        var KEY = 'verifikasiKirimUlang';
        var WAIT = 60; // detik
        var form  = document.getElementById('resendForm');
        var btn   = document.getElementById('btnResend');
        var label = document.getElementById('btnLabel');
        var normal = label.textContent;

        function sisa() {
            var t = 0;
            try { t = parseInt(localStorage.getItem(KEY) || '0', 10); } catch (e) {}
            return Math.max(0, WAIT - Math.floor((Date.now() - t) / 1000));
        }

        function tick() {
            var s = sisa();
            if (s > 0) {
                btn.disabled = true;
                label.textContent = 'Kirim ulang dalam ' + s + ' detik';
                setTimeout(tick, 1000);
            } else {
                btn.disabled = false;
                label.textContent = normal;
            }
        }

        // Cegah klik ganda; hitungan mundur dimulai setelah halaman dimuat ulang
        form.addEventListener('submit', function () {
            try { localStorage.setItem(KEY, String(Date.now())); } catch (e) {}
            btn.disabled = true;
            label.textContent = 'Mengirim...';
        });

        tick();
    })();
</script>

<script>
    // ===== Cek otomatis apakah tautan di email sudah dibuka =====
    (function () {
        var statusUrl = @json(\Illuminate\Support\Facades\URL::temporarySignedRoute('verification.status', now()->addHours(3), ['id' => auth()->id()]));
        var pending = document.getElementById('pendingState');
        var done = document.getElementById('doneState');
        var selesai = false;
        var timer = null;

        function berhasil() {
            if (selesai) return;
            selesai = true;
            clearTimeout(timer);

            pending.hidden = true;
            done.hidden = false;
            window.scrollTo(0, 0);

            // Sesi sudah ditutup oleh server saat tautan dibuka, jadi cukup pindah ke login
            setTimeout(function () { window.location.href = '/login'; }, 2500);
        }

        function cek() {
            if (selesai) return;
            clearTimeout(timer);

            fetch(statusUrl, { headers: { 'Accept': 'application/json' }, cache: 'no-store' })
                .then(function (r) { return r.ok ? r.json() : null; })
                .then(function (d) {
                    if (d && d.verified) { berhasil(); }
                    else { timer = setTimeout(cek, 3000); }
                })
                .catch(function () { timer = setTimeout(cek, 5000); });
        }

        // Sinyal langsung dari tab "Email berhasil diverifikasi" di browser yang sama
        try {
            var ch = new BroadcastChannel('mindcheck-verify');
            ch.onmessage = function (e) { if (e.data === 'verified') berhasil(); };
        } catch (e) {}

        window.addEventListener('storage', function (e) {
            if (e.key === 'emailVerified') berhasil();
        });

        // Cek ulang segera saat tab ini dibuka kembali (tab latar belakang diperlambat browser)
        document.addEventListener('visibilitychange', function () {
            if (!document.hidden) cek();
        });
        window.addEventListener('focus', cek);

        timer = setTimeout(cek, 2000);
    })();
</script>

</body>
</html>