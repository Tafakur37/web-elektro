@extends('app')

@section('title', 'Form Input Nilai - Dosen')

@section('page_title', 'Input Nilai: ' . ($kadet->name ?? '') . ' - ' . ($matkul ?? ''))

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white p-8 rounded-xl shadow-lg border mb-8">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-blue-900">{{ $kadet->name }}</h2>
            <p class="text-lg text-gray-600">{{ $kadet->identifier }}</p>
            <p class="text-sm text-gray-500">Cohort {{ $cohort }}</p>
        </div>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-lg border">
        <form method="POST" action="{{ route('dosen.nilai.store') }}" class="space-y-6">
            @csrf
            
            <input type="hidden" name="user_id" value="{{ $kadet->id }}">
            <input type="hidden" name="nama_matkul" value="{{ $matkul }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nilai Tugas (20%) <span class="text-red-500">*</span></label>
                    <input type="number" name="tugas" value="{{ old('tugas', $nilai->tugas ?? '') }}" step="0.01" min="0" max="100" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('tugas') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Remedial UTS</label>
                    <label class="flex items-center">
                        <input type="checkbox" name="remedial_uts" {{ old('remedial_uts', $nilai->remedial_uts ?? false) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Ya (70% bobot)</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nilai UTS (35%) <span class="text-red-500">*</span></label>
                    <input type="number" name="uts" value="{{ old('uts', $nilai->uts ?? '') }}" step="0.01" min="0" max="100" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('uts') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Remedial UAS</label>
                    <label class="flex items-center">
                        <input type="checkbox" name="remedial_uas" {{ old('remedial_uas', $nilai->remedial_uas ?? false) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Ya (70% bobot)</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nilai UAS (45%) <span class="text-red-500">*</span></label>
                <input type="number" name="uas" value="{{ old('uas', $nilai->uas ?? '') }}" step="0.01" min="0" max="100" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                @error('uas') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

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
            @endif

            <div class="flex space-x-4 pt-6">
                <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition">
                    <i class="fas fa-calculator mr-2"></i> Hitung & Simpan Nilai
                </button>
                <a href="{{ route('dosen.nilai.index', ['cohort' => $cohort]) }}" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg text-center transition">
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
document.addEventListener('DOMContentLoaded', function() {
    // Live total calculation
    const form = document.querySelector('form');
    const inputs = ['tugas', 'uts', 'uas'];
    const checkboxes = ['remedial_uts', 'remedial_uas'];

    function calculateTotal() {
        let tugas = parseFloat(form.querySelector('[name="tugas"]').value) || 0;
        let uts = parseFloat(form.querySelector('[name="uts"]').value) || 0;
        let uas = parseFloat(form.querySelector('[name="uas"]').value) || 0;
        let remUts = form.querySelector('[name="remedial_uts"]').checked;
        let remUas = form.querySelector('[name="remedial_uas"]').checked;

        // Weights
        let finalUts = remUts ? uts * 0.7 : uts;
        let finalUas = remUas ? uas * 0.7 : uas;

        let total = (tugas * 0.2) + (finalUts * 0.35) + (finalUas * 0.45);
        let grade = total >= 90 ? 'A' : total >= 80 ? 'B' : total >= 70 ? 'C' : total >= 60 ? 'D' : 'E';

        // Show preview (add if needed)
        console.log(`Total: ${total.toFixed(2)} (${grade})`);
    }

    inputs.forEach(name => {
        form.querySelector(`[name="${name}"]`).addEventListener('input', calculateTotal);
    });
    checkboxes.forEach(name => {
        form.querySelector(`[name="${name}"]`).addEventListener('change', calculateTotal);
    });
});
</script>

@endsection

