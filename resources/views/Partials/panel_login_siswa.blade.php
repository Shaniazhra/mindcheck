{{-- Sidebar Login Siswa --}}

{{-- Panel kiri (desktop) --}}
<aside class="panel">
    <div>
        <a href="/" class="brand" aria-label="Kembali ke halaman utama MindCheck">
            <span class="brand-mark">
                <img src="{{ \App\Models\Pengaturan::url('logo', 'logo-smpn216.png') }}"
                     alt="Logo SMPN 216 Jakarta">
            </span>

            <span class="brand-text">
                <span class="school-name" style="display:block">
                    SMPN 216 Jakarta
                </span>
                <span class="school-sub" style="display:block">
                    Portal Skrining Kesehatan Mental
                </span>
            </span>
        </a>

        <h2>Kenali perasaanmu, dapatkan dukungan yang tepat</h2>

        <p class="lead">
            Masuk untuk mengisi skrining dan melihat hasilmu.
            Guru Bimbingan &amp; Konseling siap mendampingi kamu.
        </p>

        <div class="prep">
            <h3>Yang bisa kamu lakukan</h3>

            <ul>
                <li>
                    <svg width="16" height="16" viewBox="0 0 24 24"
                         fill="none" aria-hidden="true">
                        <circle cx="12" cy="12" r="9"
                                stroke="#8FD19E" stroke-width="1.8"/>
                        <path d="M8.5 12.5l2.5 2.5 4.5-5"
                              stroke="#8FD19E" stroke-width="1.8"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                    <span>Isi skrining SDQ, 25 pertanyaan singkat tentang kondisimu</span>
                </li>

                <li>
                    <svg width="16" height="16" viewBox="0 0 24 24"
                         fill="none" aria-hidden="true">
                        <circle cx="12" cy="12" r="9"
                                stroke="#8FD19E" stroke-width="1.8"/>
                        <path d="M8.5 12.5l2.5 2.5 4.5-5"
                              stroke="#8FD19E" stroke-width="1.8"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                    <span>Lihat ringkasan hasilmu langsung setelah mengisi</span>
                </li>

                <li>
                    <svg width="16" height="16" viewBox="0 0 24 24"
                         fill="none" aria-hidden="true">
                        <circle cx="12" cy="12" r="9"
                                stroke="#8FD19E" stroke-width="1.8"/>
                        <path d="M8.5 12.5l2.5 2.5 4.5-5"
                              stroke="#8FD19E" stroke-width="1.8"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                    <span>Datamu rahasia dan hanya bisa dilihat oleh Guru BK</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="panel-foot">
        <strong>Data kamu rahasia</strong>

        Hanya dapat diakses oleh Guru Bimbingan &amp; Konseling (BK).

    </div>
</aside>

{{-- Header mobile --}}
<a href="/" class="mobile-brand brand"
   aria-label="Kembali ke halaman utama MindCheck">
    <span class="brand-mark">
        <img src="{{ \App\Models\Pengaturan::url('logo', 'logo-smpn216.png') }}"
             alt="Logo SMPN 216 Jakarta">
    </span>

    <span class="brand-text">
        <span class="school-name" style="display:block">
            SMPN 216 Jakarta
        </span>
        <span class="school-sub" style="display:block">
            Portal Skrining Kesehatan Mental
        </span>
    </span>
</a>