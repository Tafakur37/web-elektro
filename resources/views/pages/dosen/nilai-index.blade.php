@extends('app')

@section('title', 'Input Nilai - Dosen')

@section('page_title', 'Input Nilai')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-12">
    <div class="max-w-6xl mx-auto">
@if(!$semester)
            {{-- Stage 1: Semester --}}
            <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl p-12 text-center border border-white/50 max-w-2xl mx-auto">
                <i class="fas fa-calendar-alt text-6xl text-purple-500 mb-8"></i>
                <h1 class="text-4xl font-bold text-gray-800 mb-6">Pilih Semester</h1>
                <p class="text-xl text-gray-600 mb-8">Mulai dengan memilih semester mata kuliah</p>
                <form method="GET">
                    <select name="semester" class="w-full p-6 text-xl rounded-3xl bg-white shadow-xl border-0 focus:ring-4 ring-purple-300 font-bold mb-6" required>
                        <option value="">-- Pilih Semester --</option>
                        @foreach($semesters as $s)
                            <option value="{{ $s }}">Semester {{ $s }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full bg-purple-600 text-white py-6 rounded-3xl text-xl font-bold shadow-2xl hover:bg-purple-700 transition">
                        <i class="fas fa-arrow-right mr-3"></i>Lanjut ke Matkul
                    </button>
                </form>
            </div>
        @elseif(!$matkul)
            {{-- Matkul --}}
            <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-white/50">
                <div class="mb-12">
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">Pilih Matkul</h1>
                    <p class="text-2xl text-gray-600 font-semibold">Semester {{ $semester }} • {{ count($matkuls) }} matkul tersedia</p>
                </div>
                <form method="GET" id="matkulForm">
                    <input type="hidden" name="semester" value="{{ $semester }}">
                    <div class="relative mb-6">
                        <input type="text" id="searchMatkul" placeholder="Cari matkul (Fisika, Rangkaian...)" class="w-full pl-12 pr-6 py-5 text-xl rounded-3xl border-2 border-gray-200 focus:border-emerald-400 focus:ring-4 ring-emerald-200 shadow-lg font-bold bg-white">
                    </div>
                    <div id="matkulList" class="max-h-96 overflow-y-auto space-y-3 p-6 bg-gray-50 rounded-3xl border-2 border-gray-200 shadow-inner">
                        @foreach($matkuls as $m)
                            <div class="matkul-item p-6 cursor-pointer rounded-2xl hover:bg-emerald-50 border border-transparent hover:border-emerald-300 transition group" data-name="{{ $m['nama_matkul'] ?? $m }}">
                                <div class="text-2xl font-bold">{{ $m['nama_matkul'] ?? $m }}</div>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="matkul" id="matkulValue">
                    <button type="submit" id="lanjutBtn" class="w-full mt-8 bg-emerald-600 text-white py-6 px-8 rounded-3xl text-2xl font-bold shadow-2xl hover:bg-emerald-700 hover:shadow-3xl transition disabled:opacity-50" disabled>
                        <i class="fas fa-arrow-right mr-4"></i>Lanjut ke Kadet
                    </button>
                </form>
                
                <script>
                    const items = document.querySelectorAll('.matkul-item');
                    const search = document.getElementById('searchMatkul');
                    const hidden = document.getElementById('matkulValue');
                    const btn = document.getElementById('lanjutBtn');
                    
                    search.addEventListener('input', e => {
                        const q = e.target.value.toLowerCase();
                        items.forEach(item => {
                            const text = item.dataset.name.toLowerCase();
                            item.style.display = q === '' || text.startsWith(q) ? '' : 'none';
                        });
                        btn.disabled = true;
                        hidden.value = '';
                        items.forEach(i => i.classList.remove('bg-emerald-100', 'ring-4', 'ring-emerald-400'));
                    });
                    
                    document.getElementById('matkulList').addEventListener('click', e => {
                        const item = e.target.closest('.matkul-item');
                        if (item) {
                            items.forEach(i => i.classList.remove('bg-emerald-100', 'ring-4', 'ring-emerald-400'));
                            item.classList.add('bg-emerald-100', 'ring-4', 'ring-emerald-400');
                            hidden.value = item.dataset.name;
                            btn.disabled = false;
                        }
                    });
                </script>
                
                <a href="{{ route('dosen.nilai.index', ['semester' => $semester]) }}" class="block text-center mt-12 text-gray-600 hover:text-gray-800 font-bold py-4">
                    <i class="fas fa-arrow-left mr-3"></i>Ganti Semester
                </a>
            </div>
        @elseif(!$cohort)
            {{-- Stage 3: Cohort --}}
            <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl p-12 text-center border border-white/50 max-w-2xl mx-auto">
                <i class="fas fa-users text-6xl text-indigo-500 mb-8"></i>
                <h1 class="text-4xl font-bold text-gray-800 mb-6">Pilih Cohort</h1>
                <p class="text-xl text-gray-600 mb-8">Semester {{ $semester }} • {{ $matkul }}</p>
                <form method="GET">
                    <input type="hidden" name="semester" value="{{ $semester }}">
                    <input type="hidden" name="matkul" value="{{ $matkul }}">
                    <select name="cohort" class="w-full p-6 text-xl rounded-3xl bg-white shadow-xl border-0 focus:ring-4 ring-indigo-300 font-bold mb-6" required>
                        <option value="">-- Cohort --</option>
                        @foreach($cohorts as $c)
                            <option value="{{ $c }}">Cohort {{ $c }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full bg-indigo-600 text-white py-6 rounded-3xl text-xl font-bold shadow-2xl hover:bg-indigo-700 transition">
                        <i class="fas fa-arrow-right mr-3"></i>Lihat Mahasiswa
                    </button>
                </form>
                <a href="{{ route('dosen.nilai.index', ['semester' => $semester]) }}" class="block mt-8 text-indigo-600 hover:text-indigo-800 font-bold">
                    <i class="fas fa-arrow-left mr-2"></i>Ganti Matkul
                </a>
            </div>
        @else
            {{-- Kadet List --}}
            <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-white/50">
                <div class="mb-12">
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">Daftar Mahasiswa - {{ $matkul }}</h1>
                    <p class="text-2xl text-gray-600 font-semibold">Semester {{ $semester }} • Cohort {{ $cohort }} ({{ count($kadets ?? []) }} mahasiswa)</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($kadets ?? [] as $kadet)
                        <a href="{{ route('dosen.nilai.form', $kadet->id) }}?semester={{ $semester }}&cohort={{ $cohort }}&matkul={{ $matkul }}" class="group bg-gradient-to-br from-blue-500 to-indigo-600 text-white p-8 rounded-3xl hover:from-blue-600 hover:to-indigo-700 shadow-2xl hover:shadow-3xl hover:-translate-y-2 transition-all duration-300 text-center">
                            <div class="w-24 h-24 bg-white/20 rounded-3xl mx-auto mb-6 flex items-center justify-center text-3xl font-bold shadow-lg group-hover:bg-white/30">
                                {{ strtoupper(substr($kadet->name, 0, 1)) }}
                            </div>
                            <h3 class="text-2xl font-bold mb-2">{{ $kadet->name }}</h3>
                            <p class="text-lg font-mono mb-6 opacity-90">{{ $kadet->identifier }}</p>
                            <span class="px-6 py-3 bg-white/30 rounded-2xl font-bold text-lg">Input Nilai</span>
                        </a>
                    @empty
                        <div class="col-span-full text-center py-24">
                            <i class="fas fa-users-slash text-8xl text-gray-400 mb-8"></i>
                            <h2 class="text-4xl font-bold text-gray-600 mb-4">Tidak Ada Kadet</h2>
                            <p class="text-xl text-gray-500">Cohort {{ $cohort }} belum memiliki data kadet.</p>
                        </div>
                    @endforelse
                </div>
                <div class="text-center mt-16">
                    <a href="{{ route('dosen.nilai.index', ['semester' => $semester, 'matkul' => $matkul]) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-12 py-4 rounded-3xl font-bold text-xl shadow-xl hover:shadow-2xl transition mr-4">
                        <i class="fas fa-book mr-3"></i>Ganti Cohort
                    </a>
                    <a href="{{ route('dosen.nilai.index', ['semester' => $semester]) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-12 py-4 rounded-3xl font-bold text-xl shadow-xl hover:shadow-2xl transition">
                        <i class="fas fa-calendar-alt mr-3"></i>Ganti Matkul
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

