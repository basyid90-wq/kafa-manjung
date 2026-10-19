@extends('layout-fb.auth-card')

@section('title', 'Set Semula Kata Laluan')
@section('card_title', 'Tetapkan kata laluan baharu')

@php
    $input = 'w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent';
@endphp

@section('card')
<form method="POST" action="{{ route('password.store') }}" class="space-y-4 mt-4">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div>
        <label for="email" class="ek-label">Alamat E-mel</label>
        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autocomplete="username" class="{{ $input }}">
        @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="password" class="ek-label">Kata Laluan Baharu</label>
        <input id="password" type="password" name="password" required autofocus autocomplete="new-password" class="{{ $input }}">
        @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="password_confirmation" class="ek-label">Sahkan Kata Laluan</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="{{ $input }}">
    </div>

    <button type="submit"
            class="ek-btn-primary w-full">
        Simpan Kata Laluan
    </button>
</form>
@endsection
