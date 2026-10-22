<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Tampilan | SMPN 216 Jakarta</title>
    <link rel="icon" type="image/png" href="{{ $logo }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Source+Serif+4:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/tema.css')
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <style>
        /* ============ Token: keluarga warna sama dengan Dashboard Super Admin ============ */
        :root {
            --bg: #F3F5F9; --ink: #14233B; --ink-2: #475569; --ink-3: #6B7A90; --line: #E3E8F0;
            --ind-950: #12143A;
            --accent: #4B5FD6; --accent-soft: #ECEFFC; --accent-line: #C9D0F6; --accent-glow: #8D9BF0;
        }
        body {
            font-family: 'Inter', system-ui, sans-serif; color: var(--ink);
            background: radial-gradient(900px 420px at 90% -100px, #E1E6FA 0%, transparent 70%), var(--bg);
            background-attachment: fixed;
        }
        h1, h2, h3, h4 {
            font-family: 'Source Serif 4', Georgia, serif;
        }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        :focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }

        .card { background: #fff; border: 1px solid var(--line); border-radius: 14px; box-shadow: 0 1px 2px rgba(15,39,71,.05), 0 8px 24px -16px rgba(15,39,71,.18); }

        /* ---------- Judul kartu ---------- */
        .h-title { font-size: .92rem; font-weight: 700; color: var(--ink); }
        .h-sub { font-size: .78rem; line-height: 1.6; color: var(--ink-3); margin-top: 4px; }
        .ico { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: var(--accent-soft); color: var(--accent); }
        .pill { display: inline-flex; align-items: center; padding: 3px 11px; border-radius: 999px; font-size: .72rem; font-weight: 700; white-space: nowrap; background: #EDF1F7; color: var(--ink-2); }

        /* ---------- Tombol ---------- */
        .btn-sa { display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 42px; padding: 0 20px; border-radius: 11px;
                  background: var(--accent); color: #fff; font-size: .82rem; font-weight: 600; transition: .15s; box-shadow: 0 6px 14px -8px var(--accent); }
        .btn-sa:hover { background: #3E50BF; }
        .btn-sa:active { transform: scale(.98); }
        .btn-sa:disabled { opacity: .4; cursor: not-allowed; box-shadow: none; transform: none; }
        .btn-soft { display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 42px; padding: 0 18px; border-radius: 11px;
                    background: var(--accent-soft); color: var(--accent); font-size: .82rem; font-weight: 600; border: 1px solid var(--accent-line); transition: .15s; }
        .btn-soft:hover { background: #E1E6FA; }
        .btn-soft:disabled { opacity: .4; cursor: not-allowed; }
        .btn-danger { display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 42px; padding: 0 18px; border-radius: 11px;
                      background: #fff; color: #DC2626; font-size: .82rem; font-weight: 600; border: 1px solid #F2C4C4; transition: .15s; }
        .btn-danger:hover { background: #FBE9E9; }

        /* ---------- Input file ---------- */
        .btn-file { font-size: .82rem; color: var(--ink-3); }
        .btn-file::file-selector-button {
            margin-right: .75rem; padding: .55rem 1rem; border-radius: 10px; border: 1px solid var(--accent-line);
            font-size: .8rem; font-weight: 600; font-family: inherit; background: var(--accent-soft); color: var(--accent); cursor: pointer; transition: .15s;
        }
        .btn-file::file-selector-button:hover { background: #E1E6FA; }

        /* ---------- Kotak gambar ---------- */
        .thumb { border: 1px solid var(--line); background: #F7F9FC; overflow: hidden; flex-shrink: 0; transition: opacity .15s, filter .15s; }
        .row-img { display: flex; align-items: center; gap: 16px; padding: 12px; border: 1px solid var(--line); border-radius: 12px; background: #fff; transition: background .15s, border-color .15s; }
        .row-new { border: 1px dashed var(--accent-line); background: #F7F8FE; }

        /* Gambar yang sudah tersimpan: tampil, disembunyikan, atau akan dihapus */
        .row-img.is-hidden .thumb { opacity: .45; filter: grayscale(1); }
        .row-img.is-delete { border-color: #F2C4C4; background: #FFF7F7; }
        .row-img.is-delete .thumb { opacity: .35; filter: grayscale(1); }
        .row-img.is-delete .img-name { text-decoration: line-through; color: #94A3B8; }
        .img-status { font-size: .72rem; font-weight: 600; margin-top: 4px; color: #0F8A5F; }
        .row-img.is-hidden .img-status { color: var(--ink-3); }
        .row-img.is-delete .img-status { color: #DC2626; }

        /* Saklar tampil / sembunyikan */
        .sw { position: relative; width: 36px; height: 20px; border-radius: 99px; background: #CBD5E1; transition: .15s; flex-shrink: 0; }
        .sw::after { content: ''; position: absolute; top: 2px; left: 2px; width: 16px; height: 16px; border-radius: 50%; background: #fff; box-shadow: 0 1px 2px rgba(0,0,0,.25); transition: transform .15s; }
        .hero-show:checked + .sw { background: var(--accent); }
        .hero-show:checked + .sw::after { transform: translateX(16px); }
        .hero-show:focus-visible + .sw { outline: 2px solid var(--accent); outline-offset: 2px; }
        .hero-show:disabled + .sw { opacity: .4; }
        .sw-label { display: inline-flex; align-items: center; gap: 8px; font-size: .78rem; font-weight: 600; color: var(--ink-2); cursor: pointer; }

        /* Tombol hapus per gambar */
        .btn-del { display: inline-flex; align-items: center; gap: 6px; height: 34px; padding: 0 12px; border-radius: 9px; border: 1px solid #F2C4C4;
                   background: #fff; color: #DC2626; font-size: .78rem; font-weight: 600; transition: .15s; white-space: nowrap; }
        .btn-del:hover { background: #FBE9E9; }
        .row-img.is-delete .btn-del { background: #fff; color: var(--ink-2); border-color: var(--line); }
        .row-img.is-delete .btn-del:hover { background: #F1F4F9; }

        /* ---------- Header ---------- */
        .topbar::before { content: ''; position: absolute; left: 0; right: 0; top: 0; height: 3px; background: linear-gradient(90deg, var(--ind-950) 0%, var(--accent) 55%, #2B78E0 100%); }
    </style>
    <link rel="stylesheet" href="{{ asset('css/icons.css') }}">
    <script src="{{ asset('js/icons.js') }}" defer></script>
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
            <div>
                <h2 class="text-base md:text-lg font-bold text-[#14233B] leading-tight">Pengaturan Tampilan</h2>
                <p class="text-xs text-[#6B7A90] hidden sm:block">Atur logo dan gambar beranda</p>
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
        <div class="bg-[#FDECEC] border border-[#F6C9C9] text-[#B42323] text-sm rounded-xl px-4 py-3 space-y-1" role="alert">
            @foreach($errors->all() as $e)
                <p>{{ $e }}</p>
            @endforeach
        </div>
        @endif

        {{-- ================= LOGO ================= --}}
        <form method="POST" action="{{ route('superadmin.pengaturan.update') }}" enctype="multipart/form-data"
              class="card p-5 md:p-6">
            @csrf
            <input type="hidden" name="section" value="logo">

            <div class="flex flex-col md:flex-row gap-6 md:gap-8">

                {{-- Kiri: judul dan keterangan --}}
                <div class="flex items-start gap-3 md:w-5/12 md:flex-shrink-0">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">image</span></span>
                    <div class="min-w-0">
                        <h3 class="h-title">Logo</h3>
                        <p class="h-sub">Dipakai di sidebar dan halaman lain. Disarankan gambar persegi (rasio 1:1), format PNG dengan latar transparan. Maksimal 2 MB.</p>
                    </div>
                </div>

                {{-- Kanan: pratinjau, pilih file, dan tombol --}}
                <div class="flex-1 min-w-0 flex flex-col gap-4 md:border-l md:border-[#E3E8F0] md:pl-8">
                    <div class="flex items-center gap-5 flex-wrap p-4 rounded-xl bg-[#F7F9FC] border border-[#E3E8F0]">
                        {{-- Pratinjau memakai logo apa adanya (tanpa latar putih), berganti ke file yang baru dipilih --}}
                        <div class="w-20 h-20 flex-shrink-0">
                            <img id="prev_logo" src="{{ $logo }}" alt="Logo saat ini" class="w-full h-full object-contain">
                        </div>
                        <input type="file" id="logo_input" name="logo" accept=".jpg,.jpeg,.png,.webp"
                               class="btn-file min-w-0 max-w-full">
                    </div>

                    <div class="flex flex-wrap items-center justify-end gap-2">
                        @if($logoCustom)
                        <button type="submit" name="reset_logo" value="1" formnovalidate
                                onclick="return confirm('Kembalikan ke logo default? Logo kustom akan dihapus.')"
                                class="btn-danger">
                            <span class="material-symbols-outlined" style="font-size:18px">delete</span>
                            Hapus Logo Kustom
                        </button>
                        @endif
                        <button type="submit" id="logo_save" disabled class="btn-sa">
                            <span class="material-symbols-outlined" style="font-size:18px">save</span>
                            Simpan Logo
                        </button>
                    </div>
                </div>

            </div>
        </form>

        {{-- ================= GAMBAR BERANDA ================= --}}
        <form id="hero_form" method="POST" action="{{ route('superadmin.pengaturan.update') }}" enctype="multipart/form-data"
              class="card p-5 md:p-6">
            @csrf
            <input type="hidden" name="section" value="hero">

            <div class="flex items-start justify-between gap-3">
                <div class="flex items-start gap-3">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">photo_library</span></span>
                    <div>
                        <h3 class="h-title">Gambar beranda</h3>
                        <p class="h-sub">
                            Opsional. Tambahkan gambar sebanyak yang diperlukan (maksimal {{ $maxHero }}).
                            1 gambar tampil diam, 2 gambar atau lebih tampil sebagai slide. Ukuran disarankan 1600 x 900 px, maksimal 2 MB per file (JPG, PNG, atau WEBP).
                        </p>
                        <p class="h-sub">
                            <b class="font-semibold text-[#475569]">Sembunyikan</b> untuk menyimpan gambar tanpa menampilkannya di beranda.
                            <b class="font-semibold text-[#475569]">Hapus</b> untuk menghapus file gambar secara permanen.
                            Gambar yang disembunyikan tetap dihitung dalam batas maksimal sampai dihapus.
                        </p>
                    </div>
                </div>
                <span id="hero_count" class="pill"></span>
            </div>

            <div class="mt-5">
                {{-- Gambar yang sudah tersimpan --}}
                @if(count($heroes))
                <div class="space-y-3 mb-3">
                    @foreach($heroes as $h)
                    <div class="hero-existing row-img flex-wrap sm:flex-nowrap">
                        <div class="thumb w-36 aspect-video rounded-lg">
                            <img src="{{ $h['url'] }}" alt="Gambar beranda" class="w-full h-full object-cover">
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="img-name text-sm font-semibold text-[#14233B]">Gambar {{ $loop->iteration }}</p>
                            <p class="text-xs text-[#6B7A90] truncate">{{ basename($h['path']) }}</p>
                            <p class="img-status"></p>
                        </div>

                        <div class="flex items-center gap-3 flex-shrink-0 w-full sm:w-auto justify-between sm:justify-end">
                            {{-- Tampil di beranda (mati = disembunyikan, file tetap tersimpan) --}}
                            <label class="sw-label">
                                <input type="checkbox" name="show_hero[]" value="{{ $h['path'] }}" class="hero-show sr-only"
                                       @checked(!($h['hidden'] ?? false))>
                                <span class="sw" aria-hidden="true"></span>
                                <span class="sw-text">Tampil</span>
                            </label>

                            {{-- Hapus permanen: ditandai dulu, file baru dihapus saat form disimpan --}}
                            <input type="checkbox" name="remove_hero[]" value="{{ $h['path'] }}" class="hero-remove sr-only" tabindex="-1" aria-hidden="true">
                            <button type="button" class="btn-del">
                                <span class="material-symbols-outlined" style="font-size:17px">delete</span>
                                <span class="t">Hapus</span>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Gambar baru (ditambah lewat tombol) --}}
                <div id="new_hero_list" class="space-y-3"></div>

                <p id="hero_empty" class="hidden text-xs text-[#6B7A90] text-center border border-dashed border-[#CBD5E1] rounded-xl py-8">
                    Belum ada gambar beranda. Klik "Tambah gambar" untuk menambahkan.
                </p>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-2 mt-5">
                <button type="button" id="add_hero_btn" class="btn-soft">
                    <span class="material-symbols-outlined" style="font-size:18px">add_photo_alternate</span>
                    Tambah gambar
                </button>
                <button type="submit" class="btn-sa">
                    <span class="material-symbols-outlined" style="font-size:18px">save</span>
                    Simpan Gambar Beranda
                </button>
            </div>
        </form>

        {{-- ================= FILE GAMBAR TIDAK TERPAKAI =================
             Muncul hanya bila controller mengirim $unused (daftar file gambar beranda
             yang masih ada di penyimpanan tetapi tidak tercatat lagi). --}}
        @if(!empty($unused) && count($unused) > 0)
        <form method="POST" action="{{ route('superadmin.pengaturan.update') }}"
              class="card p-5 md:p-6 flex flex-col sm:flex-row sm:items-center gap-4">
            @csrf
            <input type="hidden" name="section" value="cleanup">

            <div class="flex items-start gap-3 flex-1 min-w-0">
                <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">cleaning_services</span></span>
                <div class="min-w-0">
                    <h3 class="h-title">File gambar tidak terpakai</h3>
                    <p class="h-sub">
                        Ada {{ count($unused) }} file gambar beranda di penyimpanan yang sudah tidak dipakai di mana pun.
                        Hapus untuk melepaskan ruang penyimpanan.
                    </p>
                </div>
            </div>

            <button type="submit" class="btn-danger w-full sm:w-auto"
                    onclick="return confirm('Hapus {{ count($unused) }} file gambar yang tidak terpakai secara permanen?\n\nTindakan ini tidak bisa dibatalkan.')">
                <span class="material-symbols-outlined" style="font-size:18px">delete_sweep</span>
                Hapus File Tidak Terpakai
            </button>
        </form>
        @endif

        <footer class="pt-4 border-t border-[#E3E8F0] flex justify-between items-center flex-wrap gap-2">
            <p class="text-xs text-[#6B7A90]">© {{ date('Y') }} SMPN 216 Jakarta — Portal Skrining Kesehatan Mental Siswa</p>
            <p class="text-xs text-[#6B7A90]">Super Admin Panel</p>
        </footer>

    </div>
</main>

{{-- openSidebar() dan closeSidebar() sudah ada di partials.sidebar_superadmin --}}
<script>
    const MAX_SIZE = 2 * 1024 * 1024;
    const MAX_HERO = {{ $maxHero }};

    // ---------- LOGO ----------
    const logoInput = document.getElementById('logo_input');
    const logoSave  = document.getElementById('logo_save');
    logoInput.addEventListener('change', () => {
        const file = logoInput.files[0];
        if (!file) { logoSave.disabled = true; return; }
        if (file.size > MAX_SIZE) {
            alert('Ukuran file maksimal 2 MB.');
            logoInput.value = '';
            logoSave.disabled = true;
            return;
        }
        document.getElementById('prev_logo').src = URL.createObjectURL(file);
        logoSave.disabled = false;
    });

    // ---------- HERO ----------
    const list     = document.getElementById('new_hero_list');
    const addBtn   = document.getElementById('add_hero_btn');
    const countEl  = document.getElementById('hero_count');
    const emptyEl  = document.getElementById('hero_empty');

    // Gambar tersimpan yang belum ditandai hapus (yang disembunyikan tetap dihitung)
    function activeExisting() {
        return [...document.querySelectorAll('.hero-existing')]
            .filter(r => !r.querySelector('.hero-remove').checked).length;
    }
    function refreshHero() {
        const total = activeExisting() + list.children.length;
        countEl.textContent = total + ' / ' + MAX_HERO + ' gambar';
        addBtn.disabled = total >= MAX_HERO;
        emptyEl.classList.toggle('hidden', total > 0);
    }

    // Gambar tersimpan: saklar tampil/sembunyikan dan tombol hapus
    document.querySelectorAll('.hero-existing').forEach(row => {
        const show   = row.querySelector('.hero-show');
        const remove = row.querySelector('.hero-remove');
        const btn    = row.querySelector('.btn-del');
        const status = row.querySelector('.img-status');
        const swText = row.querySelector('.sw-text');

        const apply = () => {
            const hapus = remove.checked;
            row.classList.toggle('is-delete', hapus);
            row.classList.toggle('is-hidden', !hapus && !show.checked);
            show.disabled = hapus; // yang akan dihapus tidak perlu dikirim status tampilnya
            swText.textContent = show.checked ? 'Tampil' : 'Disembunyikan';
            status.textContent = hapus
                ? 'Akan dihapus permanen saat disimpan'
                : (show.checked ? 'Tampil di beranda' : 'Disembunyikan dari beranda');
            btn.querySelector('.t').textContent = hapus ? 'Batal hapus' : 'Hapus';
            refreshHero();
        };

        show.addEventListener('change', apply);
        btn.addEventListener('click', () => {
            remove.checked = !remove.checked;
            apply();
        });
        apply();
    });

    // Konfirmasi sebelum menghapus permanen
    document.getElementById('hero_form').addEventListener('submit', e => {
        const n = document.querySelectorAll('.hero-remove:checked').length;
        if (n > 0 && !confirm(n + ' gambar akan dihapus permanen dan tidak bisa dikembalikan.\n\nLanjutkan?')) {
            e.preventDefault();
        }
    });

    // Gambar baru
    addBtn.addEventListener('click', () => {
        if (activeExisting() + list.children.length >= MAX_HERO) return;

        const row = document.createElement('div');
        row.className = 'row-img row-new';
        row.innerHTML = `
            <div class="thumb w-36 aspect-video rounded-lg bg-white flex items-center justify-center">
                <img class="w-full h-full object-cover hidden" alt="Pratinjau">
                <span class="material-symbols-outlined text-[#94A3B8] ph" style="font-size:28px">image</span>
            </div>
            <div class="flex-1 min-w-0">
                <input type="file" name="hero_new[]" accept=".jpg,.jpeg,.png,.webp" class="btn-file w-full">
            </div>
            <button type="button" title="Batalkan" aria-label="Batalkan gambar" class="w-8 h-8 rounded-lg hover:bg-red-50 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-[#6B7A90] hover:text-red-500" style="font-size:20px">close</span>
            </button>`;

        const input = row.querySelector('input[type=file]');
        const img   = row.querySelector('img');
        const ph    = row.querySelector('.ph');

        input.addEventListener('change', () => {
            const file = input.files[0];
            if (!file) return;
            if (file.size > MAX_SIZE) {
                alert('Ukuran file maksimal 2 MB.');
                input.value = '';
                return;
            }
            img.src = URL.createObjectURL(file);
            img.classList.remove('hidden');
            ph.classList.add('hidden');
        });
        row.querySelector('button').addEventListener('click', () => {
            row.remove();
            refreshHero();
        });

        list.appendChild(row);
        refreshHero();
    });

    refreshHero();
</script>

</body>
</html>