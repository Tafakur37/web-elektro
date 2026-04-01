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
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-6 rounded-xl shadow-lg">
            <h4 class="text-lg font-bold mb-2">Dokumen Pending</h4>
            <p class="text-3xl font-bold">2</p>
        </div>
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 text-white p-6 rounded-xl shadow-lg">
            <h4 class="text-lg font-bold mb-2">Laporan Bulanan</h4>
            <p class="text-3xl font-bold">1</p>
        </div>
    </div>
    <div class="mt-8 p-6 bg-gray-50 rounded-xl">
        <h4 class="font-bold text-lg mb-4">Fitur Staff Prodi</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-4 border-r">
                <i class="fas fa-file-invoice text-2xl text-green-600 mb-2"></i>
                <p class="font-semibold">Kelola Dokumen</p>
            </div>
            <div class="text-center p-4 border-r">
                <i class="fas fa-clipboard-list text-2xl text-blue-600 mb-2"></i>
                <p class="font-semibold">Laporan Prodi</p>
            </div>
            <div class="text-center p-4">
                <i class="fas fa-users text-2xl text-orange-600 mb-2"></i>
                <p class="font-semibold">Data Staff</p>
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

