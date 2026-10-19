<section class="bg-white rounded-xl border border-gray-200 p-5">
    <h2 class="text-sm font-semibold text-gray-700 mb-0.5">Maklumat Profil</h2>
    <p class="text-xs text-gray-400 mb-3">Kemaskini maklumat profil akaun dan alamat e-mel anda.</p>

    {{-- Info box --}}
    <div class="p-3 mb-4 rounded-lg bg-blue-50 border border-blue-100 text-xs text-blue-700 space-y-1.5">
        <p class="font-semibold mb-1">Cara Log Masuk (Kakitangan):</p>
        <p>📧 <strong>E-mel</strong> — Kaedah utama. Wajib ada dan mesti unik.</p>
        <p>👤 <strong>Username</strong> — Nama pilihan sebagai alternatif log masuk. Bebas menggunakan apa sahaja.</p>
        <p>🪪 <strong>No. Kad Pengenalan</strong> — Boleh digunakan untuk log masuk jika diisi. Format: nombor sahaja tanpa sempang (cth: <strong>890101105555</strong>).</p>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="ek-label">Nama <span class="text-red-500">*</span></label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                       class="ek-input">
                @if($errors->get('name'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <div>
                <label class="ek-label">E-mel <span class="text-red-500">*</span></label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                       class="ek-input">
                @if($errors->get('email'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('email') }}</p>
                @endif

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 p-3 bg-yellow-50 rounded-lg text-xs text-yellow-800">
                    Alamat e-mel anda belum disahkan.
                    <button form="send-verification" class="font-semibold underline ml-1">Hantar semula e-mel pengesahan.</button>
                    @if (session('status') === 'verification-link-sent')
                    <p class="mt-1 text-green-600 font-medium">Pautan pengesahan baharu telah dihantar.</p>
                    @endif
                </div>
                @endif
            </div>

            @if (!$user->hasRole('Ibu Bapa'))
            <div>
                <label class="ek-label">Nama Pengguna (Username)</label>
                <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}"
                       placeholder="Masukkan nama pengguna anda"
                       class="ek-input">
                <p class="text-xs text-gray-400 mt-1">Nama unik untuk log masuk. Bebas menggunakan apa sahaja.</p>
                @if($errors->get('username'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('username') }}</p>
                @endif
            </div>

            <div>
                <label class="ek-label">No. Kad Pengenalan</label>
                <input id="ic_number" name="ic_number" type="text" value="{{ old('ic_number', $user->ic_number) }}"
                       placeholder="Contoh: 890101105555 (tanpa sempang)"
                       class="ek-input">
                <p class="text-xs text-gray-400 mt-1">Boleh digunakan untuk log masuk sebagai alternatif emel.</p>
                @if($errors->get('ic_number'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('ic_number') }}</p>
                @endif
            </div>
            @endif
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="ek-btn-primary">
                Simpan
            </button>
            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
               class="text-sm text-green-600 font-medium">
                Berjaya Disimpan.
            </p>
            @endif
        </div>
    </form>
</section>
