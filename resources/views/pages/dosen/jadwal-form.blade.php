@extends('app')

@section('title', (isset($jadwal) ? 'Edit' : 'Tambah') . ' Jadwal Kuliah - Dosen')

@section('page_title', (isset($jadwal) ? 'Edit Jadwal' : 'Tambah Jadwal Baru'))

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white p-8 rounded-xl shadow-lg border">

<form method="POST" action="{{ isset($jadwal) ? route('dosen.jadwal.update', $jadwal) : route('dosen.jadwal.store') }}" class="space-y-6">

            @csrf
            @if(isset($jadwal)) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Semester <span class="text-red-500">*</span></label>
                    <select name="semester" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        @for($s=1; $s<=14; $s++)
                            <option value="{{ $s }}" {{ (isset($jadwal) ? $jadwal->semester : old('semester')) == $s ? 'selected' : '' }}>Semester {{ $s }}</option>
                        @endfor
                    </select>
                    @error('semester') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Cohort</label>
                    <select name="cohort" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Cohort</option>
                        @foreach($cohorts as $c)
                            <option value="{{ $c }}" {{ (isset($jadwal) ? $jadwal->cohort : old('cohort')) == $c ? 'selected' : '' }}>Cohort {{ $c }}</option>
                        @endforeach
                    </select>
                    @error('cohort') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Mata Kuliah <span class="text-red-500">*</span></label>
                <input type="text" name="mata_kuliah" value="{{ isset($jadwal) ? $jadwal->mata_kuliah : old('mata_kuliah') }}" required 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Pemrograman Dasar">
                @error('mata_kuliah') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Hari <span class="text-red-500">*</span></label>
                    <select name="hari" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        @foreach($hari as $h)
                            <option value="{{ $h }}" {{ (isset($jadwal) ? $jadwal->hari : old('hari')) == $h ? 'selected' : '' }}>{{ $h }}</option>
                        @endforeach
                    </select>
                    @error('hari') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Dosen <span class="text-red-500">*</span></label>
                    <input type="text" name="dosen" value="{{ isset($jadwal) ? $jadwal->dosen : old('dosen') }}" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Nama Dosen">
                    @error('dosen') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Jam Mulai <span class="text-red-500">*</span></label>
                    <input type="time" name="jam_mulai" value="{{ isset($jadwal) ? $jadwal->jam_mulai->format('H:i') : old('jam_mulai') }}" required 
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('jam_mulai') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Jam Selesai <span class="text-red-500">*</span></label>
                    <input type="time" name="jam_selesai" value="{{ isset($jadwal) ? $jadwal->jam_selesai->format('H:i') : old('jam_selesai') }}" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('jam_selesai') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Ruang <span class="text-red-500">*</span></label>
                <input type="text" name="ruang" value="{{ isset($jadwal) ? $jadwal->ruang : old('ruang') }}" required 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="E-101, Lab Digital, etc">
                @error('ruang') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex space-x-4 pt-4">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition">
                    <i class="fas fa-save mr-2"></i>
                    {{ isset($jadwal) ? 'Update Jadwal' : 'Tambah Jadwal' }}
                </button>
                <a href="{{ route('dosen.jadwal.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg text-center transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
