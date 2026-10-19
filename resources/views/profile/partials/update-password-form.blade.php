<section class="bg-white rounded-xl border border-gray-200 p-5">
    <h2 class="text-sm font-semibold text-gray-700 mb-0.5">Kemaskini Kata Laluan</h2>
    <p class="text-xs text-gray-400 mb-3">Pastikan akaun anda menggunakan kata laluan yang panjang dan rawak untuk keselamatan.</p>
    <div class="flex items-start gap-2 p-3 mb-4 rounded-lg bg-blue-50 border border-blue-100">
        <svg class="w-4 h-4 text-blue-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div class="text-xs text-blue-700 space-y-0.5">
            <p class="font-semibold mb-1">Syarat kata laluan:</p>
            <p>✓ Minimum <strong>8 aksara</strong></p>
            <p>✓ Boleh guna huruf, nombor dan simbol (contoh: <strong>MyPass@2025</strong>)</p>
            <p>✓ Kata laluan baharu mesti disahkan semula</p>
        </div>
    </div>

    <form method="post" action="{{ route('password.update') }}">
        @csrf @method('put')

        <div class="space-y-4 mb-4">
            <div>
                <label class="ek-label">Kata Laluan Semasa</label>
                <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                       class="ek-input">
                @if($errors->updatePassword->get('current_password'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->updatePassword->first('current_password') }}</p>
                @endif
            </div>

            <div>
                <label class="ek-label">Kata Laluan Baharu</label>
                <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                       class="ek-input">
                @if($errors->updatePassword->get('password'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->updatePassword->first('password') }}</p>
                @endif
            </div>

            <div>
                <label class="ek-label">Sahkan Kata Laluan Baharu</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                       class="ek-input">
                @if($errors->updatePassword->get('password_confirmation'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->updatePassword->first('password_confirmation') }}</p>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="ek-btn-primary">
                Simpan
            </button>
            @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
               class="text-sm text-green-600 font-medium">
                Berjaya Disimpan.
            </p>
            @endif
        </div>
    </form>
</section>
