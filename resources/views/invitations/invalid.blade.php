@extends('layout-fb.auth-card')

@section('title', 'Jemputan Tidak Sah')
@section('card_title', 'Jemputan tidak sah')

@section('card')
<div class="space-y-4 text-sm text-gray-600 mt-2">
    <p>{{ $reason ?? 'Pautan jemputan ini tidak sah, telah digunakan atau telah tamat tempoh. Sila minta Guru Besar anda menghantar jemputan baharu.' }}</p>
    <a href="{{ route('home') }}"
       class="ek-btn-secondary">
        Ke Halaman Utama
    </a>
</div>
@endsection
