@extends('app')

@section('title', 'Kelola Pengajuan')

@section('page_title', 'Kelola Pengajuan Kadet')

@section('content')
<div class="space-y-8">
    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 text-white p-6 rounded-2xl shadow-xl text-center">
            <i class="fas fa-clock text-3xl mb-3 opacity-75"></i>
            <div class="text-3xl font-bold">{{ $pengajuan->where('status', 'pending')->count() }}</div>
            <div class="text-sm opacity-90">Pending</div>
        </div>
        <div class="bg-gradient-to-br from-green-400 to-green-500 text-white p-6 rounded-2xl shadow-xl text-center">
            <i class="fas fa-check-circle text-3xl mb-3 opacity-75"></i>
            <div class="text-3xl font-bold">{{ $pengajuan->where('status', 'approved')->count() }}</div>
            <div class="text-sm opacity-90">Disetujui</div>
        </div>
        <div class="bg-gradient-to-br from-red-400 to-red-500 text-white p-6 rounded-2xl shadow-xl text-center">
            <i class="fas fa-times-circle text-3xl mb-3 opacity-75"></i>
            <div class="text-3xl font-bold">{{ $pengajuan->where('status', 'rejected')->count() }}</div>
            <div class="text-sm opacity-90">Ditolak</div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-8 py-4 rounded-2xl shadow-lg">
            <i class="fas fa-check-circle mr-3"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-8 border-b border-gray-100">
            <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-list mr-4 text-blue-500"></i>
                Daftar Pengajuan Pending ({{ $pengajuan->count() }})
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="p-6 text-left font-bold text-gray-700">NIM / Absen</th>
                        <th class="p-6 text-left font-bold text-gray-700">Nama Kadet</th>
                        <th class="p-6 text-left font-bold text-gray-700">Jenis</th>
                        <th class="p-6 text-left font-bold text-gray-700">Tanggal</th>
                        <th class="p-6 text-left font-bold text-gray-700">Berkas</th>
                        <th class="p-6 text-right font-bold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pengajuan as $p)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-6 font-mono font-semibold text-purple-900">
                                <div>{{ substr($p->user->identifier, -3) }}</div>
                                <div class="text-xs text-gray-500">{{ $p->user->identifier }}</div>
                            </td>
                            <td class="p-6 font-semibold">{{ $p->user->name }}</td>
                            <td class="p-6">
                                <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full font-bold">
                                    {{ ucfirst(str_replace('_', ' ', $p->type)) }}
                                </span>
                            </td>
                            <td class="p-6 text-gray-600">{{ $p->created_at->format('d M Y H:i') }}</td>
                            <td class="p-6">
                                @if($p->berkas_path)
                                    <a href="{{ Storage::url($p->berkas_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-semibold">
                                        <i class="fas fa-file-pdf mr-1"></i> Download
                                    </a>
                                @else
                                    <span class="text-gray-400">Tidak ada</span>
                                @endif
                            </td>
                            <td class="p-6 text-right space-x-2">
                                <a href="{{ route('pengajuan.show', $p) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-bold rounded-xl hover:bg-blue-600 transition shadow-sm">
                                    <i class="fas fa-eye mr-1"></i> Detail
                                </a>
                                <button onclick="handleApprove({{ $p->id }})" class="inline-flex items-center px-4 py-2 bg-green-500 text-white text-sm font-bold rounded-xl hover:bg-green-600 transition shadow-sm">
                                    <i class="fas fa-check mr-1"></i> Setujui
                                </button>
                                <button onclick="handleReject({{ $p->id }})" class="inline-flex items-center px-4 py-2 bg-red-500 text-white text-sm font-bold rounded-xl hover:bg-red-600 transition shadow-sm">
                                    <i class="fas fa-times mr-1"></i> Tolak
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-16 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-4 opacity-50"></i>
                                <div>Tidak ada pengajuan pending</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Approve Modal --}}
<div id="approveModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-green-800 flex items-center">
                <i class="fas fa-check-circle mr-3 text-2xl"></i>
                Setujui Pengajuan
            </h3>
            <button onclick="closeModals()" class="text-gray-500 hover:text-gray-700 text-2xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="approveForm" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan (Opsional)</label>
                <textarea name="catatan" rows="3" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500"></textarea>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Response Berkas (Opsional)</label>
                <input type="file" name="response_berkas" accept=".pdf,.jpg,.jpeg,.png" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                <p class="text-xs text-gray-500 mt-1">Surat persetujuan / file tambahan</p>
            </div>
            <div class="flex space-x-4">
                <button type="submit" class="flex-1 bg-green-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-green-600 shadow-lg transition">
                    <i class="fas fa-check mr-2"></i> Setujui
                </button>
                <button type="button" onclick="closeModals()" class="flex-1 bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-bold hover:bg-gray-400 transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Reject Modal --}}
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-red-800 flex items-center">
                <i class="fas fa-times-circle mr-3 text-2xl"></i>
                Tolak Pengajuan
            </h3>
            <button onclick="closeModals()" class="text-gray-500 hover:text-gray-700 text-2xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan Penolakan *</label>
                <textarea name="catatan" rows="3" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500" required></textarea>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Response Berkas (Opsional)</label>
                <input type="file" name="response_berkas" accept=".pdf,.jpg,.jpeg,.png" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500">
                <p class="text-xs text-gray-500 mt-1">Surat penolakan / file tambahan</p>
            </div>
            <div class="flex space-x-4">
                <button type="submit" class="flex-1 bg-red-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-red-600 shadow-lg transition">
                    <i class="fas fa-times mr-2"></i> Tolak
                </button>
                <button type="button" onclick="closeModals()" class="flex-1 bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-bold hover:bg-gray-400 transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let currentPengajuanId = null;

function handleApprove(id) {
    currentPengajuanId = id;
    document.getElementById('approveForm').action = `/pengajuan/${id}/approve`;
    document.getElementById('approveModal').classList.remove('hidden');
}

function handleReject(id) {
    currentPengajuanId = id;
    document.getElementById('rejectForm').action = `/pengajuan/${id}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeModals() {
    document.getElementById('approveModal').classList.add('hidden');
    document.getElementById('rejectModal').classList.add('hidden');
    currentPengajuanId = null;
}
</script>
@endsection
