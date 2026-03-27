@extends('app')

@section('title', 'Dashboard')

@section('page_title')
Halo, {{ $user->name ?? 'User' }}!
@endsection

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 text-center">
    <div class="bg-white p-6 rounded-xl shadow-md border-b-4 border-blue-500">
        <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest">Status</h3>
        <p class="text-xl font-bold mt-2">Aktif</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-md border-b-4 border-green-500">
        <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest">Cohort</h3>
        <p class="text-xl font-bold mt-2">
            @php $tahun = substr($user->identifier ?? '', 1, 4); @endphp
            {{ is_numeric($tahun) ? 'Cohort ' . ($tahun - 2019) : '-' }}
        </p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-md border-b-4 border-orange-500">
        <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest">Informasi</h3>
        <p class="text-sm text-gray-600 mt-2">Akses menu sidebar untuk fitur lengkap</p>
    </div>
</div>

{{-- KAD ET DASHBOARD --}}
@if($user->role === 'kadet')
<div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 mb-10">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-blue-900">
            <i class="fas fa-calendar-alt mr-2 text-green-500"></i>
            Jadwal Kuliah (Cohort {{ $cohort ?? '-' }})
        </h2>
    </div>
    <div class="mb-6">
        <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Semester:</label>
        <select id="semester-filter" class="w-full md:w-48 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Semester</option>
            @for ($s = 1; $s <= 14; $s++)
                <option value="{{ $s }}">Semester {{ $s }}</option>
            @endfor
        </select>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="jadwal-table">
            <thead>
                <tr class="bg-gray-50 text-xs uppercase tracking-widest text-gray-600">
                    <th class="p-4">Hari</th><th class="p-4">Mata Kuliah</th><th class="p-4">Dosen</th><th class="p-4">Jam</th><th class="p-4">Ruang</th><th class="p-4">Semester</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwal as $j)
                    <tr class="hover:bg-blue-50 border-b">
                        <td class="p-4 font-bold">{{ $j->hari }}</td>
                        <td class="p-4">{{ $j->mata_kuliah }}</td>
                        <td class="p-4 text-sm">{{ $j->dosen }}</td>
                        <td class="p-4 font-mono">{{ $j->jam_mulai->format('H:i') }} - {{ $j->jam_selesai->format('H:i') }}</td>
                        <td class="p-4 bg-gray-50 px-3 py-1 rounded text-sm">{{ $j->ruang }}</td>
                        <td class="p-4 text-center"><span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs font-bold">S{{ $j->semester }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-16 text-center text-gray-400">
                        <i class="fas fa-calendar-times text-4xl mb-4 opacity-50"></i> Jadwal belum tersedia
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- ADMIN DASHBOARD --}}
@if($user->role === 'admin')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white p-8 rounded-xl shadow-lg">
        <div class="flex items-center mb-4">
            <div class="p-3 bg-white/20 rounded-xl mr-4"><i class="fas fa-chalkboard-teacher text-2xl"></i></div>
            <div>
                <p class="text-purple-100 text-sm uppercase tracking-wider font-bold">Total Dosen</p>
                <p class="text-3xl font-bold">{{ $totalDosen }}</p>
            </div>
        </div>
    </div>
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-8 rounded-xl shadow-lg">
        <div class="flex items-center mb-4">
            <div class="p-3 bg-white/20 rounded-xl mr-4"><i class="fas fa-users text-2xl"></i></div>
            <div>
                <p class="text-blue-100 text-sm uppercase tracking-wider font-bold">Total Mahasiswa</p>
                <p class="text-3xl font-bold">{{ $totalMahasiswa }}</p>
            </div>
        </div>
    </div>
    <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-8 rounded-xl shadow-lg">
        <div class="flex items-center mb-4">
            <div class="p-3 bg-white/20 rounded-xl mr-4"><i class="fas fa-clock text-2xl"></i></div>
            <div>
                <p class="text-green-100 text-sm uppercase tracking-wider font-bold">Aktif Hari Ini</p>
                <p class="text-3xl font-bold">{{ $todayActive }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Cohort Grid - CLICKABLE -->
<div class="bg-white p-6 rounded-xl shadow-lg mb-8">
    <h3 class="text-xl font-bold text-gray-800 mb-6">Mahasiswa per Cohort</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @forelse($cohortStats as $cohort => $count)
            <a href="#" onclick="showCohortModal({{ $cohort }})" class="bg-blue-50 p-4 rounded-lg border hover:bg-blue-100 cursor-pointer group">
                <div class="text-2xl font-bold text-blue-900 group-hover:text-blue-700">{{ $count }}</div>
                <div class="text-xs uppercase tracking-wider font-bold text-gray-600">Cohort {{ $cohort }}</div>
            </a>
        @empty
            <div class="col-span-full text-center py-8 text-gray-400 col-span-6">
                Tidak ada data cohort
            </div>
        @endforelse
    </div>
</div>

<!-- Activity Log -->
<div class="bg-white p-6 rounded-xl shadow-lg mb-8">
    <h3 class="text-xl font-bold text-gray-800 mb-6">
        <i class="fas fa-history mr-2 text-blue-500"></i>Log Aktivitas (24 jam)
    </h3>
    <div class="overflow-x-auto">
        <table class="w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr class="text-xs uppercase text-gray-600">
                    <th class="px-6 py-3 text-left">User</th>
                    <th class="px-6 py-3 text-left">Aktivitas</th>
                    <th class="px-6 py-3 text-left">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentActivity as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium">{{ $log->user_name ?? 'System' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $log->activity }}</td>
                        <td class="px-6 py-4 text-sm">{{ $log->created_at->format('H:i d M') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-6 py-12 text-center text-gray-500">Tidak ada aktivitas</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Storage -->
<div class="bg-white p-6 rounded-xl shadow-lg">
    <h3 class="text-xl font-bold text-gray-800 mb-6">
        <i class="fas fa-hdd mr-2 text-green-500"></i>Storage
    </h3>
    <div class="space-y-4">
        <div class="flex justify-between">
            <span class="text-sm font-medium text-gray-700">Total</span>
            <span class="font-bold text-xl">{{ number_format($storageStats['total']/1024/1024,1) }} MB</span>
        </div>
        <div class="flex justify-between">
            <span class="text-sm font-medium text-gray-700">Used</span>
            <span class="font-bold text-lg text-red-600">{{ number_format($storageStats['used']/1024/1024,1) }} MB</span>
        </div>
        <div class="flex justify-between">
            <span class="text-sm font-medium text-gray-700">Free</span>
            <span class="font-bold text-lg text-green-600">{{ number_format($storageStats['free']/1024/1024,1) }} MB</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-gradient-to-r from-red-500 to-yellow-500 h-3 rounded-full" style="width:{{ $storageStats['percent_used'] }}%"></div>
        </div>
        <p class="text-sm text-gray-600">{{ $storageStats['percent_used'] }}% used</p>
    </div>
</div>
@endif

{{-- DOSEN DASHBOARD --}}
@if($user->role === 'dosen')
<div class="bg-white p-6 rounded-xl shadow-lg border-b-4 border-yellow-500 mb-8">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-bold text-yellow-900">
            <i class="fas fa-calendar-check mr-2"></i>Jadwal Mengajar
        </h3>

<a href="{{ route('dosen.jadwal.index') }}" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition mr-2">
    Kelola Jadwal
</a>
<a href="{{ route('dosen.nilai.index') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
    <i class="fas fa-calculator mr-1"></i>Input Nilai
</a>

    </div>

@php 
$hariIndonesia = [
    'Sunday' => 'Minggu', 
    'Monday' => 'Senin', 
    'Tuesday' => 'Selasa', 
    'Wednesday' => 'Rabu', 
    'Thursday' => 'Kamis', 
    'Friday' => 'Jumat', 
    'Saturday' => 'Sabtu'
];
$todaysHari = $hariIndonesia[now()->format('l')] ?? 'Senin'; 
$todayJadwal = collect($jadwal ?? [])->where('hari', $todaysHari)->filter(fn($j) => stripos($j->dosen, $user->identifier) !== false); 
@endphp


    @if($todayJadwal->count() > 0)
        <div class="space-y-2">
            @foreach($todayJadwal->take(3) as $j)
                <div class="flex items-center p-3 bg-gray-50 rounded">
                    <div class="w-16 text-center font-mono font-bold mr-3">{{ $j->jam_mulai->format('H:i') }}</div>
                    <div>
                        <div class="font-bold text-sm">{{ $j->mata_kuliah }}</div>
                        <div class="text-xs text-gray-500">{{ $j->ruang }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8 text-gray-400">
            <i class="fas fa-calendar-times text-3xl mb-3 opacity-50"></i>
            <p class="text-sm">Tidak ada jadwal hari ini</p>
        </div>
    @endif
</div>


@if(isset($notifications) && count($notifications) > 0)

<div class="bg-white p-6 rounded-xl shadow-lg">
    <h3 class="text-lg font-bold text-orange-900 mb-4">
        <i class="fas fa-bell mr-2"></i>Notifikasi
    </h3>
    <div class="space-y-3">
        @foreach($notifications as $notif)
            <div class="flex items-start p-3 rounded border-l-4 {{ $notif['type'] == 'warning' ? 'border-yellow-500 bg-yellow-50' : 'border-blue-500 bg-blue-50' }}">
                <i class="fas fa-{{ $notif['type'] == 'warning' ? 'exclamation-triangle' : 'info-circle' }} text-lg mt-1 mr-3 text-{{ $notif['type'] }}-600"></i>
                <div>
                    <div class="font-bold text-sm">{{ $notif['title'] }}</div>
                    <div class="text-xs text-gray-600">{{ $notif['message'] }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif
@endif

{{-- PENGUMUMAN (NON-ADMIN) --}}
@if(!in_array($user->role, ['admin']))
<div class="bg-white p-8 rounded-xl shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-blue-900">
            <i class="fas fa-bullhorn mr-2 text-orange-500"></i>Pengumuman Prodi
        </h2>
        @if(!in_array($user->role, ['kadet']))
            <a href="/admin/pengumuman" class="bg-orange-900 text-white px-4 py-2 rounded-lg hover:bg-orange-700">
                Kelola
            </a>
        @endif
    </div>
    @forelse($pengumuman ?? [] as $p)
        <div class="mb-6 p-6 bg-gray-50 rounded-lg border-l-4 border-orange-500">
            <h4 class="font-bold text-lg text-gray-800 mb-2">{{ $p->title }}</h4>
            <p class="text-gray-700">{{ $p->content }}</p>
            <p class="text-xs text-gray-500 mt-3">
                {{ $p->creator->name ?? 'Admin' }} • {{ $p->created_at->format('d M Y') }}
            </p>
        </div>
    @empty
        <div class="text-center p-12 text-gray-400">
            <i class="fas fa-bullhorn text-6xl mb-4 opacity-30"></i>
            <p class="text-lg font-bold">Tidak ada pengumuman</p>
            @if(!in_array($user->role, ['kadet']))
                <a href="/admin/pengumuman" class="mt-4 inline-block bg-orange-900 text-white px-6 py-2 rounded-lg hover:bg-orange-700">
                    Tambah Pengumuman
                </a>
            @endif
        </div>
    @endforelse
</div>
@endif

{{-- MODAL COHORT (Admin Only) --}}
<div id="cohort-modal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-4" onclick="hideCohortModal()">
    <div class="bg-white w-full max-w-4xl max-h-[80vh] overflow-y-auto rounded-xl shadow-2xl" onclick="event.stopPropagation()">
        <div class="sticky top-0 bg-white border-b p-6">
            <div class="flex justify-between items-center">
                <h3 id="modal-title" class="text-2xl font-bold">Cohort Detail</h3>
                <button onclick="hideCohortModal()" class="text-gray-500 hover:text-gray-700 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div id="modal-content" class="p-6">
            <div class="text-center py-12 text-gray-400">
                <i class="fas fa-spinner fa-spin text-3xl mb-4"></i>Loading...
            </div>
        </div>
    </div>
</div>

<script>
let currentCohort = 0;
async function showCohortModal(cohort) {
    currentCohort = cohort;
    document.getElementById('cohort-modal').classList.remove('hidden');
    document.getElementById('modal-title').textContent = `Cohort ${cohort} - Mahasiswa`;
    const content = document.getElementById('modal-content');
    content.innerHTML = '<div class="text-center py-12"><i class="fas fa-spinner fa-spin text-3xl mb-4"></i>Loading...</div>';
    
    try {
        const res = await fetch(`/api/cohort/${cohort}`);
        const kadets = await res.json();
        if (kadets.length === 0) {
            content.innerHTML = '<div class="text-center py-12 text-gray-400"><i class="fas fa-users-slash text-4xl mb-4 opacity-50"></i>No data</div>';
            return;
        }
        
        let table = '<div class="overflow-x-auto"><table class="w-full border-collapse"><thead class="bg-gray-50"><tr class="text-xs uppercase text-gray-600"><th class="p-4">Absen</th><th class="p-4">Nama</th><th class="p-4">NIM</th><th class="p-4">Email</th><th class="p-4">Tgl Lahir</th></tr></thead><tbody>';
        kadets.forEach(k => {
            const absen = k.identifier.slice(-3);
            table += `<tr class="hover:bg-gray-50 border-b">
                <td class="p-4 font-bold">${absen}</td>
                <td class="p-4">${k.name}</td>
                <td class="p-4 font-mono text-sm">${k.identifier}</td>
                <td class="p-4 text-sm">${k.email}</td>
                <td class="p-4">${k.tanggal_lahir ? new Date(k.tanggal_lahir).toLocaleDateString('id-ID') : '-'}</td>
            </tr>`;
        });
        table += '</tbody></table></div>';
        content.innerHTML = table;
    } catch(e) {
        content.innerHTML = '<div class="text-center py-12 text-red-400"><i class="fas fa-exclamation text-3xl mb-4"></i>Error</div>';
    }
}

function hideCohortModal() {
    document.getElementById('cohort-modal').classList.add('hidden');
}
</script>

@endsection

