@extends('app')

@section('title', 'Kelola Users')

@section('page_title', 'Kelola Pengguna')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-center">
        <h3 class="text-2xl font-bold text-gray-800">Semua Pengguna ({{ $users->total() }})</h3>
        <a href="{{ route('admin.users.create') }}" class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-3 rounded-xl font-bold hover:shadow-lg transition">
            <i class="fas fa-plus mr-2"></i> Buat User Baru
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 p-4 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="p-6 text-left font-bold text-gray-700">Identifier</th>
                        <th class="p-6 text-left font-bold text-gray-700">Nama</th>
                        <th class="p-6 text-left font-bold text-gray-700">Role</th>
                        <th class="p-6 text-left font-bold text-gray-700">Email</th>
                        <th class="p-6 text-right font-bold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $u)
                        <tr class="hover:bg-gray-50">
                            <td class="p-6 font-mono font-semibold">{{ $u->identifier }}</td>
                            <td class="p-6 font-semibold">{{ $u->name }}</td>
                            <td class="p-6">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-bold">
                                    {{ ucfirst($u->role) }}
                                </span>
                            </td>
                            <td class="p-6">{{ $u->email ?? '-' }}</td>
                            <td class="p-6 text-right space-x-3">
                                <button onclick="resetPassword({{ $u->id }})" class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm rounded-xl hover:bg-orange-600">
                                    <i class="fas fa-key mr-1"></i> Reset Password
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-gray-500">
                                <i class="fas fa-users text-5xl mb-4 opacity-50"></i>
                                Tidak ada pengguna
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 bg-gray-50 border-t">
            {{ $users->links() }}
        </div>
    </div>
</div>

{{-- Create User Modal --}}
<div id="createUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 p-4 flex items-center justify-center">
    <div class="bg-white rounded-3xl p-8 max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-user-plus mr-3 text-green-500"></i> Buat User Baru
            </h3>
            <button onclick="closeCreateModal()" class="text-gray-500 hover:text-gray-700 text-xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold mb-2">Nama Lengkap *</label>
                    <input type="text" name="name" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">Role *</label>
                    <select name="role" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="dosen">Dosen</option>
                        <option value="kadet">Kadet</option>
                        <option value="staff_prodi">Staff Prodi</option>
                        <option value="sesprodi">Sesprodi</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <div>
                    <label class="block text-sm font-bold mb-2">Identifier/NIM/NIP *</label>
                    <input type="text" name="identifier" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-500" placeholder="3yyyy0402xxx atau dosen_001" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">Password *</label>
                    <input type="password" name="password" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <div>
                    <label class="block text-sm font-bold mb-2">Email (Opsional)</label>
                    <input type="email" name="email" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div class="mt-6">
                <label class="block text-sm font-bold mb-2">Tempat Lahir & Alamat (Opsional)</label>
                <textarea name="tempat_lahir" class="w-full p-3 border rounded-xl mr-4" placeholder="Tempat Lahir"></textarea>
                <textarea name="alamat" class="w-full p-3 border rounded-xl" rows="2" placeholder="Alamat"></textarea>
            </div>
            <div class="flex justify-end space-x-4 mt-8">
                <button type="button" onclick="closeCreateModal()" class="px-8 py-3 border border-gray-300 text-gray-700 rounded-xl font-bold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="bg-blue-500 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-600 shadow-lg transition">
                    <i class="fas fa-save mr-2"></i> Buat User
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Reset Password Modal --}}
<div id="resetPasswordModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 p-4 flex items-center justify-center">
    <div class="bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl">
        <div class="flex justify-between items-center mb-4">
            <h4 class="font-bold text-lg">Reset Password</h4>
            <button onclick="closeResetModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" id="resetForm">
            @csrf
            <div class="mb-4">
                <input type="password" name="password" placeholder="Password baru (min 8)" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-orange-500" required>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeResetModal()" class="px-6 py-2 border text-gray-700 rounded-xl hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-xl font-bold hover:bg-orange-600">
                    Reset
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let currentUserId = null;

function resetPassword(id) {
    currentUserId = id;
    document.getElementById('resetForm').action = `/admin/users/${id}/reset-password`;
    document.getElementById('resetPasswordModal').classList.remove('hidden');
}

function closeResetModal() {
    document.getElementById('resetPasswordModal').classList.add('hidden');
    currentUserId = null;
}

function closeCreateModal() {
    document.getElementById('createUserModal').classList.add('hidden');
}
</script>
@endsection

