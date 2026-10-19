@extends('layout-fb.auth-card')

@section('title', 'Terima Jemputan')
@section('card_title', 'Jemputan ke ' . $invitation->school->name)
@section('card_subtitle', 'E-mel ' . $invitation->email . ' sudah mempunyai akaun eKafa Online.')

@section('card')
<div class="space-y-4 text-sm text-gray-600">
    @auth
    <p>Anda sedang log masuk sebagai <strong>{{ auth()->user()->email }}</strong>. Sila log keluar dan log masuk semula sebagai <strong>{{ $invitation->email }}</strong> untuk menerima jemputan ini.</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
                class="ek-btn-primary w-full">
            Log Keluar
        </button>
    </form>
    @else
    <p>Log masuk dengan akaun tersebut untuk menerima jemputan. Anda akan dibawa semula ke halaman ini selepas log masuk.</p>
    <a href="{{ route('login') }}#log-masuk"
       class="ek-btn-primary w-full">
        Log Masuk
    </a>
    @endauth
</div>
@endsection
