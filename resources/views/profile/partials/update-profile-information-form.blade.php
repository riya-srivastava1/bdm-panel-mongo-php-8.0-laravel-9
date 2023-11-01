<section>

    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="userImage"
            style="background-image:url('{{ asset('') }}{{ Auth::user()->image ?? "assets/img/person-dummy-e1553259379744.jpg" }}')">
            <div class="uploadDiv">
                <h5>Upload DP</h5>
                <input type="file" name="profile_image" />
            </div>
        </div>

        <style>
            .userImage {
                width: 110px;
                height: 110px;
                border-radius: 50%;
                position: relative;
                overflow: hidden;
                display: block;
                margin: auto;
                margin-bottom: 20px;
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;

            }

            .userImage:hover .uploadDiv {
                opacity: 1;
            }

            .userImage .uploadDiv {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: #00000088;
                opacity: 0;
                transition: 0.5s
            }

            .userImage .uploadDiv h5 {
                display: flex;
                vertical-align: middle;
                align-items: center;
                justify-content: center;
                height: 100%;
                color: #fff;
                font-size: 15px;
                font-weight: 600;
            }

            .userImage .uploadDiv input {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                opacity: 0;
            }

            label.block.font-medium.text-sm.text-white.dark\:text-gray-300 {
                color: #000 !important;
            }
        </style>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full form-control" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full form-control" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 mt-2">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-black ">{{ __('Saved.') }}</p>
            @endif
        </div>

    </form>

</section>
