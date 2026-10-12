<?php

namespace App\Http\Controllers;

use App\Support\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login_siswa');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return $this->redirectSetelahLogin($request);
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password salah.',
            ])
            ->withInput($request->only('email'));
    }

    public function forgotForm()
    {
        return view('auth.forgot_password');
    }

    public function forgotSend(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        // View memakai session('success') untuk pesan berhasil
        // dan $errors untuk pesan gagal.
        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', $this->pesanReset($status))
            : back()
                ->withErrors(['email' => $this->pesanReset($status)])
                ->withInput($request->only('email'));
    }

    public function resetForm(string $token)
    {
        return view('auth.reset_password', [
            'token' => $token,
            'email' => request('email'),
        ]);
    }

    public function resetSave(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
        ], [
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', $this->pesanReset($status))
            : back()
                ->withErrors(['email' => $this->pesanReset($status)])
                ->withInput($request->only('email'));
    }

    public function loginGuruForm()
    {
        return view('auth.login_guru');
    }

    public function loginGuru(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // Form ini khusus guru/admin. Siswa ditolak.
            if (!in_array(Auth::user()->role, ['admin', 'super_admin'], true)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withErrors(['email' => 'Akun ini bukan akun guru.'])
                    ->withInput($request->only('email'));
            }

            $request->session()->regenerate();

            return $this->redirectSetelahLogin($request);
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password salah.',
            ])
            ->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function registerForm()
    {
        return view('auth.register_siswa');
    }

    public function register(Request $request)
    {
        // 'tahun_ajaran' dan 'angkatan' sengaja tidak diambil dari input:
        // - tahun_ajaran = tahun ajaran berjalan, SAMA untuk semua kelas
        // - angkatan     = tahun masuk, dihitung dari tingkat kelas
        //                  (kelas 7 = tahun ini, 8 = -1, 9 = -2)
        $request->validate([
            'nama'          => 'required|string|max:255',
            'nis'           => 'required|string|max:20|unique:users,nis',
            'kelas'         => ['required', 'string', 'max:50', 'regex:/^[7-9]-\d{1,2}$/'],
            'jenis_kelamin' => 'required|in:L,P',
            'no_telp'       => 'required|string|max:20',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6|confirmed',
        ], [
            'nis.required'       => 'NIS wajib diisi.',
            'nis.unique'         => 'NIS ini sudah terdaftar.',
            'no_telp.required'   => 'Nomor telepon wajib diisi.',
            'email.unique'       => 'Email ini sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 6 karakter.',
        ]);

        $user = User::create([
            'name'          => $request->nama,
            'nis'           => $request->nis,
            'kelas'         => $request->kelas,
            'tahun_ajaran'  => TahunAjaran::sekarang(),
            'angkatan'      => TahunAjaran::angkatanDariKelas($request->kelas),
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telp'       => $request->no_telp,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'role'          => 'siswa',
            'status'        => 'aktif',
        ]);

        try {
            event(new Registered($user));
        } catch (\Throwable $e) {
            // Jika email verification gagal dikirim,
            // proses registrasi tetap dilanjutkan.
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('verification.notice');
    }

    /**
     * Menampilkan halaman verifikasi email.
     */
    public function verificationNotice()
    {
        return view('auth.verify_email');
    }

    /**
     * Mengirim ulang tautan verifikasi email.
     */
    public function verificationSend(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->hasVerifiedEmail()) {
            return $this->redirectSetelahLogin($request)
                ->with('success', 'Email kamu sudah terverifikasi.');
        }

        try {
            $user->sendEmailVerificationNotification();

            return back()->with(
                'success',
                'Tautan verifikasi berhasil dikirim ulang. Periksa inbox atau folder spam.'
            );
        } catch (\Throwable $e) {
            return back()->withErrors([
                'email' => 'Tautan verifikasi gagal dikirim. Silakan coba lagi.',
            ]);
        }
    }

    /**
     * Memproses tautan verifikasi email.
     *
     * Tidak perlu login. Keamanan dijaga oleh middleware "signed"
     * di rute dan pencocokan hash email di bawah ini.
     */
    public function verificationVerify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals(sha1($user->getEmailForVerification()), (string) $hash)) {
            abort(403);
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        // Jika tautan dibuka di browser yang sama dengan akun ini, keluarkan dulu
        // supaya halaman login tidak melempar langsung ke dashboard.
        if (Auth::check() && (int) Auth::id() === (int) $user->id) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('verification.done');
    }

    /**
     * Halaman singkat setelah tautan di email dibuka.
     */
    public function verificationDone()
    {
        return view('auth.verified');
    }

    /**
     * Dicek berkala oleh halaman "Periksa emailmu" untuk tahu apakah
     * tautan di email sudah dibuka.
     */
    public function verificationStatus($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'verified' => $user->hasVerifiedEmail(),
        ]);
    }

    /**
     * Membuat URL verifikasi email untuk akun yang sedang login.
     */
    public function verificationUrl(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->hasVerifiedEmail()) {
            return $this->redirectSetelahLogin($request);
        }

        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id'   => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        return redirect()->away($url);
    }

    /**
     * Arahkan user ke halaman yang sesuai rolenya setelah login.
     *
     * - super_admin : selalu ke panel Super Admin.
     * - admin       : dashboard Guru BK.
     * - siswa       : dashboard siswa.
     */
    protected function redirectSetelahLogin(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/');
        }

        if ($user->role === 'super_admin') {
            $request->session()->forget('url.intended');

            return redirect()->route('superadmin.dashboard');
        }

        if ($user->role === 'admin') {
            return redirect()->intended('/dashboard');
        }

        return redirect()->intended('/dashboard-siswa');
    }

    /**
     * Pesan berbahasa Indonesia untuk status reset password.
     */
    protected function pesanReset(string $status): string
    {
        return match ($status) {
            Password::RESET_LINK_SENT => 'Tautan atur ulang password sudah dikirim ke emailmu. Cek inbox atau folder spam.',
            Password::PASSWORD_RESET  => 'Password berhasil diubah. Silakan masuk dengan password barumu.',
            Password::INVALID_USER    => 'Email tidak terdaftar.',
            Password::INVALID_TOKEN   => 'Tautan sudah kedaluwarsa atau tidak valid. Silakan minta tautan baru.',
            Password::RESET_THROTTLED => 'Terlalu sering mencoba. Tunggu sebentar lalu coba lagi.',
            default                   => 'Terjadi kesalahan. Silakan coba lagi.',
        };
    }
}