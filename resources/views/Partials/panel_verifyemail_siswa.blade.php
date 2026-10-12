{{-- Sidebar Verifikasi Email Siswa --}}

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

        <h2>Satu langkah lagi sebelum mulai skrining</h2>
        <p class="lead">
            Verifikasi email memastikan akun hanya digunakan oleh pemiliknya,
            sehingga hasil skrining tetap rahasia dan aman.
        </p>

        <div class="prep">
            <h3>Langkah selanjutnya</h3>
            <ol>
                <li>Buka kotak masuk emailmu dan cari pesan dari MindCheck</li>
                <li>Klik tombol verifikasi di dalam pesan tersebut</li>
                <li>Kembali ke sini dan mulai mengisi skrining</li>
            </ol>
        </div>
    </div>

    <div class="panel-foot">
        <strong>Email tidak masuk?</strong>
        Periksa folder spam atau promosi. Kamu bisa meminta tautan baru kapan saja. 
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