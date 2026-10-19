@extends('layout-fb.auth-card')

@section('title', 'Sahkan Kata Laluan')
@section('card_title', 'Sahkan kata laluan')
@section('card_subtitle', 'Ini kawasan selamat. Sila masukkan kata laluan anda untuk meneruskan.')

@section('card')
<form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
    @csrf
    <div>
        <label for="password" class="ek-label">Kata Laluan</label>
        <input id="password" type="password" name="password" required autocomplete="current-password"
               class="ek-input">
        @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
    </div>
    <button type="submit"
            class="ek-btn-primary w-full">
        Sahkan
    </button>
</form>
@endsection
