
@extends('app')

@section('title', 'Input Nilai Dosen')

@section('page_title', 'Input Nilai')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-lg mb-8">
    <h3 class="text-lg font-bold text-purple-900 mb-6">
        <i class="fas fa-graduation-cap mr-2"></i>Pilih Cohort Mahasiswa
    </h3>
    <form method="GET" action="{{ route('dosen.nilai.index') }}" class="mb-8">
        <div class="flex gap-4">
            <select name="cohort" class="flex-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                <option value="">Pilih Cohort</option>
@forelse($cohorts ?? [] as $c)
                    <option value="{{ $c }}" {{ request('cohort') == $c ? 'selected' : '' }}>Cohort {{ $c }}</option>
                @empty
                    <option disabled>Tidak ada cohort</option>
                @endforelse
            </select>
            <button type="submit" class="bg-purple-600 text-white px-8 py-3 rounded-lg hover:bg-purple-700 font-bold">
                Filter
            </button>
        </div>
    </form>

    @if(request('cohort'))
    <div class="overflow-x-auto">
        <table class="w-full border-collapse bg-white shadow-md rounded-lg">
            <thead>
                <tr class="bg-gradient-to-r from-purple-500 to-purple-600 text-white">
                    <th class="p-4 text-left font-bold">Absen</th>
                    <th class="p-4 text-left font-bold">Nama</th>
                    <th class="p-4 text-left font-bold">NIM</th>
                    <th class="p-4 text-center font-bold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kadets as $kadet)
                    @php $absen = substr($kadet->identifier, -3); @endphp
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4 font-bold text-purple-900">{{ $absen }}</td>
                        <td class="p-4 font-semibold">{{ $kadet->name }}</td>
                        <td class="p-4 font-mono text-sm">{{ $kadet->identifier }}</td>
                        <td class="p-4 text-center">
                            <a href="{{ route('dosen.nilai.form', $kadet->id) }}" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-semibold">
                                Input Nilai
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-12 text-center text-gray-500">Tidak ada mahasiswa di cohort ini</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif
</div>

@if(isset($notifications))
<div class="bg-white p-6 rounded-xl shadow-lg mb-8">
    <h3 class="text-lg font-bold text-orange-900 mb-4">Notifikasi</h3>
    @foreach($notifications as $notif)
        <div class="flex items-start p-4 mb-4 rounded-lg border-l-4 {{ $notif['type'] == 'warning' ? 'border-yellow-500 bg-yellow-50' : 'border-blue-500 bg-blue-50' }}">
            <i class="fas fa-{{ $notif['type'] == 'warning' ? 'exclamation-triangle' : 'info-circle' }} mt-1 mr-3 text-lg text-{{ $notif['type'] }}-600 flex-shrink-0"></i>
            <div>
                <div class="font-bold">{{ $notif['title'] }}</div>
                <div>{{ $notif['message'] }}</div>
            </div>
        </div>
    @endforeach
</div>
@endif

@endsection

