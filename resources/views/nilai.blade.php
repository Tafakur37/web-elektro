@extends('app')

@section('title', 'Nilai Akademik')
@section('page_title', 'Transkrip Nilai Kadet')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-green-600">
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-800">Capaian Hasil Belajar</h2>
        <p class="text-sm text-gray-400">Data nilai ini diinput secara resmi oleh Dosen dan Kaprodi. Dikelompokkan berdasarkan semester.</p>
    </div>

    @if($nilaiKadet->isEmpty())
        <div class="text-center py-20">
            <i class="fas fa-graduation-cap text-6xl text-gray-300 mb-6"></i>
            <h3 class="text-2xl font-bold text-gray-500 mb-2">Belum ada data nilai</h3>
            <p class="text-gray-400">Nilai akan muncul setelah Dosen menginput dan approve.</p>
        </div>
    @else
        @php $nilaiBySemester = $nilaiKadet->groupBy('semester')->sortKeys(); @endphp
        
        @foreach($nilaiBySemester as $semester => $nilais)
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 bg-gray-50 px-6 py-4 rounded-lg">
                    <i class="fas fa-calendar-alt mr-3 text-blue-500"></i>
                    Semester {{ $semester }} 
                    <span class="text-sm font-normal text-gray-500 ml-2">({{ $nilais->count() }} mata kuliah)</span>
                </h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse bg-white rounded-xl shadow-sm">
                        <thead>
                            <tr class="bg-gradient-to-r from-green-50 to-blue-50 text-xs uppercase tracking-widest text-gray-600">
                                <th class="p-4 rounded-tl-lg border-b font-bold">Mata Kuliah</th>
                                <th class="p-4 border-b text-center font-bold">Tugas<br><span class="text-xs text-gray-500">(20%)</span></th>
                                <th class="p-4 border-b text-center font-bold">UTS<br><span class="text-xs text-gray-500">(35%)</span></th>
                                <th class="p-4 border-b text-center font-bold">Rem.UTS</th>
                                <th class="p-4 border-b text-center font-bold">UAS<br><span class="text-xs text-gray-500">(45%)</span></th>
                                <th class="p-4 border-b text-center font-bold">Rem.UAS</th>
                                <th class="p-4 border-b text-center font-bold rounded-tr-lg">Total / Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nilais as $n)
                                <tr class="hover:bg-gray-50 border-b transition">
                                    <td class="p-4 font-medium text-gray-800">{{ $n->nama_matkul }}</td>
                                    <td class="p-4 text-center font-mono font-semibold text-green-700">{{ $n->tugas ?? '-' }}</td>
                                    <td class="p-4 text-center font-mono font-semibold text-blue-700">{{ $n->uts ?? '-' }}</td>
                                    <td class="p-4 text-center font-mono font-semibold {{ $n->remedial_uts ? 'text-orange-600 font-bold' : 'text-gray-400' }}">
                                        {{ $n->remedial_uts ?? '-' }}
                                    </td>
                                    <td class="p-4 text-center font-mono font-semibold text-purple-700">{{ $n->uas ?? '-' }}</td>
                                    <td class="p-4 text-center font-mono font-semibold {{ $n->remedial_uas ? 'text-orange-600 font-bold' : 'text-gray-400' }}">
                                        {{ $n->remedial_uas ?? '-' }}
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="font-bold text-xl font-mono text-gray-900 mb-1">{{ $n->total_nilai ?? '-' }}</div>
                                        <span class="px-4 py-2 rounded-full text-sm font-bold uppercase text-white

                                            {{ ($n->grade == 'A' ? 'bg-green-600 shadow-lg shadow-green-200' : 
                                               ($n->grade == 'B' ? 'bg-blue-600 shadow-lg shadow-blue-200' : 
                                               ($n->grade == 'C' ? 'bg-yellow-600 shadow-lg shadow-yellow-200 text-black' : 
                                               'bg-red-600 shadow-lg shadow-red-200'))) }}">

                                            {{ $n->grade ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection

