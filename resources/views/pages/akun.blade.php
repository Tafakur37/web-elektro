@extends('app')

@section('title', 'Akun Profil')

@section('page_title', 'Akun Profil')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg max-w-2xl mx-auto">
    <div class="text-center mb-8">
        <div class="w-24 h-24 bg-blue-100 rounded-full mx-auto flex items-center justify-center text-4xl font-bold text-blue-600 mb-4">
            {{ substr(Auth::user()->name, 0, 1) }}
        </div>
        <h2 class="text-2xl font-bold text-gray-800">{{ Auth::user()->name }}</h2>
        <p class="text-sm text-gray-500 uppercase font-bold tracking-wider">{{ Auth::user()->role }}</p>
    </div>
    
    <div class="space-y-6">
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Identifier/NIM</label>
            <p class="bg-gray-50 p-3 rounded-lg font-mono text-blue-900">{{ Auth::user()->identifier }}</p>
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
            <input type="email" value="{{ Auth::user()->email }}" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50" readonly>
        </div>
    </div>
</div>
@endsection

