<?php

namespace App\Support;

use Carbon\CarbonInterface;

class TahunAjaran
{
    /**
     * Tahun mulai tahun ajaran untuk tanggal tertentu.
     * Tahun ajaran Indonesia dimulai bulan Juli.
     *
     * Contoh: Oktober 2026 -> 2026, Maret 2027 -> 2026.
     */
    public static function tahunMulai(?CarbonInterface $tanggal = null): int
    {
        $tanggal = $tanggal ?? now('Asia/Jakarta');

        return $tanggal->month >= 7
            ? $tanggal->year
            : $tanggal->year - 1;
    }

    /**
     * Tahun ajaran dalam format "2026/2027".
     */
    public static function sekarang(?CarbonInterface $tanggal = null): string
    {
        $mulai = self::tahunMulai($tanggal);

        return $mulai . '/' . ($mulai + 1);
    }

    /**
     * Angkatan (tahun masuk) dari kode kelas, mis. "7-1", "8-3", "9-10".
     * Kelas 7 -> tahun mulai ajaran ini, kelas 8 -> -1, kelas 9 -> -2.
     *
     * Inilah satu-satunya hal yang BOLEH berbeda antar kelas.
     * Tahun ajaran-nya sendiri selalu sama (lihat sekarang()).
     */
    public static function angkatanDariKelas(?string $kelas, ?CarbonInterface $tanggal = null): int
    {
        $tingkat = (int) substr(trim((string) $kelas), 0, 1);

        if (!in_array($tingkat, [7, 8, 9], true)) {
            $tingkat = 7;
        }

        return self::tahunMulai($tanggal) - ($tingkat - 7);
    }
}