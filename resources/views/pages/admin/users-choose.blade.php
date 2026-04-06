@extends('app')

@section('title', 'Kelola User - Pilih Kategori')

@section('page_title', 'Kelola User')

@section('content')
<div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl p-12 text-center border border-white/50 max-w-4xl mx-auto">
    <div class="text-center mb-12">
        <i class="fas fa-users text-6xl text-blue-500 mb-6 opacity-75"></i>
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Pilih Jenis User untuk Dikelola</h2>
        <p class="text-xl text-gray-600 mb-8">Pilih kategori user yang ingin Anda lihat dan kelola datanya</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
        <a href="{{ route('admin.users') }}?role=kadet" class="group bg-gradient-to-br from-emerald-500 to-green-600 text-white p-10 rounded-3xl shadow-2xl hover:shadow-3xl hover:scale-105 transition-all duration-300 text-center">
            <div class="text-5xl mb-6">
                <i class="fas fa-user-graduate group-hover:scale-110 transition"></i>
            </div>
            <h3 class="text-2xl font-bold mb-2">Kelola Kadet / Mahasiswa</h3>
            <p class="text-blue-100 opacity-90">Lihat daftar kadet, tambah/edit data mahasiswa</p>
        </a>

        <a href="{{ route('admin.users') }}?role=dosen" class="group bg-gradient-to-br from-purple-500 to-purple-600 text-white p-10 rounded-3xl shadow-2xl hover:shadow-3xl hover:scale-105 transition-all duration-300 text-center">
            <div class="text-5xl mb-6">
                <i class="fas fa-chalkboard-teacher group-hover:scale-110 transition"></i>
            </div>
            <h3 class="text-2xl font-bold mb-2">Kelola User</h3>
            <p class="text-blue-100 opacity-90">Lihat daftar dosen, reset password, edit data</p>
        </a>
    </div>

    <div class="text-center mt-16">
        <a href="{{ route('admin.users') }}" class="text-blue-600 hover:text-blue-800 font-bold text-lg underline">
            <i class="fas fa-users mr-2"></i> Atau lihat semua user
        </a>
    </div>
</div>
@endsection

