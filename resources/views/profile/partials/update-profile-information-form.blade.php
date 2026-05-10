<section class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
    <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-0.5">Maklumat Profil</h2>
    <p class="text-xs text-gray-400 mb-4">Kemaskini maklumat profil akaun dan alamat e-mel anda.</p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama <span class="text-red-500">*</span></label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                       class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                @if($errors->get('name'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">E-mel <span class="text-red-500">*</span></label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                       class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                @if($errors->get('email'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('email') }}</p>
                @endif

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg text-xs text-yellow-800 dark:text-yellow-300">
                    Alamat e-mel anda belum disahkan.
                    <button form="send-verification" class="font-semibold underline ml-1">Hantar semula e-mel pengesahan.</button>
                    @if (session('status') === 'verification-link-sent')
                    <p class="mt-1 text-green-600 dark:text-green-400 font-medium">Pautan pengesahan baharu telah dihantar.</p>
                    @endif
                </div>
                @endif
            </div>

            @if (!$user->hasRole('Ibu Bapa'))
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Pengguna (Username)</label>
                <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}"
                       placeholder="cth: guru_ali01"
                       class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                <p class="text-xs text-gray-400 mt-1">Huruf, nombor, underscore (_) dan titik (.) sahaja. Digunakan untuk log masuk.</p>
                @if($errors->get('username'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('username') }}</p>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No. Kad Pengenalan</label>
                <input id="ic_number" name="ic_number" type="text" value="{{ old('ic_number', $user->ic_number) }}"
                       placeholder="cth: 890101105555"
                       class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                <p class="text-xs text-gray-400 mt-1">Boleh digunakan untuk log masuk sebagai alternatif emel.</p>
                @if($errors->get('ic_number'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->first('ic_number') }}</p>
                @endif
            </div>
            @endif
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                Simpan
            </button>
            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
               class="text-sm text-green-600 dark:text-green-400 font-medium">
                Berjaya Disimpan.
            </p>
            @endif
        </div>
    </form>
</section>
