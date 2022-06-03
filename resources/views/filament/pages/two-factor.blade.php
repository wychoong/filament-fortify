<x-filament::page>
    @if($this->showTwoFactor())
        <div class="flex items-center justify-center ">
            <div class="p-2 max-w-md  ">
                <x-filament::card>

                    <div class="text-center space-y-8">
                        <div>
                            @unless($showingQrCode)
                                <div class="font-bold">
                                    {{__("filament-fortify::two-factor.messages.enabled")}}
                                </div>
                            @else
                                <div class="font-bold">
                                    {{__("filament-fortify::two-factor.messages.scan-qr")}}
                                </div>
                                <div class="flex items-center justify-center mt-2">
                                    {!!auth()->user()->twoFactorQrCodeSvg()!!}
                                </div>
                                <br />
                                <p class="text-sm">
                                    {{ __('filament-fortify::two-factor.label.setup-key') }}: {{ decrypt(auth()->user()->two_factor_secret) }}
                                </p>
                            @endif
                        </div>

                        @if($showingRecoveryCodes)
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
                        @endif

                        @if($showingConfirmation)
                            <div>
                                <div
                                    class="flex items-center justify-between space-x-2 rtl:space-x-reverse"
                                >
                                    <span
                                        class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300"
                                    >
                                        {{__('filament-fortify::two-factor.messages.confirm-two-factor-code')}}
                                        <sup class="font-medium text-danger-700">*</sup>
                                    </span>
                                </div>
                                <div class="mt-4">
                                    {{ $this->form}}
                                </div>
                            </div>

                        @endif

                        <x-slot name="footer">
                            <div class="flex justify-between">
                                <x-filament::button type="button" color="danger" wire:click="disableTwoFactorAuthentication">
                                    {{__("filament-fortify::two-factor.buttons.disable.label")}}
                                </x-filament::button>

                                @if($showingRecoveryCodes)
                                    <x-filament::button type="button" color="secondary" wire:click="regenerateRecoveryCodes">
                                        {{__("filament-fortify::two-factor.buttons.regenerate.label")}}
                                    </x-filament::button>
                                @elseif($showingConfirmation)
                                    <x-filament::button type="button" color="success" wire:click="confirmTwoFactorAuthentication">
                                    {{__("filament-fortify::two-factor.buttons.enable.label")}}
                                    </x-filament::button>
                                @else
                                    <x-filament::button type="button" color="secondary" wire:click="showRecoveryCodes">
                                        {{__("filament-fortify::two-factor.buttons.show-recovery-code.label")}}
                                    </x-filament::button>
                                @endif
                            </div>
                        </x-slot>
                    </div>

                </x-filament::card>
            </div>
        </div>

    @else
        <x-filament::button type="button" wire:click="enableTwoFactorAuthentication">
            {{__("filament-fortify::two-factor.buttons.enable.label")}}
        </x-filament::button>
    @endif
</x-filament::page>
