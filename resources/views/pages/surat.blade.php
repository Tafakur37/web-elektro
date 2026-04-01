@extends('app')

@section('title', 'Surat & Berkas - Pengajuan')

@section('page_title', 'Pengajuan Surat & Berkas')

@section('content')
<div class="space-y-8">
    {{-- Create Form --}}
    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-plus-circle text-green-500 mr-3"></i>
            Ajukan Baru
        </h3>
        
        <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Pengajuan *</label>
                    <select name="type" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="">Pilih...</option>
                        <option value="pesiar">Pesiar</option>
                        <option value="ib">Izin Bermalam (IB)</option>
                        <option value="lwe">Long Weekend End (LWE)</option>
                    </select>
                    @error('type') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Berkas (Opsional)</label>
                    <input type="file" name="berkas" accept=".pdf,.jpg,.jpeg,.png" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                    @error('berkas') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    <p class="text-xs text-gray-500 mt-1">Max 2MB: PDF, JPG, PNG</p>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan / Keterangan *</label>
                <textarea name="alasan" rows="5" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical" placeholder="Jelaskan detail pengajuan Anda..." required></textarea>
                @error('alasan') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-3 rounded-xl font-bold text-lg hover:from-green-600 hover:to-emerald-700 shadow-lg transition-all">
                <i class="fas fa-paper-plane mr-2"></i> Kirim Pengajuan
            </button>
        </form>
    </div>

    {{-- List Pengajuan --}}
    <div class="bg-white p-8 rounded-xl shadow-lg">
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-list text-blue-500 mr-3"></i>
                Riwayat Pengajuan ({{ $pengajuan->count() ?? 0 }})
            </h3>
            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-6 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        @if($pengajuan && $pengajuan->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4 text-left font-bold text-gray-700 rounded-l-xl">Jenis</th>
                            <th class="p-4 text-left font-bold text-gray-700">Status</th>
                            <th class="p-4 text-left font-bold text-gray-700">Tanggal</th>
                            <th class="p-4 text-left font-bold text-gray-700">Staff</th>
                            <th class="p-4 text-left font-bold text-gray-700 rounded-r-xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengajuan ?? [] as $p)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4 font-semibold">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-bold">
                                        {{ ucfirst(str_replace('_', ' ', $p->type)) }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    @php $statusClass = $p->status == 'approved' ? 'bg-green' : ($p->status == 'rejected' ? 'bg-red' : 'bg-yellow'); @endphp
                                    <span class="px-3 py-1 bg-{{ $statusClass }}-100 text-{{ $statusClass }}-800 rounded-full text-xs font-bold">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>
                                <td class="p-4 text-gray-600">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                                <td class="p-4">
                                    {{ $p->staffProdi?->name ?? '-' }}
                                </td>
                                <td class="p-4 space-x-2">
                                    <a href="{{ route('pengajuan.show', $p) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                                        <i class="fas fa-eye mr-1"></i> Lihat
                                    </a>
                                    @if($p->berkas_path)
                                        <a href="{{ Storage::url($p->berkas_path) }}" target="_blank" class="text-green-600 hover:text-green-800 ml-2">
                                            <i class="fas fa-download mr-1"></i> Berkas
                                        </a>
                                    @endif
                                    @if($p->response_berkas_path)
                                        <a href="{{ Storage::url($p->response_berkas_path) }}" target="_blank" class="text-orange-600 hover:text-orange-800 ml-2">
                                            <i class="fas fa-file-alt mr-1"></i> Response
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-16">
                <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
                <h4 class="text-lg font-bold text-gray-600 mb-2">Belum ada pengajuan</h4>
                <p class="text-gray-500">Ajukan pengajuan pertama Anda di atas.</p>
            </div>
        @endif
    </div>
</div>
@endsection

