@extends('app')

@section('title', 'Kelola Jadwal Kuliah - Dosen')

@section('page_title', 'Kelola Jadwal Kuliah')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg">
    <!-- Filter Cohort & Semester -->
    <div class="mb-8 p-6 bg-gray-50 rounded-xl border">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Filter Jadwal</h3>
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Cohort</label>
                <select name="cohort" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Cohort</option>
                    @foreach($cohorts as $c)
                        <option value="{{ $c }}" {{ $cohort == $c ? 'selected' : '' }}>Cohort {{ $c }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Semester</label>
                <select name="semester" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Semester</option>
                    @for($s=1; $s<=14; $s++)
                        <option value="{{ $s }}" {{ $semester == $s ? 'selected' : '' }}>S{{ $s }}</option>
                    @endfor
                </select>
            </div>
            <div class="flex items-end space-x-3">
                <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-bold transition">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('dosen.jadwal.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-bold transition">
                    <i class="fas fa-plus mr-2"></i>Tambah
                </a>
            </div>
        </form>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($jadwals->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm">
                <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                    <tr>
                        <th class="p-4 rounded-tl-lg text-sm font-bold uppercase tracking-wider">Hari</th>
                        <th class="p-4 text-sm font-bold uppercase tracking-wider">Mata Kuliah</th>
                        <th class="p-4 text-sm font-bold uppercase tracking-wider">Dosen</th>
                        <th class="p-4 text-sm font-bold uppercase tracking-wider">Jam</th>
                        <th class="p-4 text-sm font-bold uppercase tracking-wider">Ruang</th>
                        <th class="p-4 text-sm font-bold uppercase tracking-wider">Cohort</th>
                        <th class="p-4 rounded-tr-lg text-sm font-bold uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwals as $j)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="p-4 font-bold text-blue-900">{{ $j->hari }}</td>
                            <td class="p-4">{{ $j->mata_kuliah }}</td>
                            <td class="p-4 text-sm">{{ $j->dosen }}</td>
                            <td class="p-4 font-mono">
                                {{ $j->jam_mulai->format('H:i') }} - {{ $j->jam_selesai->format('H:i') }}
                            </td>
                            <td class="p-4 font-mono bg-gray-50 px-3 py-1 rounded text-sm">{{ $j->ruang }}</td>
                            <td class="p-4">
                                @if($j->cohort)
                                    <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded text-xs font-bold">C{{ $j->cohort }}</span>
                                @else
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs font-bold">-</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('dosen.jadwal.edit', $j) }}" class="bg-yellow-500 text-white p-2 rounded hover:bg-yellow-600 transition" title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form action="{{ route('dosen.jadwal.destroy', $j) }}" method="POST" class="inline" onsubmit="return confirm('Hapus jadwal {{ $j->mata_kuliah }}?')">
                                        @csrf @method('DELETE')
                                        <button class="bg-red-500 text-white p-2 rounded hover:bg-red-600 transition" title="Hapus">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex justify-center">
            {{ $jadwals->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <i class="fas fa-calendar-plus text-6xl text-gray-300 mb-6"></i>
            <h3 class="text-2xl font-bold text-gray-500 mb-2">Belum ada jadwal kuliah</h3>
            <p class="text-gray-400 mb-6">Mulai dengan menambahkan jadwal kuliah baru untuk cohort & semester.</p>
            <a href="{{ route('dosen.jadwal.create') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Tambah Jadwal Pertama
            </a>
        </div>
    @endif
</div>

<style>
.table-container {
    max-height: 600px;
    overflow-y: auto;
}
</style>
@endsection

