<section>
    <div class="section-title mb--20">
        <h6 class="rbt-title-style-2">{{ __('Kemaskini Kata Laluan') }}</h6>
        <p class="description">{{ __('Pastikan akaun anda menggunakan kata laluan yang panjang dan rawak untuk keselamatan.') }}</p>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="rbt-profile-row rbt-default-form row row--15">
        @csrf
        @method('put')

        <div class="col-12">
            <div class="rbt-form-group">
                <label for="update_password_current_password">{{ __('Kata Laluan Semasa') }}</label>
                <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password">
                @if($errors->updatePassword->get('current_password'))
                    <span class="text-danger small mt-1">{{ $errors->updatePassword->first('current_password') }}</span>
                @endif
            </div>
        </div>

        <div class="col-12">
            <div class="rbt-form-group">
                <label for="update_password_password">{{ __('Kata Laluan Baharu') }}</label>
                <input id="update_password_password" name="password" type="password" autocomplete="new-password">
                @if($errors->updatePassword->get('password'))
                    <span class="text-danger small mt-1">{{ $errors->updatePassword->first('password') }}</span>
                @endif
            </div>
        </div>

        <div class="col-12">
            <div class="rbt-form-group">
                <label for="update_password_password_confirmation">{{ __('Sahkan Kata Laluan Baharu') }}</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
                @if($errors->updatePassword->get('password_confirmation'))
                    <span class="text-danger small mt-1">{{ $errors->updatePassword->first('password_confirmation') }}</span>
                @endif
            </div>
        </div>

        <div class="col-12 mt--20">
            <div class="rbt-form-group d-flex align-items-center gap-4">
                <button type="submit" class="rbt-btn btn-gradient btn-sm">{{ __('Simpan') }}</button>

                @if (session('status') === 'password-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-success mb-0"
                    >{{ __('Berjaya Disimpan.') }}</p>
                @endif
            </div>
        </div>
    </form>
</section>

