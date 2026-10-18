@extends('layout-fb.auth-card')

@section('title', 'Sahkan E-mel')
@section('card_title', 'Sahkan alamat e-mel anda')
@section('card_subtitle', 'Satu langkah lagi sebelum anda boleh mula.')

@section('card')
<div class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
    <p>Kami telah menghantar pautan pengesahan ke <strong class="text-gray-900 dark:text-white">{{ auth()->user()->email }}</strong>. Klik pautan dalam e-mel tersebut untuk mengaktifkan akaun anda.</p>
    <p>Tidak menerima e-mel? Semak folder <em>Spam</em> atau hantar semula di bawah.</p>

    @if (session('status') == 'verification-link-sent')
    <div class="p-3 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-700 dark:text-green-400">
        Pautan pengesahan baharu telah dihantar ke e-mel anda.
    </div>
    @endif

    <div class="flex items-center justify-between gap-3 pt-2">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                Hantar Semula E-mel
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 underline">Log Keluar</button>
        </form>
    </div>
</div>
@endsection
