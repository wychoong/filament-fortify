<?php

namespace WyChoong\FilamentFortify\Pages;

use Filament\Pages\Page;
use Laravel\Fortify\Features;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use WyChoong\FilamentFortify\Facades\FilamentFortify;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;

class TwoFactor extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = "heroicon-o-document-text"; //config

    protected static string $view = "filament-fortify::filament.pages.two-factor";

    /**
     * Indicates if two factor authentication QR code is being displayed.
     *
     * @var bool
     */
    public $showingQrCode = false;

    /**
     * Indicates if the two factor authentication confirmation input and button are being displayed.
     *
     * @var bool
     */
    public $showingConfirmation = false;

    /**
     * Indicates if two factor authentication recovery codes are being displayed.
     *
     * @var bool
     */
    public $showingRecoveryCodes = false;

    /**
     * The OTP code for confirming two factor authentication.
     *
     * @var string|null
     */
    public $code;

    public function mount()
    {

        if (
            Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm') &&
            is_null(Auth::user()->two_factor_confirmed_at)
        ) {
            app(DisableTwoFactorAuthentication::class)(Auth::user());
        }

        if (session('status') == 'two-factor-authentication-enabled') {
            Filament::notify('success', __("filament-fortify::two-factor.messages.enabled"), true);
        }
    }

    protected function getBreadcrumbs(): array
    {
        return [
            url()->current() => FilamentFortify::pageTitle(),
        ];
    }

    protected static function getNavigationGroup(): ?string
    {
        return FilamentFortify::navigationGroup();
    }

    public static function getNavigationLabel(): string
    {
        return FilamentFortify::navigationLabel();
    }

    protected function getTitle(): string
    {
        return FilamentFortify::pageTitle();
    }

    /**
     * Input field for two factor authentication confirmation code
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('code')
                ->label(__('filament-fortify::two-factor.fields.code.label'))
                ->validationAttribute(__('filament-fortify::two-factor.fields.code.label'))
                ->inlineLabel()
                ->required(),
        ];
    }

    /**
     * Show two factor authentication info.
     *
     * @return bool
     */
    private function showTwoFactor(): bool
    {
        return !empty(Auth::user()->two_factor_secret);
    }

    /**
     * Enable two factor authentication for the user.
     *
     * @param  \Laravel\Fortify\Actions\EnableTwoFactorAuthentication  $enable
     * @return void
     */
    public function enableTwoFactorAuthentication(EnableTwoFactorAuthentication $enable)
    {
        // if (Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')) {
        //     $this->ensurePasswordIsConfirmed();
        // }

        $enable(Auth::user());

        $this->showingQrCode = true;

        if (Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm')) {
            $this->showingConfirmation = true;
        } else {
            $this->showingRecoveryCodes = true;
        }
    }

    /**
     * Disable two factor authentication for the user.
     *
     * @param  \Laravel\Fortify\Actions\DisableTwoFactorAuthentication  $disable
     * @return void
     */
    public function disableTwoFactorAuthentication(DisableTwoFactorAuthentication $disable)
    {
        // if (Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')) {
        //     $this->ensurePasswordIsConfirmed();
        // }

        $disable(Auth::user());

        $this->showingQrCode = false;
        $this->showingConfirmation = false;
        $this->showingRecoveryCodes = false;
    }

    /**
     * Display the user's recovery codes.
     *
     * @return void
     */
    public function showRecoveryCodes()
    {
        // if (Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')) {
        //     $this->ensurePasswordIsConfirmed();
        // }

        $this->showingRecoveryCodes = true;
    }

    /**
     * Generate new recovery codes for the user.
     *
     * @param  \Laravel\Fortify\Actions\GenerateNewRecoveryCodes  $generate
     * @return void
     */
    public function regenerateRecoveryCodes(GenerateNewRecoveryCodes $generate)
    {
        // if (Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')) {
        //     $this->ensurePasswordIsConfirmed();
        // }

        $generate(Auth::user());

        $this->showingRecoveryCodes = true;
    }

    /**
     * Confirm two factor authentication for the user.
     *
     * @param  \Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication  $confirm
     * @return void
     */
    public function confirmTwoFactorAuthentication(ConfirmTwoFactorAuthentication $confirm)
    {
        // if (Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')) {
        //     $this->ensurePasswordIsConfirmed();
        // }
        $data = $this->form->getState();
        $confirm(Auth::user(), $data['code']);

        $this->showingQrCode = false;
        $this->showingConfirmation = false;
        $this->showingRecoveryCodes = true;
    }
}
