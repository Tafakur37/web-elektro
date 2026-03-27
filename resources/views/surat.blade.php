@extends('app')

@section('title', 'Surat & Berkas')
@section('page_title', 'Layanan Dokumen')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-2 bg-white p-8 rounded-xl shadow-lg">
        <h2 class="text-xl font-bold mb-6 text-blue-900 italic">Ajukan Surat Keterangan</h2>
        <form action="#" class="space-y-4">
            <div>
                <label class="block text-sm font-bold mb-1">Jenis Surat</label>
                <select class="w-full border rounded-lg p-2 bg-gray-50">
                    <option>Surat Keterangan Aktif Kuliah</option>
                    <option>Surat Izin Penelitian</option>
                    <option>Surat Cuti Akademik</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold mb-1">Alasan Pengajuan</label>
                <textarea class="w-full border rounded-lg p-2 h-32 bg-gray-50" placeholder="Jelaskan keperluan dirimu..."></textarea>
            </div>
            <button class="bg-blue-900 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-800 transition">Kirim Pengajuan</button>
        </form>
    </div>

    <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
        <h3 class="font-bold text-blue-900 mb-4">Format Dokumen</h3>
        <ul class="space-y-4">
            <li class="flex items-center justify-between text-sm">
                <span>Logbook KP.docx</span>
                <i class="fas fa-download text-blue-600 cursor-pointer"></i>
            </li>
            <li class="flex items-center justify-between text-sm">
                <span>Format Proposal TA.pdf</span>
                <i class="fas fa-download text-blue-600 cursor-pointer"></i>
            </li>
        </ul>
    </div>
</div>
@endsection