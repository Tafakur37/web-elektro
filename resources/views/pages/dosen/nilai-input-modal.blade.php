<!-- Interactive Nilai Input Modal - Fixed for Laravel Blade -->
<div id="nilaiInputModal" class="fixed inset-0 bg-black/60 z-[1000] hidden flex items-center justify-center p-4" onclick="closeNilaiModal(event)">
    <style>
        .stage { display: block; }
        .stage.hide { display: none !important; }
    </style>

    <div class="bg-white w-full max-w-4xl max-h-[90vh] rounded-2xl shadow-2xl overflow-hidden" onclick="event.stopPropagation()">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 text-white p-6 sticky top-0 z-10 shadow-lg">
            <div class="flex justify-between items-center">
                <h3 id="modalTitle" class="text-2xl font-bold flex items-center">
                    <i class="fas fa-clipboard-list mr-3"></i>
                    <span>Input Nilai Kadet</span>
                </h3>
                <button onclick="closeNilaiModal()" class="text-white hover:text-gray-200 text-2xl font-bold p-2 rounded-full hover:bg-white/20 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Content Stages -->
        <div class="p-8 overflow-y-auto max-h-[calc(90vh-120px)]">
            <!-- Stage 1: Pilih Cohort -->
            <div id="stage-cohort" class="stage">
                <div class="text-center mb-8">
                    <i class="fas fa-users text-5xl text-purple-500 mb-6 opacity-50"></i>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Pilih Cohort</h4>
                    <p class="text-gray-600">Pilih cohort mahasiswa untuk input nilai</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-2xl mx-auto">
                    @php
                        $cohortList = isset($cohorts) ? $cohorts : [5,6,7,8];
                    @endphp
                    @foreach($cohortList as $cohort)
                        <div class="group cursor-pointer p-6 border-2 border-gray-200 rounded-xl hover:border-purple-400 hover:shadow-lg transition-all hover:scale-[1.02] bg-gradient-to-b from-white to-gray-50 js-cohort-item" data-cohort="{{ $cohort }}">
                            <div class="text-3xl font-bold text-purple-600 mb-2 group-hover:text-purple-700">{{ $cohort }}</div>
                            <div class="text-sm font-bold text-gray-700 uppercase tracking-wider">Cohort {{ $cohort }}</div>
                            <div class="text-xs text-gray-500 mt-1">35 Mahasiswa</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Stage 2: Daftar Kadet -->
            <div id="stage-kadet" class="stage hide">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <button onclick="prevStage()" class="flex items-center text-purple-600 hover:text-purple-800 font-semibold">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </button>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800">Cohort <span id="selectedCohort">-</span> - Pilih Kadet</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full bg-white rounded-xl shadow-sm border border-gray-200">
                        <thead>
                            <tr class="bg-gradient-to-r from-purple-50 to-indigo-50">
                                <th class="p-4 text-left font-bold text-gray-800 border-b">Absen</th>
                                <th class="p-4 text-left font-bold text-gray-800 border-b w-full">Nama</th>
                                <th class="p-4 text-left font-bold text-gray-800 border-b">NIM</th>
                                <th class="p-4 text-center font-bold text-gray-800 border-b">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="kadetTableBody">
                            <tr><td colspan="4" class="p-8 text-center text-gray-500">Pilih cohort terlebih dahulu</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Stage 3: Form Input Nilai -->
            <div id="stage-form" class="stage hide">
                <div class="flex justify-between items-center mb-8">
                    <button onclick="prevStage()" class="flex items-center text-purple-600 hover:text-purple-800 font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </button>
                    <h4 class="text-xl font-bold text-gray-800">
                        <span id="kadetName">-</span> - <span id="formCohort">-</span>
                    </h4>
                </div>

                <form id="nilaiForm" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Mata Kuliah *</label>
                            <input type="text" name="mata_kuliah" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500" placeholder="Nama mata kuliah">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tugas (0-100)</label>
                            <input type="number" name="tugas" min="0" max="100" step="0.1" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">UTS (0-100)</label>
                            <input type="number" name="uts" min="0" max="100" step="0.1" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Remed UTS</label>
                            <input type="number" name="remed_uts" min="0" max="100" step="0.1" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">UAS (0-100)</label>
                            <input type="number" name="uas" min="0" max="100" step="0.1" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Remed UAS</label>
                            <input type="number" name="remed_uas" min="0" max="100" step="0.1" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-xl">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Total</label>
                            <div id="totalNilai" class="text-2xl font-bold text-blue-600 p-4 bg-white rounded-lg border-2 border-blue-200">0.00</div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Grade</label>
                            <div id="gradeHuruf" class="text-3xl font-black p-4 bg-gray-400 text-white rounded-xl uppercase tracking-wider">E</div>
                        </div>
                    </div>
                    <div class="flex gap-4 pt-4 border-t">
                        <button type="button" onclick="prevStage()" class="flex-1 bg-gray-500 text-white py-3 px-6 rounded-lg hover:bg-gray-600 font-semibold">Batal</button>
                        <button type="submit" class="flex-2 bg-green-600 text-white py-3 px-12 rounded-lg hover:bg-green-700 font-bold text-lg shadow-lg">Simpan Nilai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let currentStage = 1, selectedCohort = 0, selectedKadet = null;

window.openNilaiModal = () => {
    document.getElementById('nilaiInputModal').style.display = 'flex';
    currentStage = 1;
    showStage(1);
    resetForm();
};

window.closeNilaiModal = () => {
    document.getElementById('nilaiInputModal').style.display = 'none';
    resetForm();
};

function showStage(stage) {
    document.querySelectorAll('.stage').forEach(s => s.classList.add('hide'));
    document.getElementById('stage-' + stage).classList.remove('hide');
    currentStage = stage;
    document.querySelector('#modalTitle span').textContent = stage === 1 ? 'Input Nilai Kadet' : stage === 2 ? `Cohort ${selectedCohort} - Pilih Kadet` : `${selectedKadet?.name || ''} - Input Nilai`;
}

window.prevStage = () => currentStage > 1 && showStage(currentStage - 1);

document.querySelectorAll('.js-cohort-item').forEach(item => {
    item.onclick = () => {
        selectedCohort = parseInt(item.dataset.cohort);
        document.getElementById('selectedCohort').textContent = selectedCohort;
        showStage(2);
    };
});

function selectKadet(kadet) {
    selectedKadet = kadet;
    document.getElementById('kadetName').textContent = kadet.name;
    document.getElementById('formCohort').textContent = `Cohort ${selectedCohort}`;
    showStage(3);
}

function resetForm() {
    currentStage = 1;
    selectedCohort = 0;
    selectedKadet = null;
    document.getElementById('nilaiForm').reset();
    document.getElementById('totalNilai').textContent = '0.00';
    document.getElementById('gradeHuruf').textContent = 'E';
    document.getElementById('gradeHuruf').className = 'text-3xl font-black p-4 bg-gray-400 text-white rounded-xl uppercase tracking-wider';
}

document.getElementById('nilaiForm').onsubmit = e => {
    e.preventDefault();
    alert('Nilai disimpan! (Implementasi AJAX diperlukan)');
    closeNilaiModal();
};

// Auto-calculation
['tugas', 'uts', 'remed_uts', 'uas', 'remed_uas'].forEach(name => {
    document.querySelector(`[name="${name}"]`).oninput = calcTotal;
});

function calcTotal() {
    const tugas = +document.querySelector('[name="tugas"]').value || 0;
    const uts = +document.querySelector('[name="uts"]').value || 0;
    const remedUts = +document.querySelector('[name="remed_uts"]').value || 0;
    const uas = +document.querySelector('[name="uas"]').value || 0;
    const remedUas = +document.querySelector('[name="remed_uas"]').value || 0;
    const finalUTS = Math.max(uts, remedUts);
    const finalUAS = Math.max(uas, remedUas);
    const total = ((tugas * 0.2) + (finalUTS * 0.3) + (finalUAS * 0.5)).toFixed(2);
    
    document.getElementById('totalNilai').textContent = total;
    
    const grade = total >= 85 ? 'A' : total >= 75 ? 'B' : total >= 65 ? 'C' : total >= 55 ? 'D' : 'E';
    const colors = {
        'A': 'from-green-500 to-emerald-600',
        'B': 'from-blue-500 to-cyan-600', 
        'C': 'from-yellow-500 to-orange-600',
        'D': 'from-orange-500 to-red-600',
        'E': 'from-red-500 to-red-600'
    };
    const gradeEl = document.getElementById('gradeHuruf');
    gradeEl.textContent = grade;
    gradeEl.className = `text-3xl font-black p-4 bg-gradient-to-r ${colors[grade]} text-white rounded-xl uppercase tracking-wider`;
}
</script>
