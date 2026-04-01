@extends('app')

@section('title', 'Admin Dashboard - Super Admin')

@section('page_title', 'Super Admin Dashboard')

@section('content')
<div class="space-y-8">
    {{-- Hero Metrics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-8 rounded-2xl shadow-xl text-center">
            <i class="fas fa-users text-4xl mb-4 opacity-90"></i>
            <div class="text-4xl font-black">{{ $metrics['total_users'] ?? 0 }}</div>
            <div class="text-blue-100 font-bold text-lg">Total Users</div>
        </div>
        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-8 rounded-2xl shadow-xl text-center">
            <i class="fas fa-user-graduate text-4xl mb-4 opacity-90"></i>
            <div class="text-4xl font-black">{{ $metrics['total_kadet'] ?? 0 }}</div>
            <div class="text-green-100 font-bold text-lg">Total Kadet</div>
        </div>
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white p-8 rounded-2xl shadow-xl text-center">
            <i class="fas fa-chalkboard-teacher text-4xl mb-4 opacity-90"></i>
            <div class="text-4xl font-black">{{ $metrics['total_dosen'] ?? 0 }}</div>
            <div class="text-purple-100 font-bold text-lg">Total Dosen</div>
        </div>
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 text-white p-8 rounded-2xl shadow-xl text-center">
            <i class="fas fa-user-tie text-4xl mb-4 opacity-90"></i>
            <div class="text-4xl font-black">{{ $metrics['total_staff'] ?? 0 }}</div>
            <div class="text-orange-100 font-bold text-lg">Total Staff</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Cohort Chart --}}
        <div class="bg-white p-8 rounded-2xl shadow-lg">
            <h3 class="text-2xl font-bold mb-6 flex items-center">
                <i class="fas fa-chart-pie mr-3 text-blue-500"></i>Kadet per Cohort
            </h3>
            <canvas id="cohortChart" height="300"></canvas>
        </div>

        {{-- Storage Graph --}}
        <div class="bg-white p-8 rounded-2xl shadow-lg">
            <h3 class="text-2xl font-bold mb-6 flex items-center">
                <i class="fas fa-hdd mr-3 text-green-500"></i>Penyimpanan
            </h3>
            <div class="text-center">
                <div class="text-5xl font-black text-gray-800 mb-4" id="storagePercent">0%</div>
                <div class="w-full bg-gray-200 rounded-full h-4 mb-6">
                    <div class="bg-gradient-to-r from-red-500 to-orange-500 h-4 rounded-full" id="storageBar" style="width: 0%"></div>
                </div>
                <div class="grid grid-cols-3 gap-4 text-sm">
                    <div>Used: <span id="usedGB">-</span></div>
                    <div>Free: <span id="freeGB">-</span></div>
                    <div>Total: <span id="totalGB">-</span></div>
                </div>
            </div>
            <canvas id="storageChart" height="200" class="mt-8"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Recent Activity Log --}}
        <div class="bg-white p-8 rounded-2xl shadow-lg">
            <h3 class="text-2xl font-bold mb-6 flex items-center">
                <i class="fas fa-history mr-3 text-purple-500"></i>Log Aktivitas Terbaru
            </h3>
            <div class="space-y-4 max-h-96 overflow-y-auto">
                @forelse($recentActivity ?? [] as $log)
                    <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-blue-500 rounded-xl flex items-center justify-center text-white font-bold text-sm">
                            {{ substr($log->user_name ?? 'User', 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-gray-900 truncate">{{ $log->user_name ?? 'Unknown' }}</div>
                            <div class="text-sm text-gray-600">{{ $log->activity ?? '-' }}</div>
                        </div>
                        <div class="text-xs text-gray-400 whitespace-nowrap">
                            {{ $log->created_at->diffForHumans() ?? 'Baru' }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-400">
                        <i class="fas fa-clock text-4xl mb-4 opacity-50"></i>
                        <p>Tidak ada aktivitas</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white p-8 rounded-2xl shadow-xl space-y-6">
            <h3 class="text-2xl font-bold flex items-center">
                <i class="fas fa-bolt mr-3"></i>Quick Actions
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('admin.users') }}" class="group p-6 bg-white/20 backdrop-blur rounded-xl hover:bg-white/30 transition-all">
                    <i class="fas fa-users text-2xl mb-3 group-hover:scale-110 transition"></i>
                    <div class="font-bold text-lg">Kelola Users</div>
                    <div class="text-sm opacity-90">CRUD + Reset Pass</div>
                </a>
                <a href="{{ route('pengajuan.index') }}" class="group p-6 bg-white/20 backdrop-blur rounded-xl hover:bg-white/30 transition-all">
                    <i class="fas fa-file-alt text-2xl mb-3 group-hover:scale-110 transition"></i>
                    <div class="font-bold text-lg">Pengajuan</div>
                    <div class="text-sm opacity-90">Monitor Semua</div>
                </a>
                <button onclick="impersonate('kadet')" class="group p-6 bg-white/20 backdrop-blur rounded-xl hover:bg-white/30 transition-all">
                    <i class="fas fa-user-secret text-2xl mb-3 group-hover:scale-110 transition"></i>
                    <div class="font-bold text-lg">Impersonate Kadet</div>
                    <div class="text-sm opacity-90">Test as Kadet</div>
                </button>
                <button onclick="impersonate('staff_prodi')" class="group p-6 bg-white/20 backdrop-blur rounded-xl hover:bg-white/30 transition-all">
                    <i class="fas fa-user-tie text-2xl mb-3 group-hover:scale-110 transition"></i>
                    <div class="font-bold text-lg">Impersonate Staff</div>
                    <div class="text-sm opacity-90">Test Staff</div>
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctxCohort = document.getElementById('cohortChart').getContext('2d');
new Chart(ctxCohort, {
    type: 'doughnut',
    data: {
        labels: {{ json_encode(array_keys($cohortStats ?? [])) }},
        datasets: [{
            data: {{ json_encode(array_values($cohortStats ?? [])) }},
            backgroundColor: ['#3B82F6', '#8B5CF6', '#EC4899', '#F59E0B', '#10B981', '#EF4444'],
        }]
    },
    options: { responsive: true }
});

const storageData = {{ json_encode($storageStats ?? []) }};
document.getElementById('storagePercent').textContent = storageData.percent_used + '%';
document.getElementById('storageBar').style.width = storageData.percent_used + '%';
document.getElementById('usedGB').textContent = (storageData.used / 1073741824).toFixed(1) + 'GB';
document.getElementById('freeGB').textContent = (storageData.free / 1073741824).toFixed(1) + 'GB';
document.getElementById('totalGB').textContent = (storageData.total / 1073741824).toFixed(1) + 'GB';

function impersonate(role) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("admin.impersonate") }}';
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'impersonate_role';
    input.value = role;
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
}
</script>
@endsection
