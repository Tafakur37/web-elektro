@extends('app')

@section('title', 'Manajemen Akademik')
@section('page_title', 'Status Akademik')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg">
    <div class="flex items-center space-x-4 mb-8">
        <div class="bg-yellow-100 p-4 rounded-full text-yellow-600 text-2xl">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-800 font-mono italic">Semester Genap 2025/2026</h2>
            <p class="text-sm text-gray-500 uppercase tracking-widest font-bold">Teknik Elektro - Cohort {{ (int)substr($user->identifier, 1, 4) - 2019 }}</p>
        </div>
    </div>

    <div class="border-l-4 border-blue-900 p-6 bg-blue-50 rounded-r-xl">
        <h3 class="font-bold text-blue-900 mb-2">Informasi Penting:</h3>
        <ul class="list-disc ml-5 text-sm text-blue-800 space-y-1">
            <li>Pengisian KRS berakhir dalam 3 hari lagi.</li>
            <li>Pastikan data NIK di profil sudah benar untuk pelaporan PDDIKTI.</li>
            <li>Ujian Tengah Semester dimulai tanggal 12 April 2026.</li>
        </ul>
    </div>
</div>
@endsection