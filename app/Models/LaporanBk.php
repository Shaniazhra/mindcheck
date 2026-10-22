<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanBk extends Model
{
    protected $table = 'laporan_bk';

    protected $fillable = [
        'hasil_sdq_id',
        'guru_bk_id',
        'tanggal_laporan',
        'observasi',
        'rekomendasi',         
        'rekomendasi_sistem',  
    ];

    protected $casts = [
        'tanggal_laporan' => 'date',
    ];

    public function hasilSdq(): BelongsTo
    {
        return $this->belongsTo(HasilSdq::class, 'hasil_sdq_id');
    }

    public function guruBk(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_bk_id');
    }

    /**
     * Rekomendasi Guru BK berbeda dari saran sistem.
     * Dipakai di laporan PDF / bab pembahasan untuk menunjukkan
     * bahwa keputusan akhir ada di tangan Guru BK.
     */
    public function getRekomendasiDiubahAttribute(): bool
    {
        if (blank($this->rekomendasi) || blank($this->rekomendasi_sistem)) {
            return false;
        }

        return trim($this->rekomendasi) !== trim($this->rekomendasi_sistem);
    }
}