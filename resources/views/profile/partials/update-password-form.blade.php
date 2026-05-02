<section class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
    <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-0.5">Kemaskini Kata Laluan</h2>
    <p class="text-xs text-gray-400 mb-4">Pastikan akaun anda menggunakan kata laluan yang panjang dan rawak untuk keselamatan.</p>

    <form method="post" action="{{ route('password.update') }}">
        @csrf @method('put')

        <div class="space-y-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kata Laluan Semasa</label>
                <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                       class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                @if($errors->updatePassword->get('current_password'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->updatePassword->first('current_password') }}</p>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kata Laluan Baharu</label>
                <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                       class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                @if($errors->updatePassword->get('password'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->updatePassword->first('password') }}</p>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sahkan Kata Laluan Baharu</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                       class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                @if($errors->updatePassword->get('password_confirmation'))
                <p class="text-red-500 text-xs mt-1">{{ $errors->updatePassword->first('password_confirmation') }}</p>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                Simpan
            </button>
            @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
               class="text-sm text-green-600 dark:text-green-400 font-medium">
                Berjaya Disimpan.
            </p>
            @endif
        </div>
    </form>
</section>
