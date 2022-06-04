<?php

namespace WyChoong\FilamentFortify\Pages;

use Filament\Facades\Filament;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;

use Laravel\Fortify\Features;
use WyChoong\FilamentFortify\Facades\FilamentFortify;

class TwoFactor extends Page
{
    use Concerns\HasActionButtons;
    use Concerns\ConfirmPassword;
    use Concerns\ActionButtons {
        mount as actionButtonsMount;
    }

    protected static string $view = "filament-fortify::filament.pages.two-factor";

    public function mount()
    {
        $this->actionButtonsMount();

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

    protected static function getNavigationIcon(): string
    {
        return static::$navigationIcon ?? config('filament-fortify.navigation-icon', 'heroicon-o-key');
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
     * Show two factor authentication info.
     *
     * @return bool
     */
    private function showTwoFactor(): bool
    {
        return ! empty(Auth::user()->two_factor_secret);
    }
}
