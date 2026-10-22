<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\HasilSdq;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class SuperAdminController extends Controller
{
    // Jumlah maksimal gambar beranda
    private const MAX_HERO = 10;

    public function dashboard()
    {
        $totalGuru    = User::where('role', 'admin')->count();
        $totalSiswa   = User::where('role', 'siswa')->count();
        $totalKuesioner = HasilSdq::count();
        $cntAbnormal  = HasilSdq::where('hasil_label', 'Abnormal')->count();

        return view('superadmin.dashboard_superadmin', compact(
            'totalGuru', 'totalSiswa', 'totalKuesioner', 'cntAbnormal'
        ));
    }

    // ================= GURU BK =================

    public function guruIndex()
    {
        $guruList = User::where('role', 'admin')->latest()->get();
        return view('superadmin.guru.index', compact('guruList'));
    }

    public function guruCreate()
    {
        return view('superadmin.guru.form');
    }

    public function guruStore(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'nip'      => 'nullable|string|max:50',
            'email'    => 'required|email|unique:users,email',
            'password' => ['required', 'string', Password::min(8)],
        ]);

        User::create([
            'name'     => $validated['name'],
            'nip'      => $validated['nip'] ?? null,
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'admin',
        ]);

        return redirect()->route('superadmin.guru.index')->with('success', 'Akun Guru BK berhasil dibuat.');
    }

    public function guruEdit($id)
    {
        $guru = User::where('role', 'admin')->findOrFail($id);
        return view('superadmin.guru.form', compact('guru'));
    }

    public function guruUpdate(Request $request, $id)
    {
        $guru = User::where('role', 'admin')->findOrFail($id);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'nip'      => 'nullable|string|max:50',
            'email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($guru->id)],
            'password' => ['nullable', 'string', Password::min(8)],
        ]);

        $guru->name  = $validated['name'];
        $guru->nip   = $validated['nip'] ?? null;
        $guru->email = $validated['email'];

        if (!empty($validated['password'])) {
            $guru->password = Hash::make($validated['password']);
        }

        $guru->save();

        return redirect()->route('superadmin.guru.index')->with('success', 'Data Guru BK berhasil diperbarui.');
    }

    public function guruDestroy($id)
    {
        $guru = User::where('role', 'admin')->findOrFail($id);
        $guru->delete();

        return redirect()->route('superadmin.guru.index')->with('success', 'Akun Guru BK berhasil dihapus.');
    }

    // ================= SISWA =================

    public function siswaIndex(Request $request)
    {
        // Filter harus teks biasa (?cari[]=x tidak boleh membuat error 500).
        $request->validate([
            'kelas' => 'nullable|string|max:20',
            'cari'  => 'nullable|string|max:100',
        ]);

        $query = User::where('role', 'siswa');

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }
        if ($request->filled('cari')) {
            $query->where('name', 'like', '%' . $request->cari . '%');
        }

        $siswaList = $query->latest()->paginate(15)->withQueryString();

        return view('superadmin.siswa.index', compact('siswaList'));
    }

    public function siswaEdit($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);
        return view('superadmin.siswa.form', compact('siswa'));
    }

    public function siswaUpdate(Request $request, $id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'kelas' => ['required', 'string', 'max:20', 'regex:/^[7-9]-\d{1,2}$/'],
            'nis'   => ['nullable', 'string', 'max:50', Rule::unique('users', 'nis')->ignore($siswa->id)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($siswa->id)],
        ]);

        $siswa->update($validated);

        // Nama & kelas juga disalin di tabel hasil_sdq.
        // Samakan supaya dashboard, riwayat, dan laporan tidak menampilkan data lama.
        HasilSdq::where('user_id', $siswa->id)->update([
            'nama'  => $siswa->name,
            'kelas' => $siswa->kelas,
        ]);

        return redirect()->route('superadmin.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function siswaResetPassword($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);

        // Password acak 10 karakter (huruf dan angka)
        $passwordBaru = Str::password(10, symbols: false);

        $siswa->forceFill([
            'password'       => Hash::make($passwordBaru),
            'remember_token' => Str::random(60),
        ])->save();

        // Keluarkan siswa dari semua perangkat (session disimpan di tabel sessions)
        if (config('session.driver') === 'database') {
            DB::table('sessions')->where('user_id', $siswa->id)->delete();
        }

        // Kembali ke halaman edit siswa. Password dikirim lewat flash session
        // (key "password_baru") dan hanya tampil sekali di card pada halaman edit.
        return redirect()
            ->route('superadmin.siswa.edit', $siswa->id)
            ->with('password_baru', $passwordBaru);
    }

    public function siswaDestroy($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);

        // Hapus hasil SDQ milik siswa ini secara eksplisit,
        // tidak hanya mengandalkan ON DELETE CASCADE di database.
        HasilSdq::where('user_id', $siswa->id)->delete();

        $siswa->delete();

        return redirect()->route('superadmin.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    // ================= DATA PER KELAS =================

    /**
     * Menandai seluruh siswa dalam satu kelas sebagai lulus.
     *
     * Hanya kelas tingkat 9 yang dapat diproses melalui route.
     * Data hasil SDQ siswa tidak dihapus.
     */
    public function kelasLulus(Request $request, $kode)
    {
        $jumlah = User::where('role', 'siswa')
            ->where('status', 'aktif')
            ->whereRaw('TRIM(kelas) = ?', [trim($kode)])
            ->update([
                'status' => 'lulus',
            ]);

        return redirect()
            ->route('kelas.detail', ['kode' => $kode])
            ->with(
                'success',
                $jumlah . ' siswa dari kelas ' . $kode . ' berhasil ditandai sebagai lulus.'
            );
    }

    // ================= DATA KUESIONER =================

    public function kuesionerIndex(Request $request)
    {
        $request->validate([
            'kelas' => 'nullable|string|max:20',
            'label' => 'nullable|string|max:30',
        ]);

        $query = HasilSdq::query();

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }
        if ($request->filled('label')) {
            $query->where('hasil_label', $request->label);
        }

        $kuesionerList = $query->latest()->paginate(15)->withQueryString();

        return view('superadmin.kuesioner.index', compact('kuesionerList'));
    }

    public function kuesionerDetail($id)
    {
        $hasil = HasilSdq::findOrFail($id);
        return view('superadmin.kuesioner.detail', compact('hasil'));
    }

    public function kuesionerDestroy($id)
    {
        $hasil = HasilSdq::findOrFail($id);
        $hasil->delete();

        return redirect()->route('superadmin.kuesioner.index')->with('success', 'Data kuesioner berhasil dihapus.');
    }

    // ================= PENGATURAN TAMPILAN =================

    public function pengaturanIndex()
    {
        $logo       = Pengaturan::url('logo', 'logo-smpn216.png');
        $logoCustom = (bool) Pengaturan::ambil('logo');
        $maxHero    = self::MAX_HERO;

        $heroes = collect($this->heroPaths())
            ->map(fn ($path) => ['path' => $path, 'url' => Storage::url($path)])
            ->values()
            ->all();

        return view('superadmin.pengaturan.index', compact('logo', 'logoCustom', 'heroes', 'maxHero'));
    }

    public function pengaturanUpdate(Request $request)
    {
        return match ($request->input('section')) {
            'logo'  => $this->updateLogo($request),
            'hero'  => $this->updateHero($request),
            default => redirect()->route('superadmin.pengaturan.index'),
        };
    }

    private function updateLogo(Request $request)
    {
        // Tombol "Hapus Logo Kustom" -> kembali ke logo default
        if ($request->boolean('reset_logo')) {
            $lama = Pengaturan::ambil('logo');
            if ($lama) Storage::disk('public')->delete($lama);
            Pengaturan::simpan('logo', null);

            return redirect()->route('superadmin.pengaturan.index')
                ->with('success', 'Logo dikembalikan ke default.');
        }

        $request->validate([
            'logo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'logo.required' => 'Pilih file logo terlebih dahulu.',
            'logo.image'    => 'File logo harus berupa gambar.',
            'logo.mimes'    => 'Format logo harus JPG, PNG, atau WEBP.',
            'logo.max'      => 'Ukuran logo maksimal 2 MB.',
        ]);

        $lama = Pengaturan::ambil('logo');
        if ($lama) Storage::disk('public')->delete($lama);

        $path = $request->file('logo')->store('pengaturan/logo', 'public');
        Pengaturan::simpan('logo', $path);

        return redirect()->route('superadmin.pengaturan.index')
            ->with('success', 'Logo berhasil disimpan.');
    }

    private function updateHero(Request $request)
    {
        $request->validate([
            'hero_new'   => ['nullable', 'array', 'max:' . self::MAX_HERO],
            'hero_new.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'hero_new.*.image' => 'File gambar beranda harus berupa gambar.',
            'hero_new.*.mimes' => 'Format gambar beranda harus JPG, PNG, atau WEBP.',
            'hero_new.*.max'   => 'Ukuran gambar beranda maksimal 2 MB.',
        ]);

        $paths  = $this->heroPaths();
        $remove = (array) $request->input('remove_hero', []);

        // 1) Hapus gambar yang dicentang
        foreach ($paths as $i => $path) {
            if (in_array($path, $remove, true)) {
                Storage::disk('public')->delete($path);
                unset($paths[$i]);
            }
        }
        $paths = array_values($paths);

        // 2) Tambah gambar baru (dibatasi MAX_HERO)
        foreach ((array) $request->file('hero_new', []) as $file) {
            if (!$file || count($paths) >= self::MAX_HERO) {
                continue;
            }
            $paths[] = $file->store('pengaturan/hero', 'public');
        }

        // 3) Simpan daftar baru. Key lama hero_1..3 dikosongkan (filenya sudah
        //    ikut masuk daftar di atas, jadi tidak dihapus dari storage).
        Pengaturan::simpan('hero_images', count($paths) ? json_encode($paths) : null);
        foreach ([1, 2, 3] as $i) {
            Pengaturan::simpan("hero_$i", null);
        }

        return redirect()->route('superadmin.pengaturan.index')
            ->with('success', 'Gambar beranda berhasil disimpan.');
    }

    /**
     * Daftar path gambar hero yang masih ada di storage.
     * Kalau 'hero_images' belum pernah dibuat, ambil dari key lama hero_1..hero_3.
     */
    private function heroPaths(): array
    {
        $raw = Pengaturan::ambil('hero_images');

        if ($raw) {
            $paths = json_decode($raw, true);
            $paths = is_array($paths) ? $paths : [];
        } else {
            $paths = [];
            foreach ([1, 2, 3] as $i) {
                $p = Pengaturan::ambil("hero_$i");
                if ($p) $paths[] = $p;
            }
        }

        return array_values(array_filter(
            $paths,
            fn ($p) => $p && Storage::disk('public')->exists($p)
        ));
    }
}