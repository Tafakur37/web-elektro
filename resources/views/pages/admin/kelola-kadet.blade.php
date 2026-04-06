@extends('app')

@section('title', 'Kelola Kadet')

@section('page_title', 'Kelola Data Kadet')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg">
    <div class="text-center py-12">
        <i class="fas fa-users-cog text-gray-300 text-6xl mb-6"></i>
<h2 class="text-2xl font-bold text-gray-700 mb-2">Kelola User - Pilih Kategori</h2>
<p class="text-lg text-gray-600 mb-8">Pilih dosen atau kadet/mahasiswa untuk dikelola</p>
        <p class="text-gray-500">Halaman ini menampilkan data semua kadet. Integrasi dengan database User role='kadet'.</p>
        <p class="text-sm text-gray-400 mt-4">Data: {{ count($kadet ?? []) }} kadet</p>
    </div>
</div>
@endsection

