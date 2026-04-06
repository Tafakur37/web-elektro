<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pengajuan;

class AdminController extends Controller
{
    public function dashboard()
    {
        $metrics = [
            'pending_pengajuan' => Pengajuan::where('status', 'pending')->count(),
        ];

        $user = Auth::user();
        if ($user->identifier !== 'superman' && $user->role !== 'admin') {
            abort(403, 'Admin only');
        }

        return view('pages.admin.dashboard', compact('metrics'));
    }

    public function users(Request $request)
    {
        $user = Auth::user();
        if ($user->identifier !== 'superman' && $user->role !== 'admin') {
            abort(403, 'Admin only');
        }

$cohorts = User::selectRaw('DISTINCT (CAST(SUBSTR(TRIM(LEADING "0" FROM identifier),2,4) AS UNSIGNED) - 2019) as cohort')
                ->whereRaw('identifier REGEXP "^[0-9]{7,}$"')
                ->whereRaw('(CAST(SUBSTR(TRIM(LEADING "0" FROM identifier),2,4) AS UNSIGNED) - 2019) > 0')
                ->pluck('cohort')
                ->filter()
                ->sort()
                ->values()
                ->toArray();

        $query = User::latest();
        
        $role = $request->get('role');
        if ($role == 'kadet' && !$request->get('cohort')) {
            $cohorts = User::where('role', 'kadet')
                ->selectRaw('DISTINCT CAST(SUBSTRING(identifier, 2, 4) AS UNSIGNED) - 2019 as cohort')
                ->pluck('cohort')
                ->filter()
                ->sort()
                ->values()
                ->toArray();
            return view('pages.admin.kelola-kadet-cohort', compact('cohorts'));
        }
        $query = User::latest();
        if ($role) {
            $query->where('role', $role);
        }
        $cohort = $request->get('cohort');
        if ($cohort && $role == 'kadet') {
        $cohort_num = (int)$cohort;
        $query->whereRaw('role = ? AND CAST(SUBSTRING(TRIM(identifier),2,4) AS UNSIGNED) - 2019 = ?', ['kadet', $cohort_num]);
        }
        
        $users = $query->paginate(20);
        $role = $role ?? null;
        $cohort = $cohort ?? null;
        
        return view('pages.admin.users', compact('users', 'role', 'cohorts', 'cohort'));
    }

    public function createUser()
    {
        $user = Auth::user();
        if ($user->identifier !== 'superman' && $user->role !== 'admin') {
            abort(403, 'Admin only');
        }

        $roles = ['admin', 'dosen', 'kadet', 'staff_prodi', 'sesprodi'];
        return view('pages.admin.create-user', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        $user = Auth::user();
        if ($user->identifier !== 'superman' && $user->role !== 'admin') {
            abort(403, 'Admin only');
        }

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
        $authUser = Auth::user();
        if ($authUser->identifier !== 'superman' && $authUser->role !== 'admin') {
            abort(403, 'Admin only');
        }

        $request->validate([
            'password' => 'required|string|min:8',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password direset!');
    }

    public function usersChoose()
    {
        $user = Auth::user();
        if ($user->identifier !== 'superman' && $user->role !== 'admin') {
            abort(403, 'Admin only');
        }

        return view('pages.admin.users-choose');
    }

    public function impersonate(Request $request)
    {
        $user = Auth::user();
        if ($user->identifier !== 'superman' && $user->role !== 'admin') {
            abort(403, 'Admin only');
        }

        $request->validate([
            'impersonate_role' => 'required|string|in:kadet,dosen,staff_prodi,sesprodi',
        ]);

        session(['impersonate_role' => $request->impersonate_role]);

        return redirect()->route('home')->with('success', 'Impersonate ' . $request->impersonate_role);
    }

    public function activityLog()
    {
        $user = Auth::user();
        if ($user->identifier !== 'superman' && $user->role !== 'admin') {
            abort(403, 'Admin only');
        }

        return view('pages.admin.activity-log');
    }
}

