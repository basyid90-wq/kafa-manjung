@extends('layout-fb.auth-card')

@section('title', 'Set Semula Kata Laluan')
@section('card_title', 'Tetapkan kata laluan baharu')

@php
    $input = 'w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent';
@endphp

@section('card')
<form method="POST" action="{{ route('password.store') }}" class="space-y-4 mt-4">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat E-mel</label>
        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autocomplete="username" class="{{ $input }}">
        @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kata Laluan Baharu</label>
        <input id="password" type="password" name="password" required autofocus autocomplete="new-password" class="{{ $input }}">
        @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sahkan Kata Laluan</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="{{ $input }}">
    </div>

    <button type="submit"
            class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
        Simpan Kata Laluan
    </button>
</form>
@endsection
