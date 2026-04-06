<!DOCTYPE html>
@extends('app')

@section('title', 'Staff Prodi Dashboard')

@section('page_title')
Dashboard Staff Prodi
@endsection

@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg border-b-4 border-green-500 mb-8">
    <div class="flex items-center mb-6">
        <div class="p-4 bg-green-100 rounded-xl mr-4">
            <i class="fas fa-user-tie text-3xl text-green-600"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-gray-800">Selamat Datang, Staff Prodi!</h3>
            <p class="text-gray-600">Kelola tugas staff prodi Teknik Elektro</p>
        </div>
    </div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-6 rounded-xl shadow-lg">
            <h4 class="text-lg font-bold mb-2">Tugas Hari Ini</h4>
            <p class="text-3xl font-bold">5</p>
        </div>
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white p-6 rounded-xl shadow-lg">
            <h4 class="text-lg font-bold mb-2">Pengajuan Pending</h4>
            <p class="text-3xl font-bold">{{ $stats['pending_pengajuan'] ?? 0 }}</p>
        </div>
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 text-white p-6 rounded-xl shadow-lg">
            <h4 class="text-lg font-bold mb-2">Total Pengajuan</h4>
            <p class="text-3xl font-bold">{{ $stats['total_pengajuan'] ?? 0 }}</p>
        </div>
    </div>
    <div class="mt-8 p-6 bg-gray-50 rounded-xl">
        <h4 class="font-bold text-lg mb-6">Fitur Staff Prodi</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('staff_prodi.pengajuan') }}" class="group bg-gradient-to-br from-blue-500 to-indigo-600 text-white p-8 rounded-2xl hover:from-blue-600 hover:to-indigo-700 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all group">
                <i class="fas fa-file-signature text-4xl mb-4 opacity-90 group-hover:opacity-100"></i>
                <h5 class="font-bold text-xl mb-2">Kelola Pengajuan</h5>
                <p class="opacity-90">Setujui/tolak pesiar, IB, LWE kadet</p>
            </a>
            <div class="p-8 text-center border-2 border-dashed border-gray-300 rounded-2xl hover:border-gray-400 transition">
                <i class="fas fa-cog text-4xl text-gray-400 mb-4"></i>
                <h5 class="font-bold text-xl mb-2 text-gray-700">Fitur Lainnya</h5>
                <p class="text-gray-500">Segera hadir</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white p-6 rounded-xl shadow-lg">
    <h4 class="text-xl font-bold mb-4">Recent Activities</h4>
    <div class="space-y-3">
        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4">
                <i class="fas fa-file-alt text-green-600"></i>
            </div>
            <div>
                <p class="font-semibold">Dokumen K1 disetujui</p>
                <p class="text-sm text-gray-500">2 jam lalu</p>
            </div>
        </div>
        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                <i class="fas fa-chart-bar text-blue-600"></i>
            </div>
            <div>
                <p class="font-semibold">Laporan mingguan dikirim</p>
                <p class="text-sm text-gray-500">1 hari lalu</p>
            </div>
        </div>
    </div>
</div>
@endsection

