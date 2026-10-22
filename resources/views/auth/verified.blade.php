<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Terverifikasi | MindCheck SMPN 216 Jakarta</title>
    <link rel="icon" type="image/png" href="{{ \App\Models\Pengaturan::url('logo', 'logo-smpn216.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,500;8..60,600;8..60,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/tema.css')

    <style>
        :root {
            --navy: #16324B; --navy-deep: #0E2338; --blue: #4E8FC4; --blue-soft: #DCEBF6;
            --leaf: #4C7A52; --ink: #16324B; --ink-soft: #52687D; --line: #D8E6F0;
            --ok-bg: #E7F5EC; --ok-ink: #2F6B45;
        }
        * { box-sizing: border-box; }
        [hidden] { display: none !important; }
        html, body { margin: 0; min-height: 100%; font-family: 'Inter', system-ui, sans-serif; color: var(--ink); -webkit-font-smoothing: antialiased; }
        body {
            min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px;
            background: linear-gradient(180deg, var(--blue-soft) 0%, #fff 320px);
        }
        h1 { font-family: 'Source Serif 4', Georgia, serif; font-size: 26px; line-height: 1.25; font-weight: 600; margin: 0 0 10px; color: var(--navy); }
        .box {
            position: relative; width: 100%; max-width: 460px; background: #fff; text-align: center;
            border: 1px solid var(--line); border-radius: 14px; padding: 40px 32px 32px;
            box-shadow: 0 12px 32px -18px rgba(22,50,75,.35); overflow: hidden;
        }
        .box::before { content: ""; position: absolute; top: 0; left: 0; right: 0; height: 5px; background: linear-gradient(90deg, var(--navy) 0%, var(--blue) 50%, var(--leaf) 100%); }
        .tick { width: 72px; height: 72px; margin: 0 auto 20px; border-radius: 50%; background: var(--ok-bg); display: flex; align-items: center; justify-content: center; }
        p { margin: 0 0 22px; font-size: 14px; line-height: 1.7; color: var(--ink-soft); }
        .btn {
            display: block; width: 100%; padding: 14px; border-radius: 8px; background: var(--navy); color: #fff;
            border: 1.5px solid var(--navy); font-family: inherit; font-weight: 600; font-size: 15px; text-decoration: none; cursor: pointer; transition: background .15s ease;
        }
        .btn:hover { background: var(--navy-deep); }
        .btn-line { background: #fff; color: var(--navy); border-color: var(--line); margin-top: 10px; }
        .btn-line:hover { background: var(--blue-soft); }
        .note {
            margin: 18px 0 0; padding: 12px 14px; border-radius: 8px; background: #F7FAFC; border: 1px solid var(--line);
            font-size: 12.5px; line-height: 1.65; color: var(--ink-soft); text-align: left;
        }
        .note strong { color: var(--navy); font-weight: 600; }
        @media (max-width: 480px) { .box { padding: 34px 20px 26px; } h1 { font-size: 22px; } }
    </style>
</head>
<body>

<main class="box">
    <div class="tick">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M5 12.5l4.5 4.5L19 7.5" stroke="#2F6B45" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>

    <h1>Email berhasil diverifikasi</h1>
    <p>Akunmu sudah aktif. Halaman verifikasi sebelumnya akan otomatis lanjut ke halaman masuk. Kamu juga bisa masuk langsung dari sini.</p>

    <a href="{{ route('login') }}" class="btn">Masuk sekarang</a>
    <button type="button" class="btn btn-line" id="btnTutup" hidden>Tutup halaman ini</button>

    <div class="note" id="noteTutup" hidden>
        <strong>Halaman ini tidak bisa menutup sendiri.</strong>
        Silakan tutup tab ini, lalu kembali ke tab "Periksa emailmu" yang tadi. Tab itu sudah otomatis berubah.
    </div>
</main>

<script>
    // Beri tahu tab "Periksa emailmu" yang masih terbuka di browser ini
    (function () {
        try { localStorage.setItem('emailVerified', String(Date.now())); } catch (e) {}
        try {
            var ch = new BroadcastChannel('mindcheck-verify');
            ch.postMessage('verified');
            ch.close();
        } catch (e) {}

        var btn = document.getElementById('btnTutup');
        var note = document.getElementById('noteTutup');

        function tutup() { window.close(); }
        btn.addEventListener('click', tutup);

        // Coba tutup otomatis. Browser sering menolak untuk tab yang dibuka dari email.
        setTimeout(function () {
            tutup();
            setTimeout(function () {
                btn.hidden = false;
                note.hidden = false;
            }, 400);
        }, 1200);
    })();
</script>

</body>
</html>