<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Pengajuan;
use App\Models\User;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $cohort = $request->cohort;

        if ($user->role === 'kadet') {
            $pengajuan = Pengajuan::where('user_id', $user->id)
                ->with('staffProdi')
                ->latest()
                ->get();
        } else { // staff_prodi
            $query = Pengajuan::pending()->kadet()->with(['user', 'staffProdi']);
            if ($cohort) {
                $query->whereHas('user', function($q) use ($cohort) {
                    $q->whereRaw('CAST(SUBSTRING(identifier,2,4) AS UNSIGNED) - 2019 = ?', [$cohort]);
                });
            }
            $pengajuan = $query->latest()->paginate(10);
        }

        $cohorts = User::where('role', 'kadet')
            ->selectRaw('DISTINCT (CAST(SUBSTRING(identifier,2,4) AS UNSIGNED) - 2019) as cohort')
            ->pluck('cohort')->filter()->sort()->values();

        if ($user->role === 'kadet') {
            $pengajuan = Pengajuan::where('user_id', $user->id)
                ->with('staffProdi')
                ->latest()
                ->get();
            return view('pages.surat', compact('pengajuan', 'user'));
        } else {
            return view('pages.staff_prodi.pengajuan', compact('pengajuan', 'user', 'cohorts', 'cohort'));
        }
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->role !== 'kadet') abort(403);

        return view('pages.surat.create', compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'kadet') abort(403);

        $validated = $request->validate([
            'type' => 'required|in:pesiar,ib,lwe',
            'alasan' => 'required|string|max:1000',
            'berkas' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // 2MB
        ]);

        $berkasPath = null;
        if ($request->hasFile('berkas')) {
            $berkasPath = $request->file('berkas')->store('berkas', 'public');
        }

        Pengajuan::create([
            'user_id' => $user->id,
            'type' => $validated['type'],
            'alasan' => $validated['alasan'],
            'berkas_path' => $berkasPath,
            'status' => 'pending',
        ]);

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dikirim! Menunggu persetujuan.');
    }

    public function show(Pengajuan $pengajuan)
    {
        $this->authorizePengajuan($pengajuan);

        $pengajuan->load(['user', 'staffProdi']);

        return view('pages.surat.show', compact('pengajuan'));
    }

    public function approve(Request $request, Pengajuan $pengajuan)
    {
        $this->authorizePengajuan($pengajuan);

        $user = Auth::user();
        if ($user->role !== 'staff_prodi') abort(403);

        $validated = $request->validate([
            'catatan' => 'nullable|string|max:500',
            'response_berkas' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'status' => 'approved',
            'staff_prodi_id' => $user->id,
        ];

        if ($request->hasFile('response_berkas')) {
            $data['response_berkas_path'] = $request->file('response_berkas')->store('berkas/response', 'public');
        }

        $pengajuan->update($data);

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan disetujui!');
    }

    public function reject(Request $request, Pengajuan $pengajuan)
    {
        $this->authorizePengajuan($pengajuan);

        $user = Auth::user();
        if ($user->role !== 'staff_prodi') abort(403);

        $validated = $request->validate([
            'catatan' => 'nullable|string|max:500',
            'response_berkas' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'status' => 'rejected',
            'staff_prodi_id' => $user->id,
        ];

        if ($request->hasFile('response_berkas')) {
            $data['response_berkas_path'] = $request->file('response_berkas')->store('berkas/response', 'public');
        }

        $pengajuan->update($data);

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan ditolak.');
    }

    private function authorizePengajuan(Pengajuan $pengajuan)
    {
        $user = Auth::user();
        if ($pengajuan->user_id !== $user->id && $user->role !== 'staff_prodi') {
            abort(403);
        }
    }
}

