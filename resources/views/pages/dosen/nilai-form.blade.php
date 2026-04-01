@extends('app')

@section('title', 'Form Input Nilai - Dosen')

@section('page_title', 'Input Nilai: ' . ($kadet->name ?? '') . ' - ' . ($matkul ?? ''))

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white p-8 rounded-xl shadow-lg border mb-8">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-blue-900">{{ $kadet->name }}</h2>
            <p class="text-lg text-gray-600">{{ $kadet->identifier }}</p>
            <p class="text-lg text-gray-600">Semester {{ $semester }} | {{ $matkul }}</p>
            <p class="text-sm text-gray-500">Cohort {{ $cohort }} • {{ $kadet->identifier }}</p>
        </div>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-lg border">
        <form method="POST" action="{{ route('dosen.nilai.store') }}" class="space-y-6">
            @csrf
            
            <input type="hidden" name="user_id" value="{{ $kadet->id }}">
            <input type="hidden" name="nama_matkul" value="{{ $matkul }}">
            <input type="hidden" name="semester" value="{{ old('semester', $semester) }}">

            {{-- Tugas --}}
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Nilai Tugas (20%) <span class="text-red-500">*</span></label>
                <input type="number" name="tugas" value="{{ old('tugas', $nilai->tugas ?? '') }}" step="0.01" min="0" max="100" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" oninput="calcIPS()">
                @error('tugas') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- UTS --}}
            <div id="uts-section" class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Nilai UTS (35%) <span class="text-red-500">*</span></label>
                <input type="number" name="uts" value="{{ old('uts', $nilai->uts ?? '') }}" step="0.01" min="0" max="100" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" oninput="toggleRemedial(this, 'uts')">
                @error('uts') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Remedial UTS --}}
            <div id="remedial-uts-container" class="mb-6 hidden ml-4 pl-6 border-l-4 border-yellow-400 bg-yellow-50 rounded">
                <label class="block text-sm font-bold text-yellow-800 mb-2">Nilai Remedial UTS</label>
                <input type="number" name="remedial_uts" value="{{ old('remedial_uts', $nilai->remedial_uts ?? '') }}" step="0.01" min="0" max="100" class="w-full p-3 border border-yellow-300 rounded-lg focus:ring-2 focus:ring-yellow-500 bg-yellow-100">
                @error('remedial_uts') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- UAS --}}
            <div id="uas-section" class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Nilai UAS (45%) <span class="text-red-500">*</span></label>
                <input type="number" name="uas" value="{{ old('uas', $nilai->uas ?? '') }}" step="0.01" min="0" max="100" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" oninput="toggleRemedial(this, 'uas')">
                @error('uas') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Remedial UAS --}}
            <div id="remedial-uas-container" class="mb-6 hidden ml-4 pl-6 border-l-4 border-yellow-400 bg-yellow-50 rounded">
                <label class="block text-sm font-bold text-yellow-800 mb-2">Nilai Remedial UAS</label>
                <input type="number" name="remedial_uas" value="{{ old('remedial_uas', $nilai->remedial_uas ?? '') }}" step="0.01" min="0" max="100" class="w-full p-3 border border-yellow-300 rounded-lg focus:ring-2 focus:ring-yellow-500 bg-yellow-100">
                @error('remedial_uas') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Kehadiran --}}
            <div class="mb-6">

                <label class="block text-sm font-bold text-gray-700 mb-2">Jumlah Hadir (max 14)</label>
                <input type="number" name="jumlah_hadir" value="{{ old('jumlah_hadir', $nilai->jumlah_hadir ?? 14) }}" min="0" max="14" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" oninput="calcKehadiran(); calcIPS()">

                @error('jumlah_hadir') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <input type="hidden" name="kehadiran" id="kehadiran-hidden" value="{{ old('kehadiran', $nilai->kehadiran ?? 100) }}"> 



            @if($nilai)
                <div class="bg-gray-50 p-6 rounded-lg border">
                    <h4 class="font-bold text-lg mb-4">Nilai Sebelumnya</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div><strong>Tugas:</strong> {{ $nilai->tugas }}</div>
                        <div><strong>UTS:</strong> {{ $nilai->uts }} {{ $nilai->remedial_uts ? '(Rem)' : '' }}</div>
                        <div><strong>UAS:</strong> {{ $nilai->uas }} {{ $nilai->remedial_uas ? '(Rem)' : '' }}</div>
                        <div><strong>Total:</strong> {{ $nilai->total_nilai }} ({{ $nilai->grade }})</div>
                    </div>
                </div>

<div class="mt-6 pt-6 border-t border-gray-200">
                    <button onclick="deleteNilai({{ $nilai->id }})" type="button" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-200 flex items-center justify-center shadow-lg hover:shadow-xl cursor-pointer" title="Hapus nilai sebelumnya">
                        <i class="fas fa-trash mr-3"></i>Hapus Nilai Sebelumnya
                    </button>
                </div>
            @endif

            <div class="flex space-x-4 pt-6">
                <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition">
                    <i class="fas fa-calculator mr-2"></i> Hitung & Simpan Nilai
                </button>
                <a href="{{ route('dosen.nilai.index', ['semester' => $semester, 'matkul' => $matkul, 'cohort' => $cohort]) }}" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg text-center transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
            {{ session('success') }}
        </div>
    @endif
</div>

<script>
let ipsPreview = {
    total: 0,
    ips: 0,
    grade: 'E'
};

function toggleRemedial(input, type) {
    const value = parseFloat(input.value);
    const container = document.getElementById('remedial-' + type + '-container');
    
    if (value <= 60 && value > 0) {
        container.classList.remove('hidden');
        container.querySelector('input').required = true;
    } else {
        container.classList.add('hidden');
        container.querySelector('input').value = '';
        container.querySelector('input').required = false;
    }
    calcIPS();
}

function calcIPS() {
    const tugas = parseFloat(document.querySelector('[name="tugas"]').value) || 0;
    const uts = parseFloat(document.querySelector('[name="uts"]').value) || 0;
    const remUts = parseFloat(document.querySelector('[name="remedial_uts"]').value) || 0;
    const uas = parseFloat(document.querySelector('[name="uas"]').value) || 0;
    const remUas = parseFloat(document.querySelector('[name="remedial_uas"]').value) || 0;
    const kehadiran = parseFloat(document.querySelector('[name="kehadiran"]').value) || 100;

    const finalUts = remUts || uts;
    const finalUas = remUas || uas;
    const totalNilai = (tugas * 0.2) + (finalUts * 0.35) + (finalUas * 0.45);
    const ips = totalNilai * (kehadiran / 100);
    const grade = ips >= 90 ? 'A' : ips >= 80 ? 'B' : ips >= 70 ? 'C' : ips >= 60 ? 'D' : 'E';

    ipsPreview = { total: totalNilai.toFixed(2), ips: ips.toFixed(2), grade };
    console.log(`Total: ${ipsPreview.total}, IPS: ${ipsPreview.ips} (${grade})`);
}

document.addEventListener('DOMContentLoaded', function() {
    calcIPS(); // Initial calc
});


// Instant delete - no confirm
function deleteNilai(nilaiId) {
    const btn = event.target.closest('button');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i>Menghapus...';
    btn.disabled = true;
    
    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'DELETE');
    
    fetch(`/dosen/nilai/${nilaiId}`, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) throw new Error('HTTP ' + response.status);
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        btn.innerHTML = originalText;
        btn.disabled = false;
        alert('Gagal hapus: ' + error.message);
    });
}

</script>



@endsection

