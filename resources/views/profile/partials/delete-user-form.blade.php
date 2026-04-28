<section class="mt--40">
    <div class="section-title mb--20">
        <h6 class="rbt-title-style-2 text-danger">{{ __('Padam Akaun') }}</h6>
        <p class="description">
            {{ __('Setelah akaun anda dipadamkan, semua sumber dan datanya akan dipadamkan secara kekal. Sebelum memadamkan akaun anda, sila muat turun sebarang data atau maklumat yang anda ingin simpan.') }}
        </p>
    </div>

    <button
        class="rbt-btn btn-border btn-sm"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Padam Akaun') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-5 rbt-default-form">
            @csrf
            @method('delete')

            <div class="section-title mb--20">
                <h4 class="title">{{ __('Adakah anda pasti mahu memadamkan akaun anda?') }}</h4>
                <p class="description">
                    {{ __('Setelah akaun anda dipadamkan, semua sumber dan datanya akan dipadamkan secara kekal. Sila masukkan kata laluan anda untuk mengesahkan bahawa anda mahu memadamkan akaun anda secara kekal.') }}
                </p>
            </div>

            <div class="rbt-form-group">
                <label for="password" class="sr-only">{{ __('Kata Laluan') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="{{ __('Kata Laluan') }}"
                />
                @if($errors->userDeletion->get('password'))
                    <span class="text-danger small mt-1">{{ $errors->userDeletion->first('password') }}</span>
                @endif
            </div>

            <div class="mt--30 d-flex justify-content-end gap-3">
                <button type="button" class="rbt-btn btn-border btn-sm" x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </button>

                <button type="submit" class="rbt-btn btn-gradient btn-sm">
                    {{ __('Padam Akaun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>

