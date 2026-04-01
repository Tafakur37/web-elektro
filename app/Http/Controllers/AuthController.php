<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Mail\InlinePasswordResetMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // Menampilkan halaman pilih role
    public function pilihRole($aksi)
    {
        return view('pilih_role', compact('aksi'));
    }

    // Menampilkan Form Login atau Register
    public function showForm($aksi, $role)
    {
        return view('auth_form', compact('aksi', 'role'));
    }

    // Logika Registrasi
    public function register(Request $request)
    {
        $role = $request->role;

        // Validasi Dasar
        $rules = [
            'name' => 'required|string|max:255',
            'identifier' => 'required|numeric|unique:users,identifier',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $identifier = $request->identifier;

        // KHUSUS VALIDASI NIM TEKNIK ELEKTRO (Kadet)
        if ($role === 'kadet') {
            // Format NIM: 3 (1 digit) + YYYY (4 digit tahun masuk) + 0402 (kode prodi) + XXX (3 digit absen) => total 12 digit
            $pattern = '/^3(\d{4})0402(\d{3})$/';
            if (!preg_match($pattern, $identifier, $matches)) {
                return back()->with('error', 'NIM tidak valid. Format: 3YYYY0402XXX (contoh: 320250402023).')->withInput();
            }

            // Ambil tahun masuk dari grup pertama
            $tahunMasuk = (int)$matches[1];
            // Hitung cohort sesuai logika proyek
            $cohort = $tahunMasuk - 2019;
            if ($cohort < 1) {
                return back()->with('error', 'Tahun masuk tidak valid (terlalu lama).')->withInput();
            }
        }

        // Simpan ke Database (nama disimpan uppercase)
        User::create([
            'name' => strtoupper($request->name),
            'identifier' => $identifier,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
        ]);

        return redirect()->route('auth.form', ['aksi' => 'login', 'role' => $role])
                         ->with('success', 'Registrasi Berhasil! Silakan Login.');
    }

    // Logika Login (menerima semua role)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identifier' => 'required',
            'password' => 'required',
        ]);

        // Cek Login menggunakan Identifier (NIM/NIP) dan Password
        if (Auth::attempt(['identifier' => $request->identifier, 'password' => $request->password])) {
            $request->session()->regenerate();
            $user = Auth::user();
            return redirect()->intended('/home')->with('success', "Selamat datang kembali, $user->name!");
        }

        return back()->withErrors([
            'identifier' => 'Username atau password yang anda masukkan mungkin salah'
        ])->withInput();
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // Show form to request password reset
    public function showRequestReset()
    {
        return view('auth_passwords.email');
    }

    // Send reset link email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    // Send inline reset email with embedded form
    public function sendInlineResetEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();
        $token = Password::createToken($user);

        Mail::to($user)->send(new InlinePasswordResetMail($user, $token));

        return back()->with('success', 'Form reset password telah dikirim ke email Anda! Silakan cek inbox.');
    }

    // Show form to reset password (with token)
public function showResetForm(Request $request, $token)
    {
        return view('auth_passwords.reset', [
            'token' => $token,
            'email' => $request->email ?? old('email')
        ]);
    }

    // Reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('auth.form', ['aksi' => 'login', 'role' => 'kadet'])->with('success', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
