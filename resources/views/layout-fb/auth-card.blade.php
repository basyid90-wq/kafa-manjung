{{-- Centered card shell for standalone auth pages (daftar, sahkan e-mel, lupa kata laluan, jemputan) --}}
@extends('layout-fb.auth')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center px-4 py-10">
    <a href="{{ route('home') }}" class="flex items-center gap-2 mb-6">
        <span class="w-10 h-10 rounded-lg bg-blue-600 text-white text-sm font-bold flex items-center justify-center">eK</span>
        <span class="text-xl font-bold text-gray-900 dark:text-white">eKafa Online</span>
    </a>

    <div class="w-full bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6" style="max-width: @yield('card_width', '28rem')">
        @hasSection('card_title')
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">@yield('card_title')</h1>
        @endif
        @hasSection('card_subtitle')
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 mb-5">@yield('card_subtitle')</p>
        @endif

        @if(session('status'))
        <div class="p-3 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-700 dark:text-green-400">{{ session('status') }}</div>
        @endif
        @if(session('error'))
        <div class="p-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-700 dark:text-red-400">{{ session('error') }}</div>
        @endif

        @yield('card')
    </div>

    <p class="text-xs text-gray-400 mt-6">&copy; {{ date('Y') }} eKafa Online</p>
</div>
@endsection
