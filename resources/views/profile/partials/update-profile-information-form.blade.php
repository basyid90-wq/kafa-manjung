<section>
    <div class="section-title mb--20">
        <h6 class="rbt-title-style-2">{{ __('Maklumat Profil') }}</h6>
        <p class="description">{{ __("Kemaskini maklumat profil akaun dan alamat e-mel anda.") }}</p>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="rbt-profile-row rbt-default-form row row--15">
        @csrf
        @method('patch')

        <div class="col-lg-6 col-md-6 col-12">
            <div class="rbt-form-group">
                <label for="name">{{ __('Nama') }}</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @if($errors->get('name'))
                    <span class="text-danger small mt-1">{{ $errors->first('name') }}</span>
                @endif
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-12">
            <div class="rbt-form-group">
                <label for="email">{{ __('E-mel') }}</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                @if($errors->get('email'))
                    <span class="text-danger small mt-1">{{ $errors->first('email') }}</span>
                @endif

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="text-sm text-gray-800">
                            {{ __('Alamat e-mel anda belum disahkan.') }}

                            <button form="send-verification" class="rbt-btn-link">
                                {{ __('Klik di sini untuk menghantar semula e-mel pengesahan.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-success">
                                {{ __('Pautan pengesahan baharu telah dihantar ke alamat e-mel anda.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="col-12 mt--20">
            <div class="rbt-form-group d-flex align-items-center gap-4">
                <button type="submit" class="rbt-btn btn-gradient btn-sm">{{ __('Simpan') }}</button>

                @if (session('status') === 'profile-updated')
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

