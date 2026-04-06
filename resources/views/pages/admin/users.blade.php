@extends('app')

@section('title', 'Kelola Pengguna')

@section('page_title', 'Kelola Pengguna')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-center">
        <h3 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-users mr-3 text-blue-500"></i>
            Daftar Pengguna ({{ $users->total() }})
            @if($role) 
                <span class="ml-2 px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-bold">{{ ucfirst($role) }}</span>
            @endif
            @if($cohort)
                <span class="ml-2 px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-bold">Cohort {{ $cohort }}</span>
            @endif
        </h3>
        @if(!$role && !$cohort)
            <a href="{{ route('admin.users.create') }}" class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-3 rounded-xl font-bold hover:shadow-xl transition-all duration-300 flex items-center shadow-lg">
                <i class="fas fa-plus mr-2"></i> Buat Pengguna
            </a>
        @endif
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-400 text-green-700 p-4 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="p-6 text-left font-bold text-gray-700 uppercase text-xs tracking-wider border-b-2 border-gray-200">Identifier</th>
                        <th class="p-6 text-left font-bold text-gray-700 uppercase text-xs tracking-wider border-b-2 border-gray-200">Nama</th>
                        <th class="p-6 text-left font-bold text-gray-700 uppercase text-xs tracking-wider border-b-2 border-gray-200">Role</th>
                        <th class="p-6 text-left font-bold text-gray-700 uppercase text-xs tracking-wider border-b-2 border-gray-200">Email</th>
                        <th class="p-6 text-left font-bold text-gray-700 uppercase text-xs tracking-wider border-b-2 border-gray-200">Terdaftar</th>
                        <th class="p-6 text-right font-bold text-gray-700 uppercase text-xs tracking-wider border-b-2 border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $u)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="p-6 font-mono font-semibold text-gray-900 bg-gray-50 rounded-l-xl">{{ $u->identifier }}</td>
                            <td class="p-6 font-semibold text-gray-900">{{ $u->name }}</td>
                            <td class="p-6">
                                <span class="inline-flex px-4 py-1 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full text-sm font-bold shadow-sm">
                                    {{ ucfirst(str_replace('_', ' ', $u->role)) }}
                                </span>
                            </td>
                            <td class="p-6 text-sm text-gray-600">{{ $u->email ?? '<i class="fas fa-minus text-gray-400"></i>' }}</td>
                            <td class="p-6 text-sm text-gray-500">{{ $u->created_at->format('d M Y H:i') }}</td>
                            <td class="p-6 text-right pr-8">
                                <button onclick="showResetModal({{ $u->id }})" class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-xl text-sm font-bold shadow-md hover:shadow-lg transition-all duration-200">
                                    <i class="fas fa-key mr-2"></i> Reset Password
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-20 text-center text-gray-500 bg-gray-50 rounded-xl">
                                <i class="fas fa-users-slash text-6xl mb-6 opacity-50"></i>
                                <h3 class="text-xl font-bold mb-2">Tidak ada pengguna</h3>
                                <p class="text-gray-400">Mulai dengan <a href="{{ route('admin.users.create') }}" class="text-blue-600 hover:text-blue-800 font-bold">membuat pengguna pertama</a></p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-8 bg-gradient-to-r from-gray-50 to-gray-100 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} pengguna
                </div>
                {{ $users->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    {{-- Reset Password Modal --}}
    <div id="resetPasswordModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 p-6 flex items-center justify-center">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-8">
                <h4 class="text-2xl font-bold text-gray-800">Reset Password</h4>
                <button onclick="closeResetModal()" class="text-gray-500 hover:text-gray-700 text-2xl p-2 hover:bg-gray-100 rounded-xl transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="resetForm" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Password Baru (min 8)</label>
                    <input type="password" name="password" required minlength="8" class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition shadow-sm" placeholder="Password baru">
                    @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="flex justify-end space-x-4 pt-2">
                    <button type="button" onclick="closeResetModal()" class="px-8 py-3 bg-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-300 transition shadow-sm">
                        Batal
                    </button>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-200">
                        <i class="fas fa-save mr-2"></i> Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    let currentUserId = null;

    function showResetModal(id) {
        currentUserId = id;
        document.getElementById('resetForm').action = `/admin/users/${id}/reset-password`;
        document.getElementById('resetPasswordModal').classList.remove('hidden');
    }

    function closeResetModal() {
        document.getElementById('resetPasswordModal').classList.add('hidden');
        currentUserId = null;
    }
    </script>
</div>
@endsection
