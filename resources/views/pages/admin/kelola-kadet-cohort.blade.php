@extends('app')

@section('title', 'Kelola Kadet - Pilih Cohort')

@section('page_title', 'Kelola Kadet')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg p-12 text-center border border-gray-100">
        <i class="fas fa-calendar-alt text-7xl text-blue-500 mb-8 opacity-75"></i>
        <h2 class="text-4xl font-bold text-gray-800 mb-6">Pilih Cohort</h2>
        <p class="text-xl text-gray-600 mb-12">Pilih cohort kadet yang ingin Anda kelola</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($cohorts as $c)
                <a href="{{ route('admin.users') }}?role=kadet&cohort={{ $c }}" class="group bg-gradient-to-br from-emerald-500 to-green-600 text-white p-8 rounded-2xl font-bold text-xl shadow-xl hover:shadow-2xl hover:scale-[1.02] transition-all duration-300 block">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="text-2xl">Cohort {{ $c }}</div>
                </a>
            @empty
                <div class="col-span-full text-center py-16 text-gray-400">
                    <i class="fas fa-users-slash text-6xl mb-6 opacity-50"></i>
                    <p class="text-2xl font-bold mb-2">Belum ada cohort</p>
                    <p>Buat kadet pertama melalui "Buat Akun"</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12 pt-8 border-t border-gray-200">
            <a href="{{ route('admin.users') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-bold text-lg">
                <i class="fas fa-arrow-left mr-3"></i> Kembali ke Kelola User
            </a>
        </div>
    </div>
</div>
@endsection

