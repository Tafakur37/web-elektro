<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Web Elektro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Smooth scrolling disabled to prevent unwanted page scrolls */
        /* Custom scrollbar agar lebih rapi */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #1e3a8a; border-radius: 10px; }
    </style>
</head>
<body class="bg-gray-100 flex overflow-hidden">

    <aside class="w-64 bg-blue-900 min-h-screen text-white p-6 shadow-xl flex flex-col fixed h-full">
        <div class="text-center border-b border-blue-700 pb-4 mb-8">
            <h2 class="text-2xl font-bold tracking-tighter">Web Elektro</h2>
            <p class="text-[10px] uppercase text-blue-300 tracking-widest">Sistem Akademik</p>
        </div>
        
        <nav class="flex-1 space-y-2 overflow-y-auto pr-2">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 p-3 {{ Request::is('home') ? 'bg-blue-800 border-l-4 border-yellow-400' : 'hover:bg-blue-800' }} rounded-lg transition">
                <i class="fas fa-home w-5"></i> <span>Dashboard</span>
            </a>

            @if(Auth::user()->role == 'kadet')
                <div class="pt-4 pb-2 text-[10px] font-bold text-blue-400 uppercase tracking-widest">Perkuliahan</div>
                
                <a href="{{ route('bahan.ajar') }}" class="flex items-center space-x-3 p-3 {{ Request::is('bahan-ajar') ? 'bg-blue-800 border-l-4 border-yellow-400' : 'hover:bg-blue-800' }} rounded-lg transition">
                    <i class="fas fa-book-open w-5"></i> <span>Bahan Ajar</span>
                </a>
                
                <a href="{{ route('nilai') }}" class="flex items-center space-x-3 p-3 {{ Request::is('nilai') ? 'bg-blue-800 border-l-4 border-yellow-400' : 'hover:bg-blue-800' }} rounded-lg transition">
                    <i class="fas fa-graduation-cap w-5"></i> <span>Nilai</span>
                </a>
                
                <a href="{{ route('surat') }}" class="flex items-center space-x-3 p-3 {{ Request::is('surat-berkas') ? 'bg-blue-800 border-l-4 border-yellow-400' : 'hover:bg-blue-800' }} rounded-lg transition">
                    <i class="fas fa-file-alt w-5"></i> <span>Surat / Berkas</span>
                </a>
                
                <a href="{{ route('akademik') }}" class="flex items-center space-x-3 p-3 {{ Request::is('manajemen-akademik') ? 'bg-blue-800 border-l-4 border-yellow-400' : 'hover:bg-blue-800' }} rounded-lg transition">
                    <i class="fas fa-tasks w-5"></i> <span>Manajemen</span>
                </a>
            @endif

@if(in_array(Auth::user()->role, ['admin', 'kaprodi', 'sesprodi', 'staf', 'dosen', 'staff_prodi']))
                <div class="pt-4 pb-2 text-[10px] font-bold text-yellow-400 uppercase tracking-widest">Administrasi</div>
                
                <a href="{{ route('admin.kadet') }}" class="flex items-center space-x-3 p-3 hover:bg-blue-800 rounded-lg transition {{ Request::is('admin/kadet') ? 'bg-blue-800 border-l-4 border-yellow-400' : '' }}">
                    <i class="fas fa-users-cog w-5 text-yellow-500"></i> <span>Kelola Kadet</span>
                </a>
                
                <a href="{{ route('admin.upload') }}" class="flex items-center space-x-3 p-3 hover:bg-blue-800 rounded-lg transition {{ Request::is('admin/upload') ? 'bg-blue-800 border-l-4 border-yellow-400' : '' }}">
                    <i class="fas fa-upload w-5"></i> <span>Upload Materi</span>
                </a>
            @endif

            <hr class="border-blue-700 my-4">

            <a href="{{ route('akun') }}" class="flex items-center space-x-3 p-3 {{ Request::is('akun') ? 'bg-blue-800 border-l-4 border-yellow-400' : 'hover:bg-blue-800' }} rounded-lg transition">
                <i class="fas fa-user-circle w-5"></i> <span>Akun Profil</span>
            </a>

            <form action="{{ route('logout') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-3 p-3 bg-red-600 hover:bg-red-700 rounded-lg transition text-sm font-bold shadow-lg">
                    <i class="fas fa-sign-out-alt w-5"></i> <span>Keluar</span>
                </button>
            </form>
        </nav>
    </aside>

    <main class="flex-1 ml-64 p-10 h-screen overflow-y-auto">
        <header class="flex justify-between items-center mb-10 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">@yield('page_title', 'Selamat Datang')</h1>
                <p class="text-xs text-gray-400 italic">Web Manajemen Prodi Teknik Elektro</p>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-sm font-bold text-gray-700">{{ auth()->user()->name ?? $user->name ?? 'User' }}</p>
                    <p class="text-[10px] text-blue-600 font-bold uppercase tracking-widest">{{ auth()->user()->role ?? $user->role ?? 'User' }}</p>
                </div>

                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-900 font-bold border-2 border-white shadow-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <div class="animate-fadeIn">
            @yield('content')
        </div>

        <footer class="mt-20 pt-8 border-t border-gray-200 text-center text-gray-400 text-xs pb-10">
            &copy; 2026 Teknik Elektro. Sistem ini dikelola secara internal.
        </footer>
    </main>

</body>
</html>