<x-filament::page>
    @if(\Laravel\Fortify\Fortify::confirmsTwoFactorAuthentication() && auth()->user()->two_factor_secret && !auth()->user()->two_factor_confirmed_at)
        <div class="flex items-center justify-center ">
            <div class="p-2 max-w-md  ">
                <x-filament::card>
                    <div class="text-center space-y-8">
                        <div>
                            <div class="font-bold">
                                {{__("filament-fortify::two-factor.messages.scan-qr")}}
                            </div>
                            <div class="flex items-center justify-center mt-2">
                                {!!auth()->user()->twoFactorQrCodeSvg()!!}
                            </div>
                        </div>

                        <div class="text-left text-sm">
                            {{__("filament-fortify::two-factor.messages.store-recovery-code")}}
                            <div class="flex items-center justify-center">
                                <div class="mt-2 text-left text-sm">
                                    @foreach((array) auth()->user()->recoveryCodes() as $index => $code)
                                        <p class="mt-2">{{$index + 1}}) {{$code}}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="filament-forms-field-wrapper">
                            <form method="POST" action="{{route('two-factor.confirm')}}">
                                @csrf
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                                        <label
                                            class="inline-flex items-center space-x-3 rtl:space-x-reverse filament-forms-field-wrapper-label"
                                            for="code"
                                        >
                                            <span
                                                class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                                {{__('filament-fortify::two-factor.messages.confirm-two-factor-code')}}
                                                <sup class="font-medium text-danger-700">*</sup>
                                            </span>
                                        </label>
                                    </div>
                                    <div
                                        class="flex items-center space-x-1 rtl:space-x-reverse group filament-forms-text-input-component"
                                    >
                                        <div class="flex-1">
                                            <input name="code" type="text" id="code"
                                                   required=""
                                                   class="block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600 disabled:opacity-70 dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600"
                                            >
                                        </div>
                                    </div>
                                    <div
                                        class="flex items-center space-x-1 rtl:space-x-reverse group filament-forms-button-component"
                                    >
                                        <div class="flex-1">
                                            <x-filament::button type="submit" color="success">
                                                {{__("filament-fortify::two-factor.buttons.enable.label")}}
                                            </x-filament::button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <x-slot name="footer">
                            <div class="flex justify-between">
                                <form method="POST" action="{{route('two-factor.recovery-codes')}}">
                                    @csrf
                                    <x-filament::button type="submit" color="secondary">
                                        {{__("filament-fortify::two-factor.buttons.regenerate.label")}}
                                    </x-filament::button>
                                </form>
                                <form method="POST" action="{{route('two-factor.disable')}}">
                                    @method('DELETE')
                                    @csrf
                                    <x-filament::button type="submit" color="danger">
                                        {{__("filament-fortify::two-factor.buttons.disable.label")}}
                                    </x-filament::button>
                                </form>
                            </div>
                        </x-slot>
                    </div>

                </x-filament::card>
            </div>
        </div>
    @elseif(! \Laravel\Fortify\Fortify::confirmsTwoFactorAuthentication() && auth()->user()->two_factor_secret)
        <div class="flex items-center justify-center ">
            <div class="p-2 max-w-md  ">
                <x-filament::card>
                    <div class="text-center space-y-8">
                        <div>
                            <div class="font-bold">
                                {{__("filament-fortify::two-factor.messages.scan-qr")}}
                            </div>
                            <div class="flex items-center justify-center mt-2">
                                {!!auth()->user()->twoFactorQrCodeSvg()!!}
                            </div>
                        </div>

                        <div class="text-left text-sm">
                            {{__("filament-fortify::two-factor.messages.store-recovery-code")}}
                            <div class="flex items-center justify-center">
                                <div class="mt-2 text-left text-sm">
                                    @foreach((array) auth()->user()->recoveryCodes() as $index => $code)
                                        <p class="mt-2">{{$index + 1}}) {{$code}}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <x-slot name="footer">
                            <div class="flex justify-between">
                                <form method="POST" action="{{route('two-factor.recovery-codes')}}">
                                    @csrf
                                    <x-filament::button type="submit" color="secondary">
                                        {{__("filament-fortify::two-factor.buttons.regenerate.label")}}
                                    </x-filament::button>
                                </form>
                                <form method="POST" action="{{route('two-factor.disable')}}">
                                    @method('DELETE')
                                    @csrf
                                    <x-filament::button type="submit" color="danger">
                                        {{__("filament-fortify::two-factor.buttons.disable.label")}}
                                    </x-filament::button>
                                </form>
                            </div>
                        </x-slot>
                    </div>

                </x-filament::card>
            </div>
        </div>

    @elseif(auth()->user()->hasEnabledTwoFactorAuthentication())
        <form method="POST" action="{{route('two-factor.disable')}}">
            @method('DELETE')
            @csrf
            <x-filament::button type="submit" color="danger">
                {{__("filament-fortify::two-factor.buttons.disable.label")}}
            </x-filament::button>
        </form>
    @else
        <form method="POST" action="{{route('two-factor.enable')}}">
            @csrf
            <x-filament::button type="submit">
                {{__("filament-fortify::two-factor.buttons.enable.label")}}
            </x-filament::button>
        </form>
    @endif
</x-filament::page>
