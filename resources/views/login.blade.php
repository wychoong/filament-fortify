<div class="flex items-center justify-center min-h-screen filament-login-page">
    <div class="p-2 max-w-md space-y-8 w-screen">
        <form method="POST" action="{{ route('login') }}" @class([
            'bg-white space-y-8 shadow border border-gray-300 rounded-2xl p-8',
            'dark:bg-gray-800 dark:border-gray-700' => config('filament.dark_mode'),
        ])>
            <div class="w-full flex justify-center">
                <x-filament::brand />
            </div>

            <h2 class="font-bold tracking-tight text-center text-2xl">
                {{ __('filament::login.heading') }}
                @if ($registrationEnabled)
                    <p class="mt-2 text-sm text-center font-normal">
                        {{__('filament-fortify::register.or')}}
                        <x-tables::link href="{{route('register')}}" >
                            {{ __('filament-fortify::register.login-link') }}
                        </x-table::link>
                    </p>
                @endif
            </h2>


            @csrf
            {{ $this->form }}

            <x-filament::button type="submit" class="w-full">
                {{ __('filament::login.buttons.submit.label') }}
            </x-filament::button>

            @if ($resetPasswordEnabled)
                <div class="text-center">
                    <x-tables::link href="{{route('password.request')}}" >{{__('filament-fortify::password-reset.buttons.request.label')}}</x-table::link>
                </div>
            @endif
        </form>

        <x-filament::notification-manager />

        <x-filament::footer />
    </div>
</div>
