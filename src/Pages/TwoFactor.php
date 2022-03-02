<?php

namespace WyChoong\FilamentFortify\Pages;

use App\Models\User;
use Closure;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use WyChoong\FilamentFortify\Facades\FilamentFortify;

class TwoFactor extends Page
{
    protected static ?string $navigationIcon = "heroicon-o-document-text"; //config
    protected static string $view = "filament-fortify::filament.pages.two-factor";

    public User $user;
    public $new_password;
    public $new_password_confirmation;
    public $token_name;
    public $abilities = [];
    public $plain_text_token;
    public $hasTeams;

    public $enableTwoFactor = false;

    public function mount()
    {
        if (session('status') == 'two-factor-authentication-enabled') {
            Filament::notify('success', __("filament-fortify::two-factor.messages.enabled"), true);
        }
    }

    protected function getBreadcrumbs(): array
    {
        return [
            url()->current() => FilamentFortify::pageTitle()
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
}
