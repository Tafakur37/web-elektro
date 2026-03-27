@extends('app')

@section('title', 'Profil Akun')
@section('page_title', 'Data Pribadi Kadet')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg max-w-4xl mx-auto">
    <div class="flex flex-col md:flex-row items-center space-y-6 md:space-y-0 md:space-x-10 border-b pb-10">
        <div class="w-32 h-32 bg-blue-900 rounded-full flex items-center justify-center text-white text-5xl font-bold border-4 border-blue-100 shadow-xl">
            {{ substr($user->name, 0, 1) }}
        </div>
        <div class="text-center md:text-left">
            <h2 class="text-3xl font-bold text-gray-800 italic uppercase">{{ $user->name }}</h2>
            <p class="text-blue-600 font-bold tracking-widest">NIM: {{ $user->identifier }}</p>
            <span class="mt-2 inline-block bg-gray-100 px-4 py-1 rounded-full text-xs text-gray-500 font-bold uppercase">{{ $user->role }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-10">
        <div>
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Email Institusi</label>
            <p class="text-gray-700 font-medium">{{ $user->email }}</p>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Tempat, Tanggal Lahir</label>
            <p class="text-gray-700 font-medium">{{ $user->tempat_lahir ?? '-' }}, {{ $user->tanggal_lahir ?? '-' }}</p>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Status Keanggotaan</label>
            <p class="text-gray-700 font-medium">Mahasiswa Aktif Teknik Elektro</p>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Tahun Angkatan</label>
            <p class="text-gray-700 font-medium">{{ substr($user->identifier, 1, 4) }}</p>
        </div>
    </div>

    <div class="mt-12 flex space-x-4">
        <button class="bg-yellow-500 text-white px-6 py-2 rounded-lg text-sm font-bold hover:bg-yellow-600 transition">Edit Profil</button>
        <button class="bg-gray-100 text-gray-600 px-6 py-2 rounded-lg text-sm font-bold hover:bg-gray-200 transition">Ganti Password</button>
    </div>
</div>
@endsection