<div class="flex items-center justify-center min-h-screen filament-register-page">
    <div class="p-2 max-w-md space-y-8 w-screen">
        <form wire:submit.prevent="register"  @class([
            'bg-white space-y-8 shadow border border-gray-300 rounded-2xl p-8',
            'dark:bg-gray-800 dark:border-gray-700' => config('filament.dark_mode'),
        ])>
            <div class="w-full flex justify-center">
                <x-filament::brand />
            </div>

            <h2 class="font-bold tracking-tight text-center text-2xl">
                {{ __('filament-fortify::register.heading') }}
            </h2>

            @csrf
            {{ $this->form }}

            <x-filament::button type="submit" form="register" class="w-full">
                {{ __('filament-fortify::register.buttons.submit.label') }}
            </x-filament::button>

            <div class="text-center">
                <x-tables::link href="{{route('login')}}" >{{__('filament-fortify::register.buttons.login.label')}}</x-table::link>
            </div>
        </form>

        <x-filament::footer />
    </div>
</div>
