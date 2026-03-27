<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Inline styles for email compatibility */
        .bg-gray-100 { background-color: #f3f4f6; }
        .bg-white { background-color: white; }
        .text-gray-700 { color: #374151; }
        .border { border-width: 1px; border-color: #d1d5db; }
        .rounded-lg { border-radius: 0.5rem; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .bg-blue-600 { background-color: #2563eb; }
        .hover\\:bg-blue-700:hover { background-color: #1d4ed8; }
        .text-white { color: white; }
        .font-bold { font-weight: bold; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .text-red-500 { color: #ef4444; }
        .text-sm { font-size: 0.875rem; }
        .mb-4 { margin-bottom: 1rem; }
        .w-full { width: 100%; }
        .max-w-md { max-width: 28rem; }
        .mx-auto { margin-left: auto; margin-right: auto; }
        .p-8 { padding: 2rem; }
        .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
        .rounded-xl { border-radius: 0.75rem; }
        .text-xl { font-size: 1.25rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .text-center { text-align: center; }
        .text-2xl { font-size: 1.5rem; }
        .font-semibold { font-weight: 600; }
        .mb-1 { margin-bottom: 0.25rem; }
    </style>
</head>
<body class="bg-gray-100 p-8">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md mx-auto">
        <h2 class="text-2xl font-bold text-blue-900 mb-6 text-center">Reset Password</h2>
        
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 p-3 mb-4 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

<div class="text-center mb-6">
                <p class="text-lg font-semibold text-gray-700 mb-2">Halo {{ $user->name }}!</p>
                <p class="text-sm text-gray-600">Anda meminta reset password untuk akun <strong>{{ $user->email }}</strong></p>
            </div>
            <a href="{{ route('password.reset', $token) }}?email={{ urlencode($user->email) }}" 
               style="display: block; width: 100%; background-color: #2563eb; color: white; font-weight: bold; padding-top: 0.75rem; padding-bottom: 0.75rem; border-radius: 0.5rem; text-align: center; text-decoration: none; font-size: 1.125rem; margin-top: 1rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);" 
               onmouseover="this.style.backgroundColor='#1d4ed8'; this.style.transform='translateY(-1px)';" 
               onmouseout="this.style.backgroundColor='#2563eb'; this.style.transform='translateY(0)';" 
               class="reset-button">
                🔐 Reset Password Sekarang
            </a>
            <p class="text-sm text-gray-500 mt-4 text-center">Jika Anda tidak meminta ini, abaikan email ini.</p>
            <p class="text-xs text-gray-400 mt-2 text-center">Token ini akan kedaluwarsa dalam 60 menit.</p>
        
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-500">Jika ada masalah, hubungi admin.</p>
        </div>
    </div>
</body>
</html>

