@extends('layout-fb.auth-card')

@section('title', 'Jemputan Tidak Sah')
@section('card_title', 'Jemputan tidak sah')

@section('card')
<div class="space-y-4 text-sm text-gray-600 dark:text-gray-300 mt-2">
    <p>{{ $reason ?? 'Pautan jemputan ini tidak sah, telah digunakan atau telah tamat tempoh. Sila minta Guru Besar anda menghantar jemputan baharu.' }}</p>
    <a href="{{ route('home') }}"
       class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
        Ke Halaman Utama
    </a>
</div>
@endsection
