<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $aksi == 'login' ? 'Login' : (ucfirst($aksi) . ' ' . ucfirst($role)) }} - Web Elektro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-blue-900">{{ $aksi == 'login' ? 'Login' : (ucfirst($aksi) . ' ' . ucfirst($role)) }}</h2>
            <p class="text-gray-500 text-sm">Silakan masukkan data dirimu di bawah ini</p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 text-sm">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4 text-sm">{{ session('success') }}</div>
        @endif

        <form action="{{ $aksi == 'login' ? route('login.post') : route('register.post') }}" method="POST">
            @csrf
            <input type="hidden" name="role" value="{{ $role }}">

            @if($aksi == 'register')
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Nama Lengkap</label>
                <input type="text" name="name" id="nameInput" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: NAMA TERANG" value="{{ old('name') }}" required>
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            @endif

            <div id="loginFields" class="mb-4">
                <label id="identifierLabel" class="block text-gray-700 font-semibold mb-1">
                    {{ $aksi == 'login' ? 'Username' : ($role == 'kadet' ? 'NIM' : 'NIP / ID User') }}
                </label>
                <input type="text" id="identifierInput" name="identifier" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="{{ $aksi == 'login' ? 'Masukkan username Anda' : ($role == 'kadet' ? '3yyyy0402xxx' : 'Masukkan ID') }}" value="{{ old('identifier') }}" required>
                @error('identifier') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            @if($aksi == 'register')
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="email@contoh.com" value="{{ old('email') }}" required>
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-3 mb-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="w-full border rounded-lg px-4 py-2 text-sm" placeholder="Kota" value="{{ old('tempat_lahir') }}">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Tgl Lahir</label>
                    <input type="date" name="tanggal_lahir" class="w-full border rounded-lg px-4 py-2 text-sm" value="{{ old('tanggal_lahir') }}">
                </div>
            </div>
            @endif

            <div id="passwordField" class="mb-4">
                <label id="passwordLabel" class="block text-gray-700 font-semibold mb-1">Password</label>
                <input type="password" id="passwordInput" name="password" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan password Anda" required>
 @if($aksi == 'login')
                    <div class="text-right mt-2">
                        <span class="lupa-link cursor-pointer text-sm text-blue-600 underline hover:text-blue-800 select-none" onclick="toggleLupaForm()">Lupa Password?</span>
                    </div>
                    
                    <!-- Inline Password Reset Form -->
                    <div id="inlineResetForm" class="hidden mt-4 p-4 border border-gray-300 rounded-lg bg-blue-50">
                        <div class="text-center mb-3 text-sm font-semibold text-blue-900">Masukkan email terdaftar untuk reset password</div>
                        <form action="{{ route('auth.inline.reset') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-gray-700 text-sm font-semibold mb-1">Email</label>
                                <input type="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="contoh@email.com" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex space-x-2 pt-2">
                                <button type="submit" formnovalidate class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-semibold text-sm transition duration-200">
                                    Kirim Form Reset
                                </button>
                                <button type="button" onclick="toggleLupaForm()" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white py-2 px-4 rounded-lg font-semibold text-sm transition duration-200">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

            @if($aksi == 'register')
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ulangi password" required>
            </div>
            @endif

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-200">
                {{ $aksi == 'login' ? 'Login' : (ucfirst($aksi) . ' Sekarang') }}
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="/" class="text-sm text-gray-500 hover:text-blue-600 underline">Kembali ke Beranda</a>
        </div>
    </div>

<script>
    // Ubah input nama menjadi uppercase saat mengetik
    document.addEventListener('DOMContentLoaded', function () {
        var nameInput = document.getElementById('nameInput');
        if (nameInput) {
            nameInput.addEventListener('input', function (e) {
                this.value = this.value.toUpperCase();
            });
        }
    });

    // Toggle lupa password form
    function toggleLupaForm() {
        const form = document.getElementById('inlineResetForm');
        const loginFields = document.getElementById('loginFields');
        const passwordField = document.getElementById('passwordField');
        
        if (form && loginFields && passwordField) {
            if (form.classList.contains('hidden')) {
                // Show reset form, hide login fields
                form.classList.remove('hidden');
                loginFields.style.display = 'none';
                document.getElementById('passwordLabel').style.display = 'none';
                document.getElementById('passwordInput').style.display = 'none';
                
                // Remove required attributes
                document.getElementById('identifierInput').removeAttribute('required');
                document.getElementById('passwordInput').removeAttribute('required');
            } else {
                // Hide reset form, show login fields
                form.classList.add('hidden');
                loginFields.style.display = 'block';
                document.getElementById('passwordLabel').style.display = 'block';
                document.getElementById('passwordInput').style.display = 'block';
                
                // Restore required attributes
                document.getElementById('identifierInput').setAttribute('required', 'required');
                document.getElementById('passwordInput').setAttribute('required', 'required');
            }
        }
    }
</script>

</body>
</html>