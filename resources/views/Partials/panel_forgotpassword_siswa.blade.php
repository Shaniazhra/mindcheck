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

        <h2>Lupa password? Tenang, bisa diatur ulang</h2>
        <p class="lead">Kami akan mengirim tautan ke emailmu supaya kamu bisa membuat password baru dengan mudah.</p>

        <div class="prep">
            <h3>Caranya</h3>
            <ol>
                <li>Masukkan email yang kamu pakai saat mendaftar</li>
                <li>Buka emailmu, lalu klik tombol atur ulang password</li>
                <li>Buat password baru dan masuk kembali</li>
            </ol>
        </div>
    </div>

    <div class="panel-foot">
        <strong>Tidak bisa membuka email?</strong>
        Temui admin sekolah. Beliau bisa membantu mengatur ulang passwordmu.
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