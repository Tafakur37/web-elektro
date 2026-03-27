@extends('app')

@section('title', 'Bahan Ajar')
@section('page_title', 'Materi Perkuliahan')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-blue-900 italic">
            <i class="fas fa-book-reader mr-2"></i>Daftar Materi Cohort {{ (int)substr($user->identifier, 1, 4) - 2019 }}
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($bahanAjar ?? [] as $materi)
            <div class="border rounded-xl p-5 hover:shadow-md transition bg-gray-50 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-gray-800">{{ $materi->nama_matkul }}</h3>
                    <p class="text-xs text-gray-500">Diunggah oleh: Dosen Pengampu</p>
                </div>
                <a href="#" class="bg-blue-900 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-800">
                    <i class="fas fa-download mr-1"></i> PDF
                </a>
            </div>
        @empty
            <div class="col-span-2 text-center py-20">
                <i class="fas fa-box-open text-gray-200 text-6xl mb-4"></i>
                <p class="text-gray-400 italic font-mono uppercase tracking-widest">Belum ada materi untuk angkatanmu</p>
            </div>
        @endforelse
    </div>
</div>
@endsection