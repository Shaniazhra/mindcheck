<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa — SMPN 216 Jakarta</title>
    @php
        $logoUrl = \App\Models\Pengaturan::url('logo', 'logo-smpn216.png');
    @endphp
    <link rel="icon" type="image/png" href="{{ $logoUrl }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Source+Serif+4:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/tema.css')
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <style>
        /* ============ Token: keluarga warna sama dengan Dashboard Super Admin ============ */
        /* Font dan ukuran font diatur oleh tema.css, jadi tidak diulang di sini */
        :root {
            --bg: #F3F5F9; --ink: #14233B; --ink-2: #475569; --ink-3: #6B7A90; --line: #E3E8F0;
            --ind-950: #12143A;
            --accent: #4B5FD6; --accent-soft: #ECEFFC; --accent-line: #C9D0F6; --accent-glow: #8D9BF0;
        }
        body {
            color: var(--ink);
            background: radial-gradient(900px 420px at 90% -100px, #E1E6FA 0%, transparent 70%), var(--bg);
            background-attachment: fixed;
        }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        :focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }

        .card { background: #fff; border: 1px solid var(--line); border-radius: 14px; box-shadow: 0 1px 2px rgba(15,39,71,.05), 0 8px 24px -16px rgba(15,39,71,.18); }
        .h-title { font-size: .92rem; font-weight: 700; color: var(--ink); }
        .h-sub { font-size: .78rem; line-height: 1.6; color: var(--ink-3); margin-top: 3px; }
        .ico { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: var(--accent-soft); color: var(--accent); }
        .ico.warn { background: #FDF1DC; color: #B7690B; }

        /* ---------- Ringkasan siswa (kiri) ---------- */
        .profile-top { padding: 28px 24px 22px; text-align: center; border-bottom: 1px solid var(--line);
            background: radial-gradient(260px 140px at 50% -40px, #E1E6FA 0%, transparent 75%), #fff; }
        .big-avatar { width: 76px; height: 76px; margin: 0 auto; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; font-weight: 800; color: #fff; background: linear-gradient(135deg, var(--accent), #2B78E0); box-shadow: 0 0 0 4px var(--accent-soft), 0 10px 20px -10px var(--accent); }
        .kelas-pill { display: inline-flex; align-items: center; padding: 3px 11px; border-radius: 999px; background: var(--accent-soft); color: var(--accent); font-size: .74rem; font-weight: 700; }
        .info-row { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 12px 0; border-bottom: 1px dashed var(--line); font-size: .8rem; }
        .info-row:last-child { border-bottom: 0; padding-bottom: 0; }
        .info-row dt { color: var(--ink-3); display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
        .info-row dd { color: var(--ink); font-weight: 600; text-align: right; min-width: 0; overflow-wrap: anywhere; }

        /* ---------- Form ---------- */
        .lbl { display: block; margin-bottom: 6px; font-size: .78rem; font-weight: 600; color: var(--ink-2); }
        .lbl small { font-weight: 400; color: #94A3B8; }
        .input { width: 100%; height: 44px; padding: 0 14px; border-radius: 11px; border: 1px solid var(--line); background: #fff; font-size: .86rem; color: var(--ink); transition: .15s; }
        .input::placeholder { color: #A3AEC0; }
        .input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 4px rgba(75,95,214,.12); }
        .btn-sa { display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 44px; padding: 0 22px; border-radius: 11px;
                  background: var(--accent); color: #fff; font-size: .84rem; font-weight: 600; transition: .15s; box-shadow: 0 6px 14px -8px var(--accent); }
        .btn-sa:hover { background: #3E50BF; }
        .btn-sa:active, .btn-line:active, .btn-warn:active { transform: scale(.98); }
        .btn-line { display: inline-flex; align-items: center; justify-content: center; height: 44px; padding: 0 22px; border-radius: 11px;
                    border: 1px solid var(--line); background: #fff; color: var(--ink-2); font-size: .84rem; font-weight: 600; transition: .15s; }
        .btn-line:hover { background: var(--accent-soft); border-color: var(--accent-line); color: var(--accent); }
        .btn-warn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 44px; padding: 0 20px; border-radius: 11px;
                    border: 1px solid #F1D9A8; background: #FFF8EA; color: #B7690B; font-size: .84rem; font-weight: 600; transition: .15s; white-space: nowrap; }
        .btn-warn:hover { background: #FDF1DC; border-color: #E8C57F; }

        /* ---------- Pop up password baru ---------- */
        .pw-overlay { position: fixed; inset: 0; z-index: 60; display: flex; align-items: center; justify-content: center; padding: 20px;
            background: rgba(14,16,48,.55); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
            animation: pw-fade .2s ease-out; }
        .pw-overlay.closing { opacity: 0; transition: opacity .18s ease-in; }
        .pw-modal { position: relative; width: 100%; max-width: 440px; border-radius: 20px; overflow: hidden; text-align: center;
            background: radial-gradient(340px 170px at 50% -50px, #DDF6EA 0%, transparent 75%), #fff;
            border: 1px solid #CDEFDD; box-shadow: 0 30px 60px -20px rgba(14,16,48,.45);
            padding: 32px 28px 26px; animation: pw-pop .3s cubic-bezier(.2,.9,.3,1.15); }
        .pw-overlay.closing .pw-modal { transform: scale(.96); transition: transform .18s ease-in; }
        @keyframes pw-fade { from { opacity: 0; } to { opacity: 1; } }
        @keyframes pw-pop { from { opacity: 0; transform: translateY(14px) scale(.95); } to { opacity: 1; transform: none; } }
        .pw-x { position: absolute; top: 14px; right: 14px; width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center;
            color: var(--ink-3); transition: .15s; }
        .pw-x:hover { background: #F1F4F9; color: var(--ink); }
        .pw-badge { width: 60px; height: 60px; margin: 0 auto; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            background: #D5F2E4; color: #0F8A5F; box-shadow: 0 0 0 6px #EAF8F1; }
        .pw-box { margin-top: 20px; padding: 16px 14px; border-radius: 14px; border: 1px dashed #86D9B5; background: #F4FCF8; }
        .pw-value { display: block; font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 1.6rem; font-weight: 700;
            letter-spacing: .1em; color: #0B6B49; overflow-wrap: anywhere; user-select: all; }
        .btn-copy { display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: 100%; height: 46px; margin-top: 14px; border-radius: 12px;
            background: #0F8A5F; color: #fff; font-size: .86rem; font-weight: 600; transition: .15s; box-shadow: 0 8px 16px -10px #0F8A5F; }
        .btn-copy:hover { background: #0B7650; }
        .btn-copy:active { transform: scale(.98); }
        .btn-copy.done { background: #14233B; box-shadow: none; }
        .pw-done { margin-top: 10px; width: 100%; height: 42px; border-radius: 12px; font-size: .82rem; font-weight: 600; color: var(--ink-2); transition: .15s; }
        .pw-done:hover { background: #F1F4F9; color: var(--ink); }
        @media (prefers-reduced-motion: reduce) { .pw-overlay, .pw-modal { animation: none !important; } }

        /* ---------- Header ---------- */
        .topbar::before { content: ''; position: absolute; left: 0; right: 0; top: 0; height: 3px; background: linear-gradient(90deg, var(--ind-950) 0%, var(--accent) 55%, #2B78E0 100%); }
    </style>
</head>

<body class="flex min-h-screen">

<div id="sidebar-overlay" onclick="closeSidebar()"></div>

{{-- ================= SIDEBAR ================= --}}
@include('partials.sidebar_superadmin')

{{-- ================= MAIN ================= --}}
<main class="flex-1 min-w-0 flex flex-col">

    <header class="topbar h-16 bg-white/90 backdrop-blur-md border-b border-[#E3E8F0] flex items-center px-4 md:px-8 sticky top-0 z-30">
        <div class="flex items-center gap-3">
            <button id="hamburger-btn" onclick="openSidebar()" aria-label="Buka menu"
                    class="w-9 h-9 rounded-lg border border-[#E3E8F0] flex items-center justify-center hover:bg-[#ECEFFC] transition-colors lg:hidden">
                <span class="material-symbols-outlined text-[#475569]" style="font-size:20px">menu</span>
            </button>
            <a href="{{ route('superadmin.siswa.index') }}" title="Kembali ke Data Siswa" aria-label="Kembali"
               class="w-9 h-9 rounded-lg border border-[#E3E8F0] flex items-center justify-center hover:bg-[#ECEFFC] transition-colors">
                <span class="material-symbols-outlined text-[#475569]" style="font-size:20px">arrow_back</span>
            </a>
            <div>
                <h2 class="text-base md:text-lg font-bold text-[#14233B] leading-tight">Edit Data Siswa</h2>
                <p class="text-xs text-[#6B7A90] hidden sm:block">Perbarui data akun siswa</p>
            </div>
        </div>
    </header>

    <div class="flex-1 p-4 md:p-8 space-y-6 max-w-[1400px] w-full mx-auto">

        @if(session('success'))
        <div class="bg-[#E3F5ED] border border-[#A7F3D0] text-[#0F8A5F] text-sm font-semibold rounded-xl px-4 py-3" role="status">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="bg-[#FDECEC] border border-[#F5C2C2] text-[#B42318] text-sm rounded-xl px-4 py-3" role="alert">
            <p class="font-semibold mb-1">Data belum bisa disimpan. Mohon periksa kembali:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            {{-- ============ Kiri: ringkasan siswa ============ --}}
            <aside class="lg:col-span-4 card overflow-hidden">
                <div class="profile-top">
                    <div class="big-avatar">{{ strtoupper(substr($siswa->name, 0, 2)) }}</div>
                    <h3 class="text-base font-bold text-[#14233B] mt-4 leading-snug break-words">{{ $siswa->name }}</h3>
                    @if($siswa->kelas)
                    <div class="mt-2"><span class="kelas-pill">Kelas {{ $siswa->kelas }}</span></div>
                    @endif
                </div>

                <dl class="px-5 md:px-6 py-4">
                    <div class="info-row">
                        <dt><span class="material-symbols-outlined" style="font-size:18px">badge</span>NIS</dt>
                        <dd>{{ $siswa->nis ?: '-' }}</dd>
                    </div>
                    <div class="info-row">
                        <dt><span class="material-symbols-outlined" style="font-size:18px">mail</span>Email</dt>
                        <dd>{{ $siswa->email }}</dd>
                    </div>
                    <div class="info-row">
                        <dt><span class="material-symbols-outlined" style="font-size:18px">event</span>Terdaftar</dt>
                        <dd>{{ $siswa->created_at->format('d/m/Y') }}</dd>
                    </div>
                </dl>
            </aside>

            {{-- ============ Kanan: form + reset password ============ --}}
            <div class="lg:col-span-8 space-y-6">

                <section class="card overflow-hidden">

                    <div class="flex items-center gap-3 px-5 md:px-6 py-4 border-b border-[#E3E8F0]">
                        <div class="ico"><span class="material-symbols-outlined" style="font-size:20px">manage_accounts</span></div>
                        <div class="min-w-0">
                            <h4 class="h-title">Data akun</h4>
                            <p class="h-sub">Perbarui data akun siswa di bawah ini.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('superadmin.siswa.update', $siswa->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="p-5 md:p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">

                            <div class="sm:col-span-2">
                                <label for="name" class="lbl">Nama lengkap</label>
                                <input id="name" type="text" name="name" value="{{ old('name', $siswa->name) }}" required autocomplete="off"
                                       placeholder="Nama lengkap siswa" class="input">
                            </div>

                            <div>
                                <label for="nis" class="lbl">NIS <small>(opsional)</small></label>
                                <input id="nis" type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" autocomplete="off"
                                       placeholder="Nomor Induk Siswa" class="input">
                            </div>

                            <div>
                                <label for="kelas" class="lbl">Kelas</label>
                                <input id="kelas" type="text" name="kelas" value="{{ old('kelas', $siswa->kelas) }}" required autocomplete="off"
                                       placeholder="Misal 8A" class="input">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="email" class="lbl">Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email', $siswa->email) }}" required autocomplete="off"
                                       placeholder="nama@email.com" class="input">
                            </div>

                        </div>

                        <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 px-5 md:px-6 py-4 border-t border-[#E3E8F0] bg-[#FBFCFE]">
                            <a href="{{ route('superadmin.siswa.index') }}" class="btn-line">Batal</a>
                            <button type="submit" class="btn-sa">
                                <span class="material-symbols-outlined" style="font-size:18px">check</span>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </section>

                {{-- Reset password: form terpisah (tidak boleh bersarang di dalam form update) --}}
                <section class="card p-5 md:p-6 flex flex-col sm:flex-row sm:items-center gap-4">
                    <div class="flex items-start gap-3 flex-1 min-w-0">
                        <div class="ico warn"><span class="material-symbols-outlined" style="font-size:20px">lock_reset</span></div>
                        <div class="min-w-0">
                            <h4 class="h-title">Reset password</h4>
                            <p class="h-sub">Buat password baru untuk siswa ini. Password lama tidak berlaku lagi dan siswa keluar dari semua perangkat.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('superadmin.siswa.reset-password', $siswa->id) }}"
                          data-nama="{{ $siswa->name }}"
                          onsubmit="return confirm('Atur ulang password ' + this.dataset.nama + '?\n\nPassword lama tidak akan berlaku lagi dan siswa akan keluar dari semua perangkat.\n\nPassword baru hanya ditampilkan sekali, jadi siapkan untuk mencatatnya.');">
                        @csrf
                        <button type="submit" class="btn-warn w-full sm:w-auto">
                            <span class="material-symbols-outlined" style="font-size:18px">lock_reset</span>
                            Reset Password
                        </button>
                    </form>
                </section>

            </div>
        </div>

        <footer class="pt-4 border-t border-[#E3E8F0] flex justify-between items-center flex-wrap gap-2">
            <p class="text-xs text-[#6B7A90]">© {{ date('Y') }} SMPN 216 Jakarta — Portal Skrining Kesehatan Mental Siswa</p>
            <p class="text-xs text-[#6B7A90]">Super Admin Panel</p>
        </footer>

    </div>
</main>

{{-- ===== Pop up password baru (muncul sekali setelah reset) ===== --}}
@if(session('password_baru'))
<div id="pw-overlay" class="pw-overlay" onclick="if (event.target === this) tutupPopup()">
    <div class="pw-modal" role="dialog" aria-modal="true" aria-labelledby="pw-title">

        <button type="button" class="pw-x" onclick="tutupPopup()" aria-label="Tutup">
            <span class="material-symbols-outlined" style="font-size:20px">close</span>
        </button>

        <div class="pw-badge">
            <span class="material-symbols-outlined" style="font-size:30px; font-variation-settings:'FILL' 1,'wght' 500,'GRAD' 0,'opsz' 24">key</span>
        </div>

        <h3 id="pw-title" class="text-lg font-bold text-[#14233B] mt-4">Password berhasil direset</h3>
        <p class="text-[.8rem] leading-relaxed text-[#6B7A90] mt-1.5">
            Password baru untuk <b class="text-[#14233B]">{{ $siswa->name }}</b>.<br>
            Hanya ditampilkan sekali, salin dan berikan kepada siswa.
        </p>

        <div class="pw-box">
            <span id="pw-value" class="pw-value">{{ session('password_baru') }}</span>
        </div>

        <button type="button" id="btn-copy" class="btn-copy" onclick="salinPassword()">
            <span class="material-symbols-outlined" id="copy-ico" style="font-size:19px">content_copy</span>
            <span id="copy-txt">Salin Password</span>
        </button>

        <button type="button" class="pw-done" onclick="tutupPopup()">Selesai</button>
    </div>
</div>
@endif

{{-- openSidebar() dan closeSidebar() (termasuk tombol Esc dan resize) sudah ada di partials.sidebar_superadmin --}}
<script>
    // ---- Pop up password ----
    const popup = document.getElementById('pw-overlay');

    if (popup) {
        document.body.style.overflow = 'hidden';
        document.getElementById('btn-copy').focus();
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') tutupPopup();
    });

    function tutupPopup() {
        if (!popup || popup.classList.contains('closing')) return;
        popup.classList.add('closing');
        document.body.style.overflow = '';
        // Hapus dari halaman supaya password tidak tersisa di DOM
        setTimeout(() => popup.remove(), 200);
    }

    function salinPassword() {
        const el = document.getElementById('pw-value');
        if (!el) return;
        const teks = el.textContent.trim();

        const berhasil = () => {
            const btn = document.getElementById('btn-copy');
            btn.classList.add('done');
            document.getElementById('copy-ico').textContent = 'check';
            document.getElementById('copy-txt').textContent = 'Tersalin';
            setTimeout(() => {
                btn.classList.remove('done');
                document.getElementById('copy-ico').textContent = 'content_copy';
                document.getElementById('copy-txt').textContent = 'Salin Password';
            }, 2000);
        };

        // Fallback untuk koneksi non-HTTPS / browser lama
        const cadangan = () => {
            const ta = document.createElement('textarea');
            ta.value = teks;
            ta.style.position = 'fixed';
            ta.style.opacity = '0';
            document.body.appendChild(ta);
            ta.select();
            try { document.execCommand('copy'); berhasil(); } catch (e) {}
            document.body.removeChild(ta);
        };

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(teks).then(berhasil).catch(cadangan);
        } else {
            cadangan();
        }
    }
</script>

</body>
</html>