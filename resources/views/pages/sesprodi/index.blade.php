<!DOCTYPE html>
@extends('app')

@section('title', 'Sesprodi Dashboard')

@section('page_title')
Dashboard Sekretaris Prodi
@endsection

@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg border-b-4 border-purple-500 mb-8">
    <div class="flex items-center mb-6">
        <div class="p-4 bg-purple-100 rounded-xl mr-4">
            <i class="fas fa-user-secret text-3xl text-purple-600"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-gray-800">Selamat Datang, Sesprodi!</h3>
            <p class="text-gray-600">Kelola administrasi prodi Teknik Elektro</p>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white p-6 rounded-xl shadow-lg">
            <h4 class="text-lg font-bold mb-2">Surat Masuk</h4>
            <p class="text-3xl font-bold">8</p>
        </div>
        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white p-6 rounded-xl shadow-lg">
            <h4 class="text-lg font-bold mb-2">Surat Keluar</h4>
            <p class="text-3xl font-bold">12</p>
        </div>
        <div class="bg-gradient-to-br from-pink-500 to-pink-600 text-white p-6 rounded-xl shadow-lg">
            <h4 class="text-lg font-bold mb-2">Agenda Prodi</h4>
            <p class="text-3xl font-bold">3</p>
        </div>
    </div>
    <div class="mt-8 p-6 bg-gray-50 rounded-xl">
        <h4 class="font-bold text-lg mb-4">Fitur Sesprodi</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-4 border-r">
                <i class="fas fa-envelope-open text-2xl text-purple-600 mb-2"></i>
                <p class="font-semibold">Surat Keluar/Masuk</p>
            </div>
            <div class="text-center p-4 border-r">
                <i class="fas fa-calendar-check text-2xl text-indigo-600 mb-2"></i>
                <p class="font-semibold">Agenda Prodi</p>
            </div>
            <div class="text-center p-4">
                <i class="fas fa-file-contract text-2xl text-pink-600 mb-2"></i>
                <p class="font-semibold">Dokumen Resmi</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white p-6 rounded-xl shadow-lg">
    <h4 class="text-xl font-bold mb-4">Recent Agenda</h4>
    <div class="space-y-3">
        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-4 text-sm font-bold text-purple-700">RAPAT</div>
            <div>
                <p class="font-semibold">Rapat Koordinasi Prodi</p>
                <p class="text-sm text-gray-500">Senin, 6 Oktober 2024 - 09:00</p>
            </div>
        </div>
        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-4 text-sm font-bold text-indigo-700">SEMINAR</div>
            <div>
                <p class="font-semibold">Seminar Teknik Elektro</p>
                <p class="text-sm text-gray-500">Rabu, 8 Oktober 2024 - 14:00</p>
            </div>
        </div>
    </div>
</div>
@endsection

