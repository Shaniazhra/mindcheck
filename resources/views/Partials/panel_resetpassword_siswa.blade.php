{{-- Sidebar Reset Password Siswa --}}

{{-- Panel kiri (desktop) --}}
<aside class="panel">
    <div>
        <a href="/" class="brand" aria-label="Kembali ke halaman utama MindCheck">
            <span class="brand-mark">
                <img src="{{ \App\Models\Pengaturan::url('logo', 'logo-smpn216.png') }}" alt="Logo SMPN 216 Jakarta">
            </span>
            <span class="brand-text">
                <span class="school-name" style="display:block">SMPN 216 Jakarta</span>
                <span class="school-sub" style="display:block">Portal Skrining Kesehatan Mental</span>
            </span>
        </a>

        <h2>Hampir selesai, buat password barumu</h2>
        <p class="lead">
            Pilih password yang mudah kamu ingat tapi sulit ditebak orang lain.
            Setelah disimpan, kamu bisa langsung masuk lagi.
        </p>

        <div class="prep">
            <h3>Tips password</h3>
            <ol>
                <li>Minimal 6 karakter, makin panjang makin aman</li>
                <li>Gabungkan huruf dan angka</li>
                <li>Jangan dibagikan ke siapa pun, termasuk teman</li>
            </ol>
        </div>
    </div>

    <div class="panel-foot">
        <strong>Tautan tidak berfungsi?</strong>
        Tautan hanya berlaku 60 menit. Kamu bisa meminta tautan baru kapan saja.
    </div>
</aside>

{{-- Header mobile --}}
<a href="/" class="mobile-brand brand" aria-label="Kembali ke halaman utama MindCheck">
    <span class="brand-mark">
        <img src="{{ \App\Models\Pengaturan::url('logo', 'logo-smpn216.png') }}" alt="Logo SMPN 216 Jakarta">
    </span>
    <span class="brand-text">
        <span class="school-name" style="display:block">SMPN 216 Jakarta</span>
        <span class="school-sub" style="display:block">Portal Skrining Kesehatan Mental</span>
    </span>
</a>