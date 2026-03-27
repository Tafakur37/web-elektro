<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Web Elektro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Reset Password</h2>
        @if(session('status'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4 text-sm">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 text-sm">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" class="w-full border rounded-lg px-4 py-2" placeholder="email@domain.com" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg">Kirim Link Reset</button>
        </form>
        <div class="mt-4 text-center">
            <a href="{{ url('/auth/login/kadet') }}" class="text-sm text-gray-500 underline">Kembali ke Login</a>
        </div>
    </div>
</body>
</html>