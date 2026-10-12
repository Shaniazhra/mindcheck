{{-- Panel gambar (kiri, desktop) --}}
<aside class="panel">
    <div>
        <a href="/" class="brand" aria-label="Kembali ke halaman utama MindCheck">
            <span class="brand-mark">
                <img src="{{ \App\Models\Pengaturan::url('logo', 'logo-smpn216.png') }}" alt="Logo SMPN 216 Jakarta">
            </span>
            <span class="brand-text">
                <span class="school-name">SMPN 216 Jakarta</span>
                <span class="school-sub">Portal Guru Bimbingan &amp; Konseling</span>
            </span>
        </a>

        <span class="panel-tag">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="5" y="11" width="14" height="10" rx="2" stroke="#fff" stroke-width="1.8"/><path d="M8 11V7a4 4 0 0 1 8 0v4" stroke="#fff" stroke-width="1.8" stroke-linecap="round"/></svg>
            Akses terbatas
        </span>
        <h2>Ruang kerja Guru BK</h2>
        <p class="lead">Tinjau hasil skrining SDQ siswa, catat pendampingan, dan pantau kondisi setiap kelas dari satu tempat.</p>

        <ul class="tools">
            <li>
                <span class="ico"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M8 6h12M8 12h12M8 18h12M4 6h.01M4 12h.01M4 18h.01" stroke="#BFE3C6" stroke-width="2" stroke-linecap="round"/></svg></span>
                <span><strong>Riwayat hasil skrining</strong>Lihat hasil SDQ tiap siswa beserta detail jawabannya.</span>
            </li>
            <li>
                <span class="ico"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M7 3h8l4 4v14H7z" stroke="#BFE3C6" stroke-width="1.8" stroke-linejoin="round"/><path d="M10 12h6M10 16h6" stroke="#BFE3C6" stroke-width="1.8" stroke-linecap="round"/></svg></span>
                <span><strong>Laporan konseling</strong>Catat sesi pendampingan dan cetak sebagai PDF.</span>
            </li>
            <li>
                <span class="ico"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="4" y="4" width="16" height="16" rx="2" stroke="#BFE3C6" stroke-width="1.8"/><path d="M8 15v-3M12 15V9M16 15v-5" stroke="#BFE3C6" stroke-width="1.8" stroke-linecap="round"/></svg></span>
                <span><strong>Data per kelas</strong>Pantau gambaran hasil skrining di setiap kelas.</span>
            </li>
        </ul>
    </div>

    <div class="panel-foot">
        Halaman ini khusus Guru BK dan admin sekolah.<br>
    </div>
</aside>

{{-- Header mobile --}}
<a href="/" class="mobile-brand brand" aria-label="Kembali ke halaman utama MindCheck">
    <span class="brand-mark">
        <img src="{{ \App\Models\Pengaturan::url('logo', 'logo-smpn216.png') }}" alt="Logo SMPN 216 Jakarta">
    </span>
    <span class="brand-text">
        <span class="school-name">SMPN 216 Jakarta</span>
        <span class="school-sub">Portal Guru BK</span>
    </span>
</a>