<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Prodi Elektro</title>
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
            position: absolute;
            inset: 0;
            z-index: 5;
            pointer-events: none;
        }
    </style>
</head>

<body class="font-sans antialiased min-h-screen overflow-hidden bg-[#f3f6fb]">

    <!-- ⚡ Lightning -->
    <canvas id="lightning"></canvas>

    <!-- Background grid soft -->
    <div class="absolute inset-0 opacity-[0.05] 
        bg-[linear-gradient(to_right,#3b82f6_1px,transparent_1px),
        linear-gradient(to_bottom,#3b82f6_1px,transparent_1px)] 
        bg-[size:80px_80px]">
    </div>

    <!-- Glow halus -->
    <div class="absolute inset-0 bg-gradient-to-br from-white via-blue-50 to-blue-100"></div>

    <!-- Content -->
    <div class="relative z-10 flex items-center justify-center min-h-screen px-6">

        <!-- OUTER CARD -->
        <div class="w-full max-w-md 
            bg-gray-100 
            rounded-[2rem] 
            p-2 
            shadow-[0_20px_60px_rgba(0,0,0,0.08)]">

        <!-- INNER CARD -->
         <div class="w-full 
            bg-white 
            rounded-[1.5rem] 
            p-5 md:p-6 
            text-center">

            <!-- LOGO -->
            <div class="flex justify-center mb-6"> 
                <img src="{{ asset('image/logo.png') }}" alt="logo" class="w-28 h-28 object-contain">
            </div>

            <!-- TITLE -->
            <h1 class="text-3xl md:text-4xl font-extrabold text-yellow-750 mb-4">
                Selamat Datang di
            </h1>

            <h2 class="text-3xl md:text-4xl font-extrabold text-blue-700 mb-6 tracking-wide">
                SIMLEK
            </h2>

            <!-- SUBTITLE -->
            <p class="text-sm md:text-base text-gray-600 max-w-xl mx-auto mb-8">
                Sistem Informasi Manajemen Teknik Elketro
            </p>

            <!-- BUTTON -->
            <div class="flex flex-col sm:flex-row justify-center gap-6">

                <a href="{{ url('/auth/login/kadet') }}"
                   class="flex items-center justify-center gap-3
                   px-10 py-4 rounded-xl border border-blue-300 
                   text-blue-600 font-semibold
                   hover:bg-blue-50 transition">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor">
                        <path stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>

                    Login
                </a>

                <a href="{{ url('/auth/register/kadet') }}"
                   class="flex items-center justify-center gap-3
                   px-10 py-4 rounded-xl 
                   bg-gradient-to-r from-blue-600 to-indigo-700
                   text-white font-semibold
                   shadow-lg hover:scale-105 transition">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor">
                        <path stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>

                    Register
                </a>

            </div>

            <!-- Arrow -->
            <div class="mt-10 opacity-60">
                
            </div>

        </div>
    </div>

    <!-- ⚡ LIGHTNING SCRIPT -->
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

            while (y < canvas.height) {
                x += (Math.random() - 0.5) * 50;
                y += Math.random() * 30;
                ctx.lineTo(x, y);
            }

            ctx.strokeStyle = "rgba(59,130,246,0.5)";
            ctx.lineWidth = 1;
            ctx.shadowBlur = 10;
            ctx.shadowColor = "#3b82f6";
            ctx.stroke();
        }

        let lastStrike = 0;

        function lightningLoop(timestamp) {
            if (timestamp - lastStrike > 5000) {
                if (Math.random() > 0.8) {
                    drawLightning();
                    lastStrike = timestamp;

                    setTimeout(() => {
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                    }, 100);
                }
            }
            requestAnimationFrame(lightningLoop);
        }

        lightningLoop();
    </script>

</body>
</html>