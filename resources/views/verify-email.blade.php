<x-filament::layouts.base title="{{__('filament-fortify::verify-email.title')}}">
    <div class="flex items-center justify-center min-h-screen filament-verify-email-page">
        <div class="p-2 max-w-md space-y-8 w-screen">
            <form method="POST" action="{{ route('verification.send') }}" @class([
                'bg-white space-y-8 shadow border border-gray-300 rounded-2xl p-8',
                'dark:bg-gray-800 dark:border-gray-700' => config('filament.dark_mode'),
            ])>
                <div class="w-full flex justify-center">
                    <x-filament::brand />
                </div>

                <p class="font-medium tracking-tight text-center text-2xl">
                    {{ __('filament-fortify::verify-email.messages.verify') }}
                </p>

                @csrf
                <x-filament::button type="submit" class="w-full">
                    {{ __('filament-fortify::verify-email.buttons.resend.label') }}
                </x-filament::button>
            </form>

            <x-filament::footer />
        </div>
    </div>
</x-filament::layouts.base>