<x-filament::page>
    @if(auth()->user()->hasEnabledTwoFactorAuthentication())
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
    
    @else
        <form method="POST" action="{{route('two-factor.enable')}}">
            @csrf
            <x-filament::button type="submit">
                {{__("filament-fortify::two-factor.buttons.enable.label")}}
            </x-filament::button>
        </form>
    @endif
</x-filament::page>