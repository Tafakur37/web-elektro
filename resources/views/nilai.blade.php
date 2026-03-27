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
                    <th class="p-4 border-b">Mata Kuliah</th>
                    <th class="p-4 border-b text-center">SKS</th>
                    <th class="p-4 border-b text-center">Skor</th>
                    <th class="p-4 border-b text-center">Grade</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nilaiKadet ?? [] as $n)
                    <tr class="hover:bg-green-50 transition border-b">
                        <td class="p-4 font-semibold text-gray-700">{{ $n->nama_matkul }}</td>
                        <td class="p-4 text-center">3</td>
                        <td class="p-4 text-center font-mono">{{ $n->skor }}</td>
                        <td class="p-4 text-center">
                            <span class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-xs font-bold uppercase">
                                {{ $n->grade }}
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