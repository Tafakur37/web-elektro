@extends('app')

@section('title', 'Buat Pengguna Baru')

@section('page_title', 'Buat Pengguna Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
        <h3 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-user-plus mr-3 text-green-500"></i> Buat Pengguna Baru
        </h3>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Role *</label>
                        <select name="role" class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
                            <option value="">Pilih Role</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin / Superman</option>
                            <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="kadet" {{ old('role') == 'kadet' ? 'selected' : '' }}>Kadet (Mahasiswa)</option>
                            <option value="staff_prodi" {{ old('role') == 'staff_prodi' ? 'selected' : '' }}>Staff Prodi</option>
                            <option value="sesprodi" {{ old('role') == 'sesprodi' ? 'selected' : '' }}>Sekretaris Prodi</option>
                        </select>
                        @error('role') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Identifier / NIM / NIP * (unik)</label>
                        <input type="text" name="identifier" value="{{ old('identifier') }}" class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="2024001 untuk kadet, dosen_001 untuk dosen" required>
                        @error('identifier') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Password * (min 8)</label>
                        <input type="password" name="password" class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required minlength="8">
                        @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Email (Opsional)</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tempat Lahir (Opsional)</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Lahir (Opsional)</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Alamat (Opsional)</label>
                    <textarea name="alamat" rows="3" class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">{{ old('alamat') }}</textarea>
                </div>
                <div class="flex space-x-4 pt-6">
                    <a href="{{ route('admin.users') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-3 px-8 rounded-xl font-bold text-center transition shadow-md">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                    <button type="submit" class="flex-1 bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white py-3 px-8 rounded-xl font-bold text-center transition shadow-lg">
                        <i class="fas fa-user-plus mr-2"></i> Buat Pengguna
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Password confirmation match
    const password = document.querySelector('input[name="password"]');
    const confirmPassword = document.querySelector('input[name="password_confirmation"]') || null;
    
    if (password && confirmPassword) {
        password.addEventListener('input', checkPasswordMatch);
        confirmPassword.addEventListener('input', checkPasswordMatch);
    }

    function checkPasswordMatch() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Password tidak cocok');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }

    // Identifier hint based on role
    const roleSelect = document.querySelector('select[name="role"]');
    const identifierInput = document.querySelector('input[name="identifier"]');
    if (roleSelect && identifierInput) {
        roleSelect.addEventListener('change', function() {
            const role = this.value;
            let placeholder = 'Identifier unik';
            if (role === 'kadet') placeholder = '2024001';
            else if (role === 'dosen') placeholder = 'dosen_001';
            else if (role === 'admin') placeholder = 'superman';
            identifierInput.placeholder = placeholder;
        });
    }
</script>

<style>
    .focus\\:ring-2:focus { ring-width: 2px; }
</style>
@endsection
