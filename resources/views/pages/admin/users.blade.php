@extends('app')

@section('title', 'Daftar User')

@section('page_title', 'Kelola User')

@section('content')
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="p-8 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
@if(false) {{-- Disabled inline cohort selector --}}
                <h3 class="text-2xl font-bold text-gray-800">
                    @if($role) Daftar {{ ucfirst($role) }} @else Semua Pengguna @endif
                    @if($cohort) - Cohort {{ $cohort }} @endif
                    ({{ $users->total() }})
                </h3>
                @if($role == 'kadet' && $cohorts)
                <div class="flex flex-wrap gap-2 mt-4">
                    @foreach($cohorts as $c)
                        <a href="{{ route('admin.users') }}?role=kadet&cohort={{ $c }}" class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-bold hover:bg-blue-200 {{ ($cohort == $c) ? 'bg-blue-600 text-white' : '' }}">
                            Cohort {{ $c }}
                        </a>
                    @endforeach
                </div>
                @endif
            @endif
            {{-- Buat User Baru button removed per user request --}}
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-6 font-bold text-left text-gray-700 uppercase text-xs tracking-wider">Identifier</th>
                    <th class="p-6 font-bold text-left text-gray-700 uppercase text-xs tracking-wider">Nama</th>
                    <th class="p-6 font-bold text-left text-gray-700 uppercase text-xs tracking-wider">Role</th>
                    <th class="p-6 font-bold text-left text-gray-700 uppercase text-xs tracking-wider">Email</th>
                    <th class="p-6 font-bold text-left text-gray-700 uppercase text-xs tracking-wider">Terdaftar</th>
                    <th class="p-6 font-bold text-right text-gray-700 uppercase text-xs tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $u)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-6 font-mono font-semibold text-purple-900">{{ $u->identifier }}</td>
                        <td class="p-6 font-semibold text-gray-900">{{ $u->name }}</td>
                        <td class="p-6">
                            <span class="inline-block bg-gradient-to-r px-3 py-1 rounded-full text-xs font-bold text-white tracking-wide capitalize">
                                {{ $u->role }}
                            </span>
                        </td>
                        <td class="p-6 text-sm text-gray-700">{{ $u->email ?? '-' }}</td>
                        <td class="p-6 text-sm text-gray-600">{{ $u->created_at->format('d M Y') }}</td>
                        <td class="p-6 text-right space-x-2">
                            <button onclick="showResetModal('{{ $u->id }}')" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                                <i class="fas fa-key mr-1"></i>Reset Password
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-12 text-center text-gray-500">
                            <i class="fas fa-users text-5xl mb-4 opacity-50"></i>
                            Tidak ada pengguna
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-6 bg-gray-50 border-t">
        {{ $users->appends(['role' => $role ?? ''])->links() }}
    </div>
</div>

{{-- Reset Password Modal --}}
<div id="resetPasswordModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-4" onclick="closeResetModal()">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-8" onclick="event.stopPropagation()">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Reset Password</h3>
        <form id="resetForm" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Password Baru</label>
                <input type="password" name="password" required min="8" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Minimal 8 karakter">
            </div>
            <div class="flex space-x-3">
                <button type="button" onclick="closeResetModal()" class="flex-1 bg-gray-300 text-gray-700 py-3 px-6 rounded-xl font-bold hover:bg-gray-400 transition">
                    Batal
                </button>
                <button type="submit" class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-xl font-bold hover:bg-blue-700 transition">
                    Reset Password
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
@endsection

