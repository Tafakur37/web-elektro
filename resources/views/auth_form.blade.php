<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $aksi == 'login' ? 'Login SIMLEK' : (ucfirst($aksi) . ' ' . ucfirst($role) . ' SIMLEK') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
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
    <style>
        canvas {
            position: fixed;
            inset: 0;
            z-index: 5;
            pointer-events: none;
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen overflow-y-auto bg-gradient-to-br from-white via-blue-50 to-blue-100">

    <!-- ⚡ Lightning (fixed) -->
    <canvas id="lightning"></canvas>

    <!-- Background grid soft - fixed -->
    <div class="fixed inset-0 opacity-[0.05] 
        bg-[linear-gradient(to_right,#3b82f6_1px,transparent_1px),
        linear-gradient(to_bottom,#3b82f6_1px,transparent_1px)] 
        bg-[size:80px_80px] z-0">
    </div>

    <!-- Content -->
    <div class="relative z-10 flex items-center justify-center min-h-screen px-4 py-8">

        <!-- OUTER CARD -->
        <div class="w-full max-w-md 
            bg-gray-100/80 backdrop-blur-sm
            rounded-[2rem] 
            p-2 
            shadow-[0_20px_60px_rgba(0,0,0,0.1)]">

            <!-- INNER CARD -->
            <div class="w-full 
                bg-white/90 backdrop-blur-md
                rounded-[1.5rem] 
                p-6 md:p-8">

                <!-- LOGO & TITLE -->
                <div class="text-center mb-8">
                    <div class="flex justify-center mb-6"> 
                        <img src="{{ asset('image/logo.png') }}" alt="logo" class="w-24 h-24 object-contain mx-auto shadow-lg">
                    </div>
                    <h1 class="text-2xl md:text-3xl font-black text-blue-950 mb-3 leading-tight">
                        {{ $aksi == 'login' ? 'Silakan Masuk' : 'Buat Akun ' . ucfirst($role) }}
                    </h1>
                    <h2 class="text-2xl md:text-3xl font-black text-blue-800 mb-3 tracking-tight">
                        SIMLEK
                    </h2>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        {{ $aksi == 'login' ? 'Masukkan kredensial Anda' : 'Lengkapi data registrasi' }}
                    </p>
                </div>

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-800 p-4 mb-6 rounded-2xl text-sm shadow-sm animate-pulse">
                        {{ session('error') }}
                    </div>
                @endif
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-800 p-4 mb-6 rounded-2xl text-sm shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- FORM -->
                <form action="{{ $aksi == 'login' ? route('login.post') : route('register.post') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="role" value="{{ $role }}">

                    @if($aksi == 'register')
                    <div>
                        <label class="block text-gray-800 font-semibold mb-2 text-sm">Nama Lengkap *</label>
                        <input type="text" name="name" id="nameInput" class="w-full bg-white/80 border border-gray-200 rounded-2xl px-4 py-3 focus:outline-none focus:ring-3 ring-blue-400/30 focus:border-blue-400 text-sm shadow-sm placeholder-gray-400 transition-all" placeholder="Contoh: JOHN DOE" value="{{ old('name') }}" required>
                        @error('name') <span class="text-red-500 text-xs block mt-1 font-medium">{{ $message }}</span> @enderror
                    </div>
                    @endif

                    <div id="loginFields">
                        <label id="identifierLabel" class="block text-gray-800 font-semibold mb-2 text-sm">
                            {{ $aksi == 'login' ? 'Username/NIM/NIP' : ($role == 'kadet' ? 'NIM' : 'NIP / ID User') }} *
                        </label>
                        <input type="text" id="identifierInput" name="identifier" class="w-full bg-white/80 border border-gray-200 rounded-2xl px-4 py-3 focus:outline-none focus:ring-3 ring-blue-400/30 focus:border-blue-400 text-sm shadow-sm placeholder-gray-400 transition-all" placeholder="{{ $aksi == 'login' ? 'Masukkan username/NIM/NIP' : ($role == 'kadet' ? '3yyyy0402xxx' : 'Masukkan ID') }}" value="{{ old('identifier') }}" required>
                        @error('identifier') <span class="text-red-500 text-xs block mt-1 font-medium">{{ $message }}</span> @enderror
                    </div>

                    @if($aksi == 'register')
                    <div>
                        <label class="block text-gray-800 font-semibold mb-2 text-sm">Email *</label>
                        <input type="email" name="email" class="w-full bg-white/80 border border-gray-200 rounded-2xl px-4 py-3 focus:outline-none focus:ring-3 ring-blue-400/30 focus:border-blue-400 text-sm shadow-sm placeholder-gray-400" placeholder="example@email.com" value="{{ old('email') }}" required>
                        @error('email') <span class="text-red-500 text-xs block mt-1 font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-800 font-semibold mb-2 text-xs">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="w-full bg-white/80 border border-gray-200 rounded-xl px-4 py-2.5 text-sm shadow-sm placeholder-gray-400" placeholder="Kota" value="{{ old('tempat_lahir') }}">
                        </div>
                        <div>
                            <label class="block text-gray-800 font-semibold mb-2 text-xs">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="w-full bg-white/80 border border-gray-200 rounded-xl px-4 py-2.5 text-sm shadow-sm" value="{{ old('tanggal_lahir') }}">
                        </div>
                    </div>
                    @endif

                    <div id="passwordField">
                        <label id="passwordLabel" class="block text-gray-800 font-semibold mb-2 text-sm">Password *</label>
                        <input type="password" id="passwordInput" name="password" class="w-full bg-white/80 border border-gray-200 rounded-2xl px-4 py-3 focus:outline-none focus:ring-3 ring-blue-400/30 focus:border-blue-400 text-sm shadow-sm placeholder-gray-400" placeholder="Masukkan password Anda" required>
                        
                        @if($aksi == 'login')
                            <div class="text-right mt-3">
                                <span class="lupa-link cursor-pointer text-sm text-blue-600 underline hover:text-blue-700 font-semibold transition-colors" onclick="toggleLupaForm()">Lupa Password?</span>
                            </div>
                            
                            <!-- Inline Password Reset Form -->
                            <div id="inlineResetForm" class="hidden mt-5 p-5 border border-blue-200/50 rounded-2xl bg-blue-50/80 backdrop-blur-sm shadow-lg">
                                <div class="text-center mb-4 text-sm font-bold text-blue-900">Reset Password</div>
                                <div class="text-xs text-gray-600 mb-4 text-center">Masukkan email terdaftar untuk link reset</div>
                                <form action="{{ route('auth.inline.reset') }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-gray-800 text-xs font-semibold mb-1.5">Email</label>
                                        <input type="email" name="email" class="w-full bg-white px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 ring-blue-400/50 focus:border-blue-400 text-sm shadow-sm placeholder-gray-400" placeholder="your@email.com" value="{{ old('email') }}" required>
                                        @error('email')
                                            <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="flex space-x-2">
                                        <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-2.5 px-4 rounded-xl font-semibold text-sm shadow-md transition-all hover:scale-[1.02]">
                                            Kirim Link Reset
                                        </button>
                                        <button type="button" onclick="toggleLupaForm()" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white py-2.5 px-4 rounded-xl font-semibold text-sm shadow-sm transition-all">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>

                    @if($aksi == 'register')
                    <div>
                        <label class="block text-gray-800 font-semibold mb-2 text-sm">Konfirmasi Password *</label>
                        <input type="password" name="password_confirmation" class="w-full bg-white/80 border border-gray-200 rounded-2xl px-4 py-3 focus:outline-none focus:ring-3 ring-blue-400/30 focus:border-blue-400 text-sm shadow-sm placeholder-gray-400" placeholder="Ulangi password" required>
                    </div>
                    @endif

                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold py-4 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-[1.02] text-lg">
                        {{ $aksi == 'login' ? '🔐 Masuk Sekarang' : '✅ Daftar Sekarang' }}
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <a href="/" class="block w-full text-center text-sm text-blue-600 hover:text-blue-700 hover:bg-blue-50 py-3 px-6 rounded-xl font-semibold transition-all mx-auto max-w-max">
                        ← Kembali ke Beranda
                    </a>
                </div>

            </div>
        </div>

    </div>

    <!-- FORM JS (original preserved) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var nameInput = document.getElementById('nameInput');
            if (nameInput) {
                nameInput.addEventListener('input', function (e) {
                    this.value = this.value.toUpperCase();
                });
            }
        });

        function toggleLupaForm() {
            const form = document.getElementById('inlineResetForm');
            const loginFields = document.getElementById('loginFields');
            const passwordField = document.getElementById('passwordField');
            
            if (form && loginFields && passwordField) {
                if (form.classList.contains('hidden')) {
                    form.classList.remove('hidden');
                    loginFields.style.display = 'none';
                    document.getElementById('passwordLabel').style.display = 'none';
                    document.getElementById('passwordInput').style.display = 'none';
                    document.getElementById('identifierInput').removeAttribute('required');
                    document.getElementById('passwordInput').removeAttribute('required');
                } else {
                    form.classList.add('hidden');
                    loginFields.style.display = 'block';
                    document.getElementById('passwordLabel').style.display = 'block';
                    document.getElementById('passwordInput').style.display = 'block';
                    document.getElementById('identifierInput').setAttribute('required', 'required');
                    document.getElementById('passwordInput').setAttribute('required', 'required');
                }
            }
        }
    </script>

    <!-- LIGHTNING ANIMATION (fixed to viewport) -->
    <script>
        const canvas = document.getElementById("lightning");
        const ctx = canvas.getContext("2d");

        function resize() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        resize();
        window.addEventListener("resize", resize);

        function drawLightning() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            let x = Math.random() * canvas.width;
            let y = 0;

            ctx.beginPath();
            ctx.moveTo(x, y);
            while (y < canvas.height * 1.2) {
                x += (Math.random() - 0.5) * 60;
                y += Math.random() * 35 + 10;
                ctx.lineTo(x, y);
            }
            ctx.strokeStyle = "rgba(59,130,246,0.4)";
            ctx.lineWidth = 1.5;
            ctx.shadowBlur = 15;
            ctx.shadowColor = "#3b82f6";
            ctx.stroke();
        }

        let lastStrike = 0;
        function lightningLoop(timestamp) {
            if (timestamp - lastStrike > 4000 + Math.random() * 2000) {
                if (Math.random() > 0.7) {
                    drawLightning();
                    lastStrike = timestamp;
                    setTimeout(() => ctx.clearRect(0, 0, canvas.width, canvas.height), 150);
                }
            }
            requestAnimationFrame(lightningLoop);
        }
        lightningLoop();
    </script>

</body>
</html>
