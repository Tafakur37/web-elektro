<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalKuliah;
use App\Models\Pengumuman;
use App\Models\User;
use App\Models\Nilai;
use App\Models\Matkul;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user() ?? Auth::user();

        if (str_starts_with($user->identifier, 'dosen_')) {
            $user->role = 'dosen';
        }
        if ($user->identifier === 'kaprodi') $user->role = 'kaprodi';
        if ($user->identifier === 'superman') $user->role = 'admin';
        if ($user->identifier === 'staff_prodi') $user->role = 'staff_prodi';
        if ($user->identifier === 'sesprodi') $user->role = 'sesprodi';

        $allowedRoles = ['kadet', 'dosen', 'admin', 'kaprodi', 'sesprodi', 'staf', 'staff_prodi'];
        if (!in_array($user->role, $allowedRoles)) {
            abort(403, 'Akses ditolak. Aplikasi ini hanya untuk civitas Prodi Teknik Elektro.');
        }

        $cohorts = User::where('role', 'kadet')
            ->selectRaw('DISTINCT (CAST(SUBSTRING(identifier,2,4) AS UNSIGNED) - 2019) as cohort')
            ->pluck('cohort')->filter()->sort()->values();

        $allKadet = $user->role == 'admin' ? User::where('role', 'kadet')->orderBy('identifier', 'asc')->get() : collect();

        $notifications = [];
        if (in_array($user->role, ['dosen', 'admin'])) {
            $incompleteKadet = User::where('role', 'kadet')
                ->where(function($q) {
                    $q->whereNull('tempat_lahir')->orWhereNull('tanggal_lahir');
                })->count();
            if ($incompleteKadet > 0) {
                $notifications[] = [
                    'type' => 'info',
                    'title' => 'Data Kadet',
                    'message' => "$incompleteKadet kadet perlu melengkapi profil"
                ];
            }
        }

        $profile = [
            'title' => 'Program Studi Teknik Elektro',
            'overview' => 'Pendidikan tinggi berkualitas di bidang kelistrikan, elektronika, sistem tenaga.',
            'visi' => 'Program studi unggul teknik elektro berdaya saing nasional 2030.'
        ];

        $sambutan = "Selamat datang! Platform ini untuk aktivitas akademik Teknik Elektro.";

        $pengumuman = collect();

        $cohort = null;
        if ($user->role === 'kadet') {
            $tahunMasuk = (int)substr($user->identifier, 1, 4);
            $cohort = $tahunMasuk - 2019;
        }

        $jadwal = collect();

        $news = [
            ['title' => 'Seminar Energi Terbarukan', 'excerpt' => 'Berhasil diselenggarakan.'],
            ['title' => 'Prestasi Mahasiswa', 'excerpt' => 'Juara kompetisi regional.']
        ];

        $isAdmin = ($user->role === 'admin' || $user->identifier === 'superman');
        $totalDosen = $isAdmin ? User::where('role', 'dosen')->count() : 0;
        $totalMahasiswa = $isAdmin ? User::where('role', 'kadet')->count() : 0;
        $totalStaff = $isAdmin ? User::whereIn('role', ['staff_prodi', 'sesprodi'])->count() : 0;
        $cohortStats = $isAdmin ? User::where('role', 'kadet')
            ->selectRaw('CAST(SUBSTRING(identifier,2,4) AS UNSIGNED) - 2019 as cohort, COUNT(*) as count')
            ->groupBy('cohort')
            ->pluck('count', 'cohort')
            ->toArray() : [];
        $recentLog = $isAdmin ? User::latest('updated_at')->take(10)->get(['name', 'updated_at']) : collect();

        $todayActive = DB::table('sessions')->where('last_activity', '>=', now()->subDay())->count();

        $recentActivity = collect([
            (object)['user_name' => 'Admin', 'activity' => 'Login ke sistem', 'created_at' => now()->subHour()],
            (object)['user_name' => 'Dosen_A', 'activity' => 'Edit jadwal kuliah', 'created_at' => now()->subHours(2)],
            (object)['user_name' => 'Kadet001', 'activity' => 'Lihat jadwal', 'created_at' => now()->subHours(3)]
        ]);

        $storagePath = storage_path();
        $totalBytes = disk_total_space($storagePath);
        $freeBytes = disk_free_space($storagePath);
        $usedBytes = $totalBytes - $freeBytes;
        $storageStats = [
            'total' => $totalBytes,
            'used' => $usedBytes,
            'free' => $freeBytes,
            'percent_used' => $totalBytes > 0 ? round(($usedBytes / $totalBytes) * 100, 1) : 0
        ];

        $viewVars = [
            'user' => $user,
            'allKadet' => $allKadet,
            'profile' => $profile,
            'sambutan' => $sambutan,
            'pengumuman' => $pengumuman,
            'jadwal' => $jadwal,
            'cohort' => $cohort,
            'news' => $news,
            'notifications' => $notifications,
            'cohorts' => $cohorts,
            'totalDosen' => $totalDosen,
            'totalMahasiswa' => $totalMahasiswa,
            'todayActive' => $todayActive,
            'cohortStats' => $cohortStats,
            'recentActivity' => $recentActivity,
            'storageStats' => $storageStats,
            'totalStaff' => $totalStaff,
            'recentLog' => $recentLog
        ];

        return view('home', $viewVars);
    }

    public function jadwalIndex(Request $request)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['dosen', 'admin'])) abort(403);

        $cohort = $request->cohort;
        $semester = $request->semester;

        $query = JadwalKuliah::query();
        if ($cohort) $query->where('cohort', $cohort);
        if ($semester) $query->where('semester', $semester);

        $jadwals = $query->orderBy('hari')->orderBy('jam_mulai')->paginate(10);

        $cohorts = User::where('role', 'kadet')
            ->selectRaw('DISTINCT (CAST(SUBSTRING(identifier,2,4) AS UNSIGNED) - 2019) as cohort')
            ->pluck('cohort')->filter()->sort()->values();

        return view('pages.dosen.jadwal-index', compact('jadwals', 'cohorts', 'cohort', 'semester', 'user'));
    }

    public function jadwalCreate()
    {
        $user = auth()->user();
        if (!in_array($user->role, ['dosen', 'admin'])) abort(403);

        $cohorts = User::where('role', 'kadet')
            ->selectRaw('DISTINCT (CAST(SUBSTRING(identifier,2,4) AS UNSIGNED) - 2019) as cohort')
            ->pluck('cohort')->filter()->sort()->values();
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return view('pages.dosen.jadwal-form', compact('cohorts', 'hari', 'user'));
    }

    public function jadwalStore(Request $request)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['dosen', 'admin'])) abort(403);

        $validated = $request->validate([
            'semester' => 'required|integer|between:1,14',
            'mata_kuliah' => 'required|string|max:255',
            'dosen' => 'required|string|max:255',
            'hari' => 'required|string|max:20',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruang' => 'required|string|max:50',
            'cohort' => 'nullable|integer|min:1|max:20'
        ]);

        JadwalKuliah::create($validated);

        return redirect()->route('dosen.jadwal.index')->with('success', 'Jadwal ditambahkan!');
    }

    public function jadwalEdit(JadwalKuliah $jadwal)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['dosen', 'admin'])) abort(403);

        $cohorts = User::where('role', 'kadet')
            ->selectRaw('DISTINCT (CAST(SUBSTRING(identifier,2,4) AS UNSIGNED) - 2019) as cohort')
            ->pluck('cohort')->filter()->sort()->values();
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return view('pages.dosen.jadwal-form', compact('jadwal', 'cohorts', 'hari', 'user'));
    }

    public function jadwalUpdate(Request $request, JadwalKuliah $jadwal)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['dosen', 'admin'])) abort(403);

        $validated = $request->validate([
            'semester' => 'required|integer|between:1,14',
            'mata_kuliah' => 'required|string|max:255',
            'dosen' => 'required|string|max:255',
            'hari' => 'required|string|max:20',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruang' => 'required|string|max:50',
            'cohort' => 'nullable|integer|min:1|max:20'
        ]);

        $jadwal->update($validated);

        return redirect()->route('dosen.jadwal.index')->with('success', 'Jadwal diupdate!');
    }

    public function jadwalDestroy(JadwalKuliah $jadwal)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['dosen', 'admin'])) abort(403);

        $jadwal->delete();

        return redirect()->route('dosen.jadwal.index')->with('success', 'Jadwal dihapus!');
    }

    public function nilai()
    {
        $user = auth()->user();
        $nilaiKadet = Nilai::where('user_id', $user->id)
            ->orderBy('semester')
            ->orderBy('nama_matkul')
            ->get();
        return view('nilai', compact('user', 'nilaiKadet'));
    }

    public function bahanAjar()
    {
        $user = auth()->user();
        $cohortUser = (int)substr($user->identifier, 1, 4) - 2019;
        $bahanAjar = collect();
        return view('bahan_ajar', compact('user', 'bahanAjar'));
    }

    public function surat()
    {
        return view('pages.surat', ['user' => auth()->user()]);
    }

    public function akademik()
    {
        return view('pages.akademik', ['user' => auth()->user()]);
    }

    public function akun()
    {
        return view('pages.akun', ['user' => auth()->user()]);
    }

    public function kelolaKadet()
    {
        $user = auth()->user();
        if ($user->identifier !== 'superman' && $user->role !== 'admin') {
            abort(403, 'Admin only');
        }
        return view('pages.admin.users-choose');
    }

    public function uploadMateri()
    {
        return view('pages.admin.upload-materi', ['user' => auth()->user()]);
    }

    public function staffProdiIndex()
    {
        $user = auth()->user();
        if ($user->role !== 'staff_prodi') abort(403);

        $stats = [
            'pending_pengajuan' => Pengajuan::where('status', 'pending')->whereHas('user', fn($q) => $q->where('role', 'kadet'))->count(),
            'total_pengajuan' => Pengajuan::whereHas('user', fn($q) => $q->where('role', 'kadet'))->count(),
        ];

        return view('pages.staff_prodi.index', compact('user', 'stats'));
    }

    public function sesprodiIndex()
    {
        $user = auth()->user();
        return view('pages.sesprodi.index', ['user' => $user]);
    }
}

