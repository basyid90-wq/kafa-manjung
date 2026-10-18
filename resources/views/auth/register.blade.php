@extends('layout-fb.auth-card')

@section('title', 'Daftar Akaun')
@section('card_width', '32rem')
@section('card_title', 'Daftar Akaun Percuma')
@section('card_subtitle', 'Mula guna eKafa Online dengan pakej Percuma. Naik taraf bila-bila masa.')

@php
    $input = 'w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent';
    $label = 'block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1';
@endphp

@section('card')
<form method="POST" action="{{ route('register') }}" x-data="{ type: '{{ old('account_type', request('jenis') === 'personal' ? 'personal' : 'sekolah') }}' }" class="space-y-4">
    @csrf

    {{-- Honeypot: humans never see or fill this --}}
    <div style="position:absolute;left:-9999px" aria-hidden="true">
        <input type="text" name="website" tabindex="-1" autocomplete="off">
    </div>

    <div>
        <span class="{{ $label }}">Jenis Akaun <span class="text-red-500">*</span></span>
        <div class="grid grid-cols-2 gap-2">
            <label class="cursor-pointer">
                <input type="radio" name="account_type" value="sekolah" class="peer sr-only" x-model="type">
                <span class="flex flex-col items-center justify-center px-3 py-3 text-sm font-medium border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300
                             peer-checked:bg-blue-600 peer-checked:border-blue-600 peer-checked:text-white transition-colors">
                    Sekolah
                    <span class="text-xs font-normal opacity-80">Guru Besar + guru</span>
                </span>
            </label>
            <label class="cursor-pointer">
                <input type="radio" name="account_type" value="personal" class="peer sr-only" x-model="type">
                <span class="flex flex-col items-center justify-center px-3 py-3 text-sm font-medium border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300
                             peer-checked:bg-blue-600 peer-checked:border-blue-600 peer-checked:text-white transition-colors">
                    Guru (Personal)
                    <span class="text-xs font-normal opacity-80">Kelas saya sahaja</span>
                </span>
            </label>
        </div>
        @error('account_type')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="school_name" class="{{ $label }}">
            <span x-show="type === 'sekolah'">Nama Sekolah KAFA <span class="text-red-500">*</span></span>
            <span x-show="type === 'personal'" style="display:none">Nama KAFA tempat mengajar <span class="text-xs text-gray-400 font-normal">(pilihan)</span></span>
        </label>
        <input id="school_name" type="text" name="school_name" value="{{ old('school_name') }}" maxlength="255" class="{{ $input }}"
               placeholder="cth: KAFA Integrasi Al-Hidayah" :required="type === 'sekolah'">
        @error('school_name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="name" class="{{ $label }}">Nama Penuh <span class="text-red-500">*</span></label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required maxlength="255" autocomplete="name" class="{{ $input }}">
            @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="phone" class="{{ $label }}">No. Telefon</label>
            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" maxlength="20" autocomplete="tel" class="{{ $input }}" placeholder="0123456789">
            @error('phone')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <div>
        <label for="email" class="{{ $label }}">Alamat E-mel <span class="text-red-500">*</span></label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required maxlength="255" autocomplete="username" class="{{ $input }}">
        @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="password" class="{{ $label }}">Kata Laluan <span class="text-red-500">*</span></label>
            <input id="password" type="password" name="password" required autocomplete="new-password" class="{{ $input }}">
            @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="password_confirmation" class="{{ $label }}">Sahkan Kata Laluan <span class="text-red-500">*</span></label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="{{ $input }}">
        </div>
    </div>

    <label class="flex items-start gap-2 text-sm text-gray-600 dark:text-gray-300">
        <input type="checkbox" name="terms" value="1" required {{ old('terms') ? 'checked' : '' }}
               class="w-4 h-4 mt-0.5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
        <span>Saya bersetuju dengan <a href="{{ route('legal.terms') }}" target="_blank" class="text-blue-600 hover:underline">Terma Perkhidmatan</a>
              dan <a href="{{ route('legal.privacy') }}" target="_blank" class="text-blue-600 hover:underline">Notis Privasi</a>.</span>
    </label>
    @error('terms')<p class="text-xs text-red-500">{{ $message }}</p>@enderror

    <button type="submit"
            class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
        Daftar Akaun
    </button>

    <p class="text-sm text-center text-gray-500 dark:text-gray-400">
        Sudah ada akaun? <a href="{{ route('login') }}#log-masuk" class="text-blue-600 hover:underline font-medium">Log masuk</a>
    </p>
</form>
@endsection
