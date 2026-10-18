@extends('layout-fb.auth-card')

@section('title', 'Lupa Kata Laluan')
@section('card_title', 'Lupa kata laluan?')
@section('card_subtitle', 'Masukkan e-mel akaun anda. Kami akan hantar pautan untuk menetapkan kata laluan baharu.')

@section('card')
<form method="POST" action="{{ route('password.email') }}" class="space-y-4">
    @csrf
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat E-mel</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
               class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
    </div>

    <button type="submit"
            class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
        Hantar Pautan Set Semula
    </button>

    <p class="text-sm text-center text-gray-500 dark:text-gray-400">
        <a href="{{ route('login') }}#log-masuk" class="text-blue-600 hover:underline">Kembali ke log masuk</a>
    </p>
    <p class="text-xs text-center text-gray-400">Ibu bapa yang log masuk dengan No. KP: sila hubungi sekolah anak anda.</p>
</form>
@endsection
