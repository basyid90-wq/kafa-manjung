@extends('layout-fb.auth-card')

@section('title', 'Terima Jemputan')
@section('card_title', 'Jemputan ke ' . $invitation->school->name)
@section('card_subtitle', ($invitation->inviter?->name ?? 'Guru Besar') . ' menjemput anda menyertai sekolah ini sebagai ' . $invitation->role . '.')

@php
    $input = 'w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent';
    $label = 'block text-sm font-medium text-gray-700 mb-1';
@endphp

@section('card')
<form method="POST" action="{{ route('invitations.accept', $token) }}" class="space-y-4">
    @csrf

    @if(!$existing)
        {{-- New account --}}
        <div>
            <label class="{{ $label }}">E-mel</label>
            <input type="email" value="{{ $invitation->email }}" disabled class="{{ $input }} bg-gray-50">
        </div>
        <div>
            <label for="name" class="{{ $label }}">Nama Penuh <span class="text-red-500">*</span></label>
            <input id="name" type="text" name="name" value="{{ old('name', $invitation->name) }}" required maxlength="255" class="{{ $input }}">
            @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
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
        <label class="flex items-start gap-2 text-sm text-gray-600">
            <input type="checkbox" name="terms" value="1" required class="w-4 h-4 mt-0.5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <span>Saya bersetuju dengan <a href="{{ route('legal.terms') }}" target="_blank" class="text-blue-600 hover:underline">Terma Perkhidmatan</a>
                  dan <a href="{{ route('legal.privacy') }}" target="_blank" class="text-blue-600 hover:underline">Notis Privasi</a>.</span>
        </label>
        @error('terms')<p class="text-xs text-red-500">{{ $message }}</p>@enderror

        <button type="submit"
                class="ek-btn-primary w-full">
            Cipta Akaun & Sertai
        </button>

    @else
        {{-- Existing account (logged in as the invited e-mail) --}}
        <p class="text-sm text-gray-600">Anda log masuk sebagai <strong class="text-gray-900">{{ $existing->email }}</strong>.</p>

        @if($merge)
        <div class="p-4 rounded-lg bg-yellow-50 border border-yellow-200 text-sm text-gray-700 space-y-2">
            <p class="font-semibold">Data ruang kerja "{{ $merge['from']->name }}" akan digabungkan ke {{ $invitation->school->name }}:</p>
            <ul class="list-disc ms-5">
                <li>{{ $merge['preview']['classes'] }} kelas</li>
                <li>{{ $merge['preview']['students'] }} murid (termasuk kehadiran, markah, rekod)</li>
                <li>{{ $merge['preview']['rph'] }} RPH</li>
            </ul>
            <p>Selepas digabung, Guru Besar sekolah tersebut boleh melihat data ini. Baki langganan Personal anda (jika ada) tidak dipindahkan.</p>
        </div>

        @if($merge['conflicts']->isNotEmpty())
        <div class="p-4 rounded-lg bg-red-50 text-sm text-red-800 space-y-2">
            <p class="font-semibold">Murid berikut sudah didaftarkan oleh {{ $invitation->school->name }} (MyKid sama):</p>
            <ul class="list-disc ms-5">
                @foreach($merge['conflicts'] as $s)
                <li>{{ $s->name }} ({{ $s->mykid }})</li>
                @endforeach
            </ul>
            <p>Padam rekod murid tersebut daripada ruang kerja anda dahulu, kemudian buka semula pautan jemputan ini.</p>
        </div>
        @endif
        @endif

        <button type="submit" @if($merge && $merge['conflicts']->isNotEmpty()) disabled @endif
                class="ek-btn-primary w-full disabled:opacity-50 disabled:cursor-not-allowed">
            {{ $merge ? 'Terima & Gabungkan Data' : 'Terima Jemputan' }}
        </button>
    @endif
</form>
@endsection
