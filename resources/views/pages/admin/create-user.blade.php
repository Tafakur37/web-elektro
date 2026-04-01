@extends('app')

@section('title', 'Buat User Baru')

@section('page_title', 'Buat Pengguna Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white p-8 rounded-2xl shadow-lg">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500" required>
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Role *</label>
                        <select name="role" class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500" required>
                            <option value="">Pilih Role</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="kadet" {{ old('role') == 'kadet' ? 'selected' : '' }}>Kadet</option>
                            <option value="staff_prodi" {{ old('role') == 'staff_prodi' ? 'selected' : '' }}>Staff Prodi</option>
                            <option value="sesprodi" {{ old('role') == 'sesprodi' ? 'selected' : '' }}>Sesprodi</option>
                        </select>
                        @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Identifier/NIM/NIP *</label>
                        <input type="text" name="identifier" value="{{ old('identifier') }}" class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500" placeholder="dosen_001 or 3yyyy0402xxx" required>
                        @error('identifier') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Password *</label>
                        <input type="password" name="password" class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500" required>
                        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Email (Opsional)</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Lahir (Opsional)</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tempat Lahir (Opsional)</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Alamat (Opsional)</label>
                        <textarea name="alamat" rows="2" class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">{{ old('alamat') }}</textarea>
                    </div>
                </div>
                <div class="flex space-x-4 pt-4">
                    <a href="{{ route('admin.users') }}" class="flex-1 bg-gray-300 text-gray-700 py-3 px-6 rounded-xl font-bold text-center hover:bg-gray-400 transition">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 bg-blue-500 text-white py-3 px-6 rounded-xl font-bold text-center hover:bg-blue-600 shadow-lg transition">
                        Buat User
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

