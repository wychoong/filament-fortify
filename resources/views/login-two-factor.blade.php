<div class="flex items-center justify-center min-h-screen filament-login-two-factor-page">
    <div class="p-2 max-w-md space-y-8 w-screen">
        <form method="POST" action="{{ route('two-factor.login') }}" @class([
            'bg-white space-y-8 shadow border border-gray-300 rounded-2xl p-8',
            'dark:bg-gray-800 dark:border-gray-700' => config('filament.dark_mode'),
        ])>
            <div class="w-full flex justify-center">
                <x-filament::brand />
            </div>

            <h2 class="font-bold tracking-tight text-center text-2xl">
                {{ __('filament-fortify::two-factor.login.heading') }}
            </h2>

            @csrf
            {{ $this->form }}

            <x-filament::button type="submit" class="w-full">
                {{ __('filament-fortify::two-factor.login.buttons.submit.label') }}
            </x-filament::button>

            <x-filament::button color="secondary" class="w-full" type="button" tag="a" outlined href="{{route('login')}}">
                {{ __('filament-fortify::two-factor.login.buttons.cancel.label') }}
            </x-filament::button>
        </form>
        
        <x-filament::notification-manager />

        <x-filament::footer />
    </div>
</div>
