<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pengajuan;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if ($user->identifier !== 'superman' && $user->role !== 'admin') {
                abort(403, 'Admin only');
            }
            return $next($request);
        });
    }

    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('pages.admin.users', compact('users'));
    }

    public function createUser()
    {
        $roles = ['admin', 'dosen', 'kadet', 'staff_prodi', 'sesprodi'];
        return view('pages.admin.create-user', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'identifier' => 'required|string|max:50|unique:users',
            'email' => 'nullable|email',
            'role' => 'required|in:admin,dosen,kadet,staff_prodi,sesprodi',
            'password' => 'required|string|min:8',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
        ]);

        User::create($validated);

        return redirect()->route('admin.users')->with('success', 'User dibuat!');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password direset!');
    }

    public function impersonate(Request $request)
    {
        $request->validate([
            'impersonate_role' => 'required|string|in:kadet,dosen,staff_prodi,sesprodi',
        ]);

        session(['impersonate_role' => $request->impersonate_role]);

        return redirect()->route('home')->with('success', 'Impersonate ' . $request->impersonate_role);
    }
}

