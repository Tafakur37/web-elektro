@extends('app')

@section('title', 'Input Nilai - Dosen')

@section('page_title', 'Input Nilai Mahasiswa')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    {{-- STEP 1: Select Cohort --}}
    <div class="bg-white p-8 rounded-xl shadow-lg border">
        <h3 class="text-xl font-bold text-gray-800 mb-6">1. Pilih Cohort</h3>
        <form method="GET" action="{{ route('dosen.nilai.index') }}" class="flex flex-col md:flex-row gap-4">
            <select name="cohort" class="flex-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Pilih Cohort...</option>
                @foreach($cohorts as $c)
                    <option value="{{ $c }}" {{ $cohort == $c ? 'selected' : '' }}>Cohort {{ $c }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 font-bold">
                Lihat Mahasiswa
            </button>
        </form>
    </div>


    @if($cohort)
        {{-- List ALL Mahasiswa Cohort {{ $cohort }} --}}
        <div class="bg-white p-8 rounded-xl shadow-lg border">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Cohort {{ $cohort }} - {{ $kadets->count() }} Mahasiswa</h3>
            
            <div class="overflow-x-auto mb-6">
                <table class="w-full border-collapse bg-gray-50 rounded-lg">
                    <thead>
                        <tr class="text-xs uppercase text-gray-600 bg-gray-100">
                            <th class="p-4 font-bold">Nama</th>
                            <th class="p-4 font-bold">NIM</th>
                            <th class="p-4 font-bold">Input Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kadets as $k)
                            <tr class="border-b hover:bg-white">
                                <td class="p-4 font-medium">{{ $k->name }}</td>
                                <td class="p-4 font-mono text-sm">{{ $k->identifier }}</td>
                                <td class="p-4">
                                    <a href="{{ route('dosen.nilai.form', $k->id) }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 text-sm font-bold">
                                        Input Nilai
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="p-12 text-center text-gray-400">No mahasiswa</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="text-center">
                <a href="{{ route('dosen.nilai.index') }}" class="bg-gray-500 text-white px-8 py-3 rounded-lg hover:bg-gray-600 font-bold">
                    <i class="fas fa-arrow-left mr-2"></i> Ganti Cohort
                </a>
            </div>
        </div>
    @endif


            @if($kadetId)
                {{-- STEP 3: Select Matkul & Existing Nilai --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="font-bold text-lg mb-4">3. Mata Kuliah (yang diajar {{ $user->identifier }})</h4>
                        <form method="GET" action="{{ route('dosen.nilai.form', $kadetId) }}" class="flex gap-4">
                            <input type="hidden" name="cohort" value="{{ $cohort }}">
                            <select name="matkul" class="flex-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Matkul...</option>
                                @foreach($matkuls as $m)
                                    <option value="{{ $m }}" {{ $matkul == $m ? 'selected' : '' }}>{{ $m }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-purple-600 text-white px-8 py-3 rounded-lg hover:bg-purple-700 font-bold">
                                Input Nilai
                            </button>
                        </form>
                    </div>

                    @if($existingNilai)
                        <div class="bg-green-50 p-6 rounded-lg border-l-4 border-green-500">
                            <h4 class="font-bold text-lg mb-2 text-green-800">Nilai Saat Ini</h4>
                            <div class="space-y-1 text-sm">
                                <p><strong>Total:</strong> {{ $existingNilai->total_nilai }} ({{ $existingNilai->grade }})</p>
                                <p><strong>Tugas:</strong> {{ $existingNilai->tugas }}</p>
                                <p><strong>UTS:</strong> {{ $existingNilai->uts }} {{ $existingNilai->remedial_uts ? '(Remedial)' : '' }}</p>
                                <p><strong>UAS:</strong> {{ $existingNilai->uas }} {{ $existingNilai->remedial_uas ? '(Remedial)' : '' }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @endif
</div>
@endsection

