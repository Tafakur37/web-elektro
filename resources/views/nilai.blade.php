@extends('app')

@section('title', 'Nilai Akademik')
@section('page_title', 'Transkrip Nilai Kadet')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-green-600">
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-800">Capaian Hasil Belajar</h2>
        <p class="text-sm text-gray-400">Data nilai ini diinput secara resmi oleh Dosen dan Kaprodi.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 text-xs uppercase tracking-widest">

                    <th class="p-4 border-b text-left">Mata Kuliah</th>
                    <th class="p-4 border-b text-center">Tugas</th>
                    <th class="p-4 border-b text-center">UTS</th>
                    <th class="p-4 border-b text-center">Rem.UTS</th>
                    <th class="p-4 border-b text-center">UAS</th>
                    <th class="p-4 border-b text-center">Rem.UAS</th>
                    <th class="p-4 border-b text-center">Total</th>
                    <th class="p-4 border-b text-center">Grade</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nilaiKadet ?? [] as $n)
                    <tr class="hover:bg-green-50 transition border-b">
                        <td class="p-4 font-semibold text-gray-700">{{ $n->nama_matkul }}</td>
                        <td class="p-4 text-center font-mono">{{ $n->tugas ?? '-' }}</td>
                        <td class="p-4 text-center font-mono">{{ $n->uts ?? '-' }}</td>
                        <td class="p-4 text-center">{{ $n->remedial_uts ? '✓' : '-' }}</td>
                        <td class="p-4 text-center font-mono">{{ $n->uas ?? '-' }}</td>
                        <td class="p-4 text-center">{{ $n->remedial_uas ? '✓' : '-' }}</td>
                        <td class="p-4 text-center font-bold font-mono">{{ $n->total_nilai ?? '-' }}</td>
                        <td class="p-4 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase text-white
                                {{ $n->grade == 'A' ? 'bg-green-600' : ($n->grade == 'B' ? 'bg-blue-600' : ($n->grade == 'C' ? 'bg-yellow-600' : 'bg-red-600')) }}">
                                {{ $n->grade ?? '-' }}
                            </span>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="4" class="p-20 text-center text-gray-300 italic">
                            <i class="fas fa-graduation-cap text-5xl mb-4 block opacity-20"></i>
                            Nilai Semester ini belum dipublikasikan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection