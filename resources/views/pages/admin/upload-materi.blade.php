@extends('app')

@section('title', 'Upload Materi')

@section('page_title', 'Upload Bahan Ajar')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg max-w-2xl">
    <h2 class="text-xl font-bold mb-6">Form Upload Materi</h2>
    <form class="space-y-4">
        <div>
            <label class="block text-sm font-bold mb-2">Nama Matkul</label>
            <input type="text" class="w-full p-3 border rounded-lg">
        </div>
        <div>
            <label class="block text-sm font-bold mb-2">Cohort</label>
            <input type="number" class="w-full p-3 border rounded-lg">
        </div>
        <div>
            <label class="block text-sm font-bold mb-2">File Materi</label>
            <input type="file" class="w-full p-3 border rounded-lg bg-gray-50">
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg font-bold hover:bg-blue-700">Upload</button>
    </form>
</div>
@endsection

