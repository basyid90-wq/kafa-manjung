@extends('layout-fb.auth-card')

@section('title', 'Sahkan E-mel')
@section('card_title', 'Sahkan alamat e-mel anda')
@section('card_subtitle', 'Satu langkah lagi sebelum anda boleh mula.')

@section('card')
<div class="space-y-4 text-sm text-gray-600">
    <p>Kami telah menghantar pautan pengesahan ke <strong class="text-gray-900">{{ auth()->user()->email }}</strong>. Klik pautan dalam e-mel tersebut untuk mengaktifkan akaun anda.</p>
    <p>Tidak menerima e-mel? Semak folder <em>Spam</em> atau hantar semula di bawah.</p>

    @if (session('status') == 'verification-link-sent')
    <div class="p-3 text-sm text-green-800 rounded-lg bg-green-50">
        Pautan pengesahan baharu telah dihantar ke e-mel anda.
    </div>
    @endif

    <div class="flex items-center justify-between gap-3 pt-2">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                    class="ek-btn-primary">
                Hantar Semula E-mel
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 underline">Log Keluar</button>
        </form>
    </div>
</div>
@endsection
