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
<body class="font-sans antialiased min-h-screen overflow-hidden">
    <!-- Animated Gradient Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 animate-gradient-xy"></div>
    
    <!-- Floating Particles (Electric Sparks) -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-10 w-2 h-2 bg-yellow-400 rounded-full opacity-60 animate-ping animate-pulse" style="animation-delay: 0s; animation-duration: 3s;"></div>
        <div class="absolute top-40 right-20 w-1.5 h-1.5 bg-blue-400 rounded-full opacity-50 animate-ping animate-pulse" style="animation-delay: 1s; animation-duration: 2.5s;"></div>
        <div class="absolute bottom-32 left-1/4 w-2 h-2 bg-purple-400 rounded-full opacity-70 animate-bounce animate-pulse" style="animation-delay: 2s; animation-duration: 4s;"></div>
        <div class="absolute bottom-20 right-10 w-1 h-1 bg-yellow-300 rounded-full opacity-40 animate-ping animate-pulse" style="animation-delay: 0.5s; animation-duration: 3.5s;"></div>
    </div>
    
    <!-- Main Content - Glassmorphism Hero Card -->
    <div class="relative z-10 flex items-center justify-center min-h-screen px-4 py-12">
        <div class="max-w-4xl w-full text-center transform transition-all duration-700 animate-fade-in-up">
            <!-- Hero Title -->
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black mb-6 bg-gradient-to-r from-blue-400 via-purple-400 to-indigo-400 bg-clip-text text-transparent drop-shadow-2xl leading-tight">
                Selamat Datang di 
                <span class="block text-6xl md:text-8xl lg:text-9xl bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text">Web Elektro</span>
            </h1>
            
            <!-- Subtitle -->
            <p class="text-xl md:text-2xl mb-12 text-white/90 drop-shadow-lg font-light leading-relaxed max-w-2xl mx-auto">
                Sistem Informasi Akademik Terpadu untuk Program Studi Teknik Elektro
            </p>
            
            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                <a href="{{ url('/auth/login/kadet') }}" 
                   class="group relative bg-white/20 backdrop-blur-md border border-white/30 text-white px-10 py-5 rounded-2xl text-lg font-semibold hover:bg-white/30 hover:shadow-2xl hover:scale-105 hover:shadow-blue-500/25 transition-all duration-300 flex items-center gap-3 hover:gap-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Login Sekarang
                </a>
                <a href="{{ url('/auth/register/kadet') }}" 
                   class="group bg-gradient-to-r from-green-500 to-emerald-600 text-white px-10 py-5 rounded-2xl text-lg font-semibold hover:from-green-600 hover:to-emerald-700 hover:shadow-2xl hover:scale-105 hover:shadow-emerald-500/25 transition-all duration-300 flex items-center gap-3 hover:gap-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Daftar Baru
                </a>
            </div>
            
            <!-- Scroll Indicator -->
            <div class="animate-bounce">
                <svg class="w-6 h-6 mx-auto text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <style>
        @keyframes gradient-xy {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(180deg); }
        }
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-gradient-xy {
            animation: gradient-xy 15s ease infinite;
            background-size: 400% 400%;
        }
        .animate-fade-in-up {
            animation: fade-in-up 1s ease-out forwards;
        }
    </style>
    
    <script>
        // Smooth scroll indicator trigger
        window.addEventListener('scroll', () => {
            document.querySelector('.animate-fade-in-up').style.opacity = 1;
        });
        
        // Intersection Observer for fade-in
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        });
        observer.observe(document.querySelector('.animate-fade-in-up'));
    </script>
</body>
</html>
