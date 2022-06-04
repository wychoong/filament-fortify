<?php

namespace WyChoong\FilamentFortify\Pages;

use Filament\Pages\Page;
use Laravel\Fortify\Features;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;

use Filament\Forms\Concerns\InteractsWithForms;
use WyChoong\FilamentFortify\Facades\FilamentFortify;
use WyChoong\FilamentFortify\Pages\Concerns;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;

class TwoFactor extends Page
{
    use Concerns\HasActionButtons;
    use Concerns\ConfirmPassword;
    use Concerns\ActionButtons {
        mount as actionButtonsMount;
    }

    protected static ?string $navigationIcon = "heroicon-o-document-text"; //config

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
        return !empty(Auth::user()->two_factor_secret);
    }
}
