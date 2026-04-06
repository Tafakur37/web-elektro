@extends('app')

@section('title', 'Log Aktivitas')

@section('page_title', 'Log Aktivitas Admin')

@section('content')
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="p-8 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-gray-100">
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Riwayat Aktivitas Sistem</h3>
        <p class="text-gray-600">Semua aksi admin dan user (login, edit, hapus, etc.)</p>
    </div>

    <div class="p-8">
        <div class="bg-gradient-to-r from-orange-50 to-yellow-50 border border-orange-200 rounded-xl p-8 text-center">
            <i class="fas fa-clipboard-list-check text-6xl text-orange-500 mb-6 opacity-80"></i>
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Fitur Log Aktivitas</h2>
            <p class="text-xl text-gray-600 mb-8">Dalam pengembangan...</p>
            <p class="text-sm text-gray-500">Log akan direkam otomatis (login, CRUD users, nilai, materi, pengajuan). Placeholder untuk tampilan table timeline.</p>
        </div>
    </div>
</div>
@endsection
