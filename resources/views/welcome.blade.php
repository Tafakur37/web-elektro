<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Prodi Elektro</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" href="/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'ui-sans-serif', 'system-ui']
                    }
                }
            }
        }
    </script>
</head>

<body class="font-sans antialiased min-h-screen overflow-hidden bg-[#0a0a0f]">

    <!-- Background Gradient (lebih smooth & elegan) -->
    <div class="absolute inset-0 bg-gradient-to-br from-[#0a0a0f] via-[#0f172a] to-[#020617]"></div>

    <!-- Soft Glow -->
    <div class="absolute top-[-100px] left-[-100px] w-[400px] h-[400px] bg-blue-500/20 blur-[120px] rounded-full"></div>
    <div class="absolute bottom-[-120px] right-[-100px] w-[400px] h-[400px] bg-purple-500/20 blur-[120px] rounded-full"></div>

    <!-- Decorative Lines -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-1/4 left-0 w-full h-px bg-white"></div>
        <div class="absolute bottom-1/4 left-0 w-full h-px bg-white"></div>
    </div>

    <!-- Floating Particles -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-10 w-2 h-2 bg-blue-400 rounded-full opacity-40 animate-pulse"></div>
        <div class="absolute top-40 right-20 w-1.5 h-1.5 bg-purple-400 rounded-full opacity-30 animate-pulse"></div>
        <div class="absolute bottom-32 left-1/4 w-2 h-2 bg-indigo-400 rounded-full opacity-40 animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-1 h-1 bg-blue-300 rounded-full opacity-30 animate-pulse"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 flex items-center justify-center min-h-screen px-6">

        <!-- Glass Card -->
        <div class="w-full max-w-3xl backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-10 md:p-14 shadow-2xl text-center transition-all duration-500">

            <!-- Title -->
            <h1 class="text-4xl md:text-6xl font-black mb-6 leading-tight text-white">
                Selamat Datang di 
                <span class="block bg-gradient-to-r from-blue-400 via-purple-400 to-indigo-400 bg-clip-text text-transparent">
                    Web Elektro
                </span>
            </h1>

            <!-- Subtitle -->
            <p class="text-lg md:text-xl mb-10 text-white/70 leading-relaxed max-w-xl mx-auto">
                Sistem Informasi Akademik Terpadu untuk Program Studi Teknik Elektro
            </p>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">

                <a href="{{ url('/auth/login/kadet') }}" 
                   class="bg-white/10 border border-white/20 text-white px-8 py-4 rounded-xl text-base font-semibold 
                   hover:bg-white/20 hover:scale-105 transition-all duration-300 flex items-center gap-3">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>

                    Login Sekarang
                </a>

                <a href="{{ url('/auth/register/kadet') }}" 
                   class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-4 rounded-xl text-base font-semibold 
                   hover:scale-105 transition-all duration-300 flex items-center gap-3">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>

                    Daftar Baru
                </a>

            </div>

            <!-- Scroll Icon -->
            <div class="mt-10 animate-bounce">
                <svg class="w-5 h-5 mx-auto text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>

        </div>
    </div>

</body>
</html>