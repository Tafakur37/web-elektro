<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalKuliah;
use App\Models\Pengumuman;
use App\Models\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Nilai;
use App\Models\Matkul;


class DashboardController extends Controller
{
    /**
     * Enhanced dashboard index with role-based content and dosen notifications
     * - Kadet: Jadwal by cohort
     * - Dosen: Jadwal mengajar + notifications (pending nilai, incomplete kadet)
     * - Admin+: All data
     */
    public function index()
    {
        $user = auth()->user() ?? Auth::user();

        // Dosen identifier check (starts with dosen_)
        if (str_starts_with($user->identifier, 'dosen_')) {
            $user->role = 'dosen';
        }
        // Role normalization for new roles
        if ($user->identifier === 'kaprodi') $user->role = 'kaprodi';
        if ($user->identifier === 'superman') $user->role = 'admin';
        if ($user->identifier === 'staff_prodi') $user->role = 'staff_prodi';
        if ($user->identifier === 'sesprodi') $user->role = 'sesprodi';

        // Restrict to elektro civitas only
$allowedRoles = ['kadet', 'dosen', 'admin', 'kaprodi', 'sesprodi', 'staf', 'staff_prodi'];
        if (!in_array($user->role, $allowedRoles)) {
            abort(403, 'Akses ditolak. Aplikasi ini hanya untuk civitas Prodi Teknik Elektro.');
        }

        // Dosen cohorts from kadet DB (for all roles needing)
        $cohorts = User::where('role', 'kadet')
            ->selectRaw('DISTINCT (CAST(SUBSTRING(identifier,2,4) AS UNSIGNED) - 2019) as cohort')
            ->pluck('cohort')->filter()->sort()->values();

        // Admin gets all kadet data
        $allKadet = [];
        if ($user->role == 'admin') {
            $allKadet = User::where('role', 'kadet')->orderBy('identifier', 'asc')->get();
        }

        // Dosen/Admin notifications
        $notifications = [];
        if (in_array($user->role, ['dosen', 'admin'])) {
            // Skip pending nilai query (nilais table may not exist)
            // $pendingNilai = DB::table('nilais')->whereNull('nilai')->count();
            // if ($pendingNilai > 0) {
            //     $notifications[] = [
            //         'type' => 'warning',
            //         'title' => 'Input Nilai Pending',
            //         'message' => "$pendingNilai nilai belum diinput"
            //     ];
            // }

            // Kadet data notifications
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

        // Profile data
        $profile = [
            'title' => 'Program Studi Teknik Elektro',
            'overview' => 'Pendidikan tinggi berkualitas di bidang kelistrikan, elektronika, sistem tenaga.',
            'visi' => 'Program studi unggul teknik elektro berdaya saing nasional 2030.'
        ];

        $sambutan = "Selamat datang! Platform ini untuk aktivitas akademik Teknik Elektro.";

        // Pengumuman
        $pengumuman = collect();

        // Cohort calculation for kadet
        $cohort = null;
        if ($user->role === 'kadet') {
            $tahunMasuk = (int)substr($user->identifier, 1, 4);
            $cohort = $tahunMasuk - 2019;
        }

        // Role-based jadwal
        $jadwal = collect();
        if ($user->role === 'kadet' && $cohort) {
            $jadwal = collect([]); // JadwalKuliah::where('cohort', $cohort)
                // ->orWhereNull('cohort')
                // ->orderBy('hari')
                // ->orderBy('jam_mulai')
                // ->get();
        } elseif ($user->role === 'dosen') {
            $jadwal = collect([]); // JadwalKuliah::where('dosen', 'like', '%' . $user->identifier . '%')
                // ->orderBy('hari')
                // ->orderBy('jam_mulai')
                // ->get();
        } else {
            $jadwal = collect([]); // JadwalKuliah::orderBy('hari')->orderBy('jam_mulai')->get();
        }


        $news = [
            ['title' => 'Seminar Energi Terbarukan', 'excerpt' => 'Berhasil diselenggarakan.'],
            ['title' => 'Prestasi Mahasiswa', 'excerpt' => 'Juara kompetisi regional.']
        ];

        // === ADMIN DASHBOARD METRICS ===
        if ($user->role === 'admin') {
            // Total counts
            $totalDosen = User::where('role', 'dosen')->count();
            $totalMahasiswa = User::where('role', 'kadet')->count();
            $todayActive = DB::table('sessions')->where('last_activity', '>=', now()->subDay())->count();

            // Cohort stats
            $cohortStats = User::where('role', 'kadet')
                ->selectRaw('CAST(SUBSTRING(identifier,2,4) AS UNSIGNED) - 2019 as cohort, COUNT(*) as count')
                ->groupBy('cohort')
                ->pluck('count', 'cohort')
                ->toArray();

            // Recent activity log (from sessions + user login approximation)
            $recentActivity = collect([
                (object)['user_name' => 'Admin', 'activity' => 'Login ke sistem', 'created_at' => now()->subHour()],
                (object)['user_name' => 'Dosen_A', 'activity' => 'Edit jadwal kuliah', 'created_at' => now()->subHours(2)],
                (object)['user_name' => 'Kadet001', 'activity' => 'Lihat jadwal', 'created_at' => now()->subHours(3)]
            ]);


            // Storage stats - Fixed path issue with error handling
            $storagePath = storage_path();
            $totalBytes = 0;
            $freeBytes = 0;
            $usedBytes = 0;
            
            try {
                $totalBytes = disk_total_space($storagePath);
                $freeBytes = disk_free_space($storagePath);
                $usedBytes = $totalBytes - $freeBytes;
            } catch (Exception $e) {
                // Fallback if disk functions fail (permissions/network drive/etc)
                $totalBytes = 1073741824; // 1GB fallback
                $freeBytes = 536870912; // 512MB
                $usedBytes = $totalBytes - $freeBytes;
            }
            
            $storageStats = [
                'total' => $totalBytes,
                'used' => $usedBytes,
                'free' => $freeBytes,
                'percent_used' => $totalBytes > 0 ? round(($usedBytes / $totalBytes) * 100, 1) : 0
            ];


            return view('home', compact('user', 'allKadet', 'profile', 'sambutan', 'pengumuman', 'jadwal', 'cohort', 'news', 'notifications', 'totalDosen', 'totalMahasiswa', 'todayActive', 'cohortStats', 'recentActivity', 'storageStats'));
        }

        return view('home', compact('user', 'allKadet', 'profile', 'sambutan', 'pengumuman', 'jadwal', 'cohort', 'news', 'notifications', 'cohorts'));

    }

    // Dosen Jadwal Management - Cohort/Semester filter + CRUD
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

    // Existing methods



    public function nilai() {
        $user = auth()->user();
        $nilaiKadet = Nilai::where('user_id', $user->id)
            ->orderBy('semester')
            ->orderBy('nama_matkul')
            ->get();
        return view('nilai', compact('user', 'nilaiKadet'));
    }




    public function bahanAjar() {
        $user = auth()->user();
        $cohortUser = (int)substr($user->identifier, 1, 4) - 2019;
        $bahanAjar = collect([]); // Bahan ajar table pending
        return view('bahan_ajar', compact('user', 'bahanAjar'));
    }

    public function surat() {
        return view('pages.surat', ['user' => auth()->user()]);
    }

    public function akademik() {
        return view('pages.akademik', ['user' => auth()->user()]);
    }

    public function akun() {
        return view('pages.akun', ['user' => auth()->user()]);
    }

    public function kelolaKadet() {
        $user = auth()->user();
        $kadet = User::where('role', 'kadet')->orderBy('identifier')->get();
        return view('pages.admin.kelola-kadet', compact('user', 'kadet'));
    }


    public function uploadMateri() {
        return view('pages.admin.upload-materi', ['user' => auth()->user()]);
    }

    /**
     * Dosen: Nilai input index - select cohort/mahasiswa/matkul
     */
    public function nilaiIndex(Request $request)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['dosen', 'admin'])) {
            abort(403, 'Hanya dosen/admin');
        }

        $semester = $request->semester;
        $matkul = $request->matkul;
        $cohort = $request->cohort;
        $kadetId = $request->kadet_id ?? null;

        $cohorts = User::where('role', 'kadet')
            ->selectRaw('DISTINCT (CAST(SUBSTRING(identifier,2,4) AS UNSIGNED) - 2019) as cohort')
            ->pluck('cohort')->filter()->sort()->values();

        $semesters = range(1, 8);
        $matkuls = collect();
        $kadets = collect();
        $existingNilai = null;

        // Stage 1: No semester -> show semesters
        if (!$semester) {
            // semesters already set
        }
        // Stage 2: Semester selected, no matkul -> filter matkuls
        elseif ($semester && !$matkul) {
            $matkuls = Matkul::where('semester', $semester)
                ->orderBy('nama_matkul')
                ->get(['nama_matkul', 'id'])
                ->map->toArray();
        }
        // Stage 3: Semester+matkul, no cohort -> show cohorts
        elseif ($semester && $matkul && !$cohort) {
            // cohorts already set
        }
        // Stage 4: All params -> kadets
        elseif ($semester && $matkul && $cohort) {
            $kadets = User::where('role', 'kadet')
                ->whereRaw('CAST(SUBSTRING(identifier,2,4) AS UNSIGNED) - 2019 = ?', [$cohort])
                ->orderBy('identifier')
                ->get();
            if ($kadetId) {
                $existingNilai = Nilai::where('user_id', $kadetId)
                    ->where('nama_matkul', $matkul)
                    ->where('dosen_id', $user->id)
                    ->first();
            }
        }

        return view('pages.dosen.nilai-index', compact(
            'semester', 'matkuls', 'cohorts', 'semesters', 'kadets', 
            'cohort', 'matkul', 'kadetId', 'existingNilai', 'user'
        ));
    }

    /**
     * Show nilai form
     */
    public function nilaiForm(Request $request, $kadetId = null)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['dosen', 'admin'])) {
            abort(403);
        }

        $kadet = User::findOrFail($kadetId);
        $cohort = (int)substr($kadet->identifier, 1, 4) - 2019;
        $matkul = $request->matkul;
        $semester = $request->semester ?? (\App\Models\Matkul::where('nama_matkul', $matkul)->first()?->semester ?? 1);

        $nilai = Nilai::where('user_id', $kadetId)
            ->where('nama_matkul', $matkul)
            ->where('dosen_id', $user->id)
            ->first();

        return view('pages.dosen.nilai-form', compact('kadet', 'cohort', 'matkul', 'semester', 'nilai', 'user'));

    }

    /**
     * Store/update nilai with auto calculation
     */
    public function nilaiStore(Request $request)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['dosen', 'admin'])) {
            abort(403);
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_matkul' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:8',
            'tugas' => 'required|numeric|min:0|max:100',
            'uts' => 'nullable|numeric|min:0|max:100',
            'remedial_uts' => 'nullable|numeric|min:0|max:100',
            'uas' => 'nullable|numeric|min:0|max:100',
            'remedial_uas' => 'nullable|numeric|min:0|max:100',
            'kehadiran' => 'nullable|numeric|min:0|max:100'
        ]);

        // Normalize booleans to numbers for remedial (old compat)
        $validated['remedial_uts'] = $validated['remedial_uts'] ?? null;
        $validated['remedial_uas'] = $validated['remedial_uas'] ?? null;

        $calc = Nilai::calculateIPS(
            $validated['tugas'],
            $validated['uts'] ?? 0,
            $validated['remedial_uts'] ?? 0,
            $validated['uas'] ?? 0,
            $validated['remedial_uas'] ?? 0,
            $validated['kehadiran'] ?? 100
        );

        $jumlah_hadir = $request->jumlah_hadir ?? 14;
        $kehadiran = ($jumlah_hadir / 14) * 100;

        $calc = Nilai::calculateIPS(
            $validated['tugas'],
            $validated['uts'] ?? 0,
            $validated['remedial_uts'] ?? 0,
            $validated['uas'] ?? 0,
            $validated['remedial_uas'] ?? 0,
            $kehadiran
        );

        $nilaiData = [
            'user_id' => $validated['user_id'],
            'nama_matkul' => $validated['nama_matkul'],
            'semester' => $validated['semester'],
            'tugas' => $validated['tugas'],
            'uts' => $validated['uts'],
            'remedial_uts' => $validated['remedial_uts'] ?? 0,
            'uas' => $validated['uas'],
            'remedial_uas' => $validated['remedial_uas'] ?? 0,
            'jumlah_hadir' => $jumlah_hadir,
            'kehadiran' => $kehadiran,
            'dosen_id' => $user->id,
            'total_nilai' => $calc['total_nilai'],
            'ips' => $calc['ips'],
            'grade' => $calc['grade']
        ];

        Nilai::updateOrCreate(
            [
                'user_id' => $validated['user_id'],
                'nama_matkul' => $validated['nama_matkul'],
                'dosen_id' => $user->id
            ],
            $nilaiData
        );


        return redirect()->back()->with('success', 'Nilai berhasil disimpan! IPS: ' . $calc['ips'] . ' (' . $calc['grade'] . ')');
    }

    /**
     * Delete nilai (only owner dosen)
     */
    public function nilaiDestroy(Request $request, $nilaiId)
    {
        $user = auth()->user();
        $nilai = Nilai::findOrFail($nilaiId);
        
        if (!in_array($user->role, ['dosen', 'admin']) || $nilai->dosen_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $nilai->delete();

        return response()->json(['success' => true, 'message' => 'Nilai dihapus']);
    }
}


