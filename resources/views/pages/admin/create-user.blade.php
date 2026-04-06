@extends('app')

@section('title', 'Buat User Baru')

@section('page_title', 'Buat Akun User Baru')

@section('content')
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 max-w-2xl mx-auto">
    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
        <i class="fas fa-user-plus mr-3 text-green-500"></i> Buat User Baru
    </h3>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap *</label>
                <input type="text" name="name" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Nama lengkap user">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Identifier/NIM * (unik)</label>
                <input type="text" name="identifier" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="ex: 2023001 atau dosen_001">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Role *</label>
                <select name="role" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Pilih Role</option>
                    <option value="admin">Admin</option>
                    <option value="dosen">Dosen</option>
                    <option value="kadet">Kadet/Mahasiswa</option>
                    <option value="staff_prodi">Staff Prodi</option>
                    <option value="sesprodi">Sekretaris Prodi</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Email (opsional)</label>
                <input type="email" name="email" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="user@teknikelektro.ac.id">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Password * (min 8)</label>
                <input type="password" name="password" required min="8" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Password aman">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password *</label>
                <input type="password" name="password_confirmation" required min="8" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Ulangi password">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="ex: Jakarta">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
        </div>

        <div class="mt-8">
            <label class="block text-sm font-bold text-gray-700 mb-2">Alamat (opsional)</label>
            <textarea name="alamat" rows="3" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Alamat lengkap"></textarea>
        </div>

        <div class="flex space-x-4 pt-8">
            <a href="{{ route('admin.users') }}" class="flex-1 bg-gray-300 text-gray-700 py-3 px-6 rounded-xl font-bold text-center hover:bg-gray-400 transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit" class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 text-white py-3 px-6 rounded-xl font-bold text-center hover:shadow-lg transition">
                <i class="fas fa-save mr-2"></i> Buat User
            </button>
        </div>
    </form>
</div>

<script>
document.querySelector('input[name="password"]').addEventListener('input', function() {
    const confirm = document.querySelector('input[name="password_confirmation"]');
    if (confirm.value) {
        confirm.setCustomValidity(this.value === confirm.value ? '' : 'Password tidak cocok');
    }
});

document.querySelector('input[name="password_confirmation"]').addEventListener('input', function() {
    const pass = document.querySelector('input[name="password"]');
    this.setCustomValidity(pass.value === this.value ? '' : 'Password tidak cocok');
});
</script>
@endsection

