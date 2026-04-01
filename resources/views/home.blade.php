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
            @for ($s = 1; $s <= 8; $s++)
                <option value="{{ $s }}">Semester {{ $s }}</option>
            @endfor
        </select>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="jadwal-table">
            <thead>
                <tr class="bg-gray-50 text-xs uppercase tracking-widest text-gray-600">
                    <th class="p-4">Hari</th>
                    <th class="p-4">Mata Kuliah</th>
                    <th class="p-4">Dosen</th>
                    <th class="p-4">Jam</th>
                    <th class="p-4">Ruang</th>
                    <th class="p-4">Semester</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwal ?? collect() as $j)
                    <tr class="hover:bg-blue-50 border-b">
                        <td class="p-4 font-bold">{{ $j->hari ?? '-' }}</td>
                        <td class="p-4">{{ $j->mata_kuliah ?? '-' }}</td>
                        <td class="p-4 text-sm">{{ $j->dosen ?? '-' }}</td>
                        <td class="p-4 font-mono">{{ ($j->jam_mulai ?? '00:00')->format('H:i') }} - {{ ($j->jam_selesai ?? '00:00')->format('H:i') }}</td>
                        <td class="p-4 bg-gray-50 px-3 py-1 rounded text-sm">{{ $j->ruang ?? '-' }}</td>
                        <td class="p-4 text-center"><span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs font-bold">S{{ $j->semester ?? 1 }}</span></td>
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
@if($user->role === 'admin' || $user->role === 'staff_prodi' || $user->role === 'sesprodi')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    @if($user->role === 'admin')
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
    @endif
    <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-8 rounded-xl shadow-lg">
        <div class="flex items-center mb-4">
            <div class="p-3 bg-white/20 rounded-xl mr-4">
                @if($user->role === 'staff_prodi') <i class="fas fa-tasks text-2xl"></i>
                @elseif($user->role === 'sesprodi') <i class="fas fa-calendar text-2xl"></i>
                @else <i class="fas fa-clock text-2xl"></i> @endif
            </div>
            <div>
                <p class="text-green-100 text-sm uppercase tracking-wider font-bold">
                    @if($user->role === 'staff_prodi') Tugas Pending @elseif($user->role === 'sesprodi') Agenda @else Aktif Hari Ini @endif
                </p>
                <p class="text-3xl font-bold">{{ $todayActive ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

@if($user->role === 'admin')
<!-- Cohort Grid etc for admin only -->
<div class="bg-white p-6 rounded-xl shadow-lg mb-8">
    <!-- ... admin specific content ... -->
</div>
@endif

<!-- Staff Prodi section -->
@if($user->role === 'staff_prodi')
<div class="bg-white p-6 rounded-xl shadow-lg border-b-4 border-green-500 mb-8">
    <h3 class="text-xl font-bold text-gray-800 mb-6">Staff Prodi Tasks</h3>
    <p>Placeholder for staff prodi specific features (dokumen, laporan staff, etc.)</p>
</div>
@endif

<!-- Sesprodi section -->
@if($user->role === 'sesprodi')
<div class="bg-white p-6 rounded-xl shadow-lg border-b-4 border-purple-500 mb-8">
    <h3 class="text-xl font-bold text-gray-800 mb-6">Sekretaris Prodi Agenda</h3>
    <p>Placeholder for sesprodi specific features (surat, agenda, dokumen resmi)</p>
</div>
@endif
@endif

<!-- Dosen Dashboard - Jadwal Mengajar -->
@if($user->role === 'dosen')
<div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200 mb-8">
    <h2 class="text-2xl font-bold text-blue-900 mb-8">
        <i class="fas fa-calendar-check mr-3 text-green-500"></i>Jadwal Mengajar Anda
    </h2>
    @if($jadwal->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <i class="fas fa-calendar-times text-5xl mb-6"></i>
            <p class="text-xl font-semibold mb-2">Jadwal mengajar belum tersedia</p>
            <p class="text-gray-500">Tambahkan jadwal di menu Jadwal</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-4 font-bold text-left">Mata Kuliah</th>
                        <th class="p-4 font-bold text-left">Hari</th>
                        <th class="p-4 font-bold text-left">Jam</th>
                        <th class="p-4 font-bold text-left">Ruang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwal as $j)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 font-semibold">{{ $j->mata_kuliah }}</td>
                            <td class="p-4">{{ $j->hari }}</td>
                            <td class="p-4 font-mono">{{ ($j->jam_mulai ?? '08:00') ->format('H:i') }} - {{ ($j->jam_selesai ?? '10:00')->format('H:i') }}</td>
                            <td class="p-4 bg-gray-100 px-3 py-2 rounded">{{ $j->ruang }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endif

<!-- Dosen Dashboard - Input Nilai Quick Access -->
@if($user->role === 'dosen')
<div class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white p-10 rounded-3xl shadow-2xl mb-8">
    <div class="text-center">
        <h2 class="text-3xl font-bold mb-4">
            <i class="fas fa-clipboard-list mr-4"></i>Input Nilai Kadet
        </h2>
    </div>
    <div class="flex justify-center">
        <a href="{{ route('dosen.nilai.index') }}" class="bg-white text-purple-700 px-16 py-6 rounded-3xl text-2xl font-black shadow-2xl hover:shadow-3xl hover:bg-gray-100 transition-all duration-300 uppercase tracking-wider">
            <i class="fas fa-plus mr-3"></i> Input Nilai
        </a>
    </div>
</div>
@endif

@if(isset($notifications) && is_array($notifications) && count($notifications) > 0)
<div class="bg-white p-6 rounded-xl shadow-lg">
    <h3 class="text-lg font-bold text-orange-900 mb-4">
        <i class="fas fa-bell mr-2"></i>Notifikasi
    </h3>
    <div class="space-y-3">
        @foreach($notifications as $notif)
            <div class="flex items-start p-3 rounded border-l-4 {{ ($notif['type'] ?? 'info') == 'warning' ? 'border-yellow-500 bg-yellow-50' : 'border-blue-500 bg-blue-50' }}">
                <i class="fas fa-{{ ($notif['type'] ?? 'info') == 'warning' ? 'exclamation-triangle' : 'info-circle' }} text-lg mt-1 mr-3 text-{{ ($notif['type'] ?? 'info') }}-600"></i>
                <div>
                    <div class="font-bold text-sm">{{ $notif['title'] ?? 'Notifikasi' }}</div>
                    <div class="text-xs text-gray-600">{{ $notif['message'] ?? '' }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
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
@forelse($pengumuman ?? collect() as $p)
    <div class="mb-6 p-6 bg-gray-50 rounded-lg border-l-4 border-orange-500">
        <h4 class="font-bold text-lg text-gray-800 mb-2">{{ $p->title ?? '-' }}</h4>
        <p class="text-gray-700">{{ $p->content ?? '' }}</p>
        <p class="text-xs text-gray-500 mt-3">
            {{ $p->creator->name ?? 'Admin' }} • {{ $p->created_at?->format('d M Y') ?? now()->format('d M Y') }}
        </p>
    </div>
@empty
    <div class="text-center p-12 text-gray-400">
        <i class="fas fa-bullhorn text-6xl mb-4 opacity-30"></i>
        <p class="text-lg font-bold">Tidak ada pengumuman</p>
        @if(!in_array($user->role ?? '', ['kadet']))
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

@include('pages.dosen.nilai-input-modal')
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

