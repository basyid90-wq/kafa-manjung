@extends('layout-fb.auth-card')

@section('title', 'Sahkan Kata Laluan')
@section('card_title', 'Sahkan kata laluan')
@section('card_subtitle', 'Ini kawasan selamat. Sila masukkan kata laluan anda untuk meneruskan.')

@section('card')
<form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
    @csrf
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kata Laluan</label>
        <input id="password" type="password" name="password" required autocomplete="current-password"
               class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
    </div>
    <button type="submit"
            class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
        Sahkan
    </button>
</form>
@endsection
