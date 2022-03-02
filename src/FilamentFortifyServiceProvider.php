<?php

namespace WyChoong\FilamentFortify;

use Spatie\LaravelPackageTools\Package;

use Filament\PluginServiceProvider;
use Livewire\Livewire;

use WyChoong\FilamentFortify\Commands\FilamentFortifyCommand;
use WyChoong\FilamentFortify\Pages;
use WyChoong\FilamentFortify\Http\Livewire\Auth;
use WyChoong\FilamentFortify\Http\Responses\LoginResponse;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

use Laravel\Fortify\Fortify;
use Laravel\Fortify\Features;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class FilamentFortifyServiceProvider extends PluginServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
        * This class is a Package Service Provider
        *
        * More info: https://github.com/spatie/laravel-package-tools
        */

        config([
            ## override filament login page
            'filament.auth.pages.login' => Auth\Login::class,
            ## force fortify view enabled
            'fortify.views' => true,
            ## force fortify to use filament home_url
            'fortify.home' => config('filament.home_url'),
        ]);

        Livewire::component(Auth\Register::getName(), Auth\Register::class);
        Livewire::component(Auth\PasswordReset::getName(), Auth\PasswordReset::class);
        Livewire::component(Auth\RequestPasswordReset::getName(), Auth\RequestPasswordReset::class);
        Livewire::component(Pages\TwoFactor::getName(), Pages\TwoFactor::class);

        $package
            ->name('filament-fortify')
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations()
            ->hasCommand(FilamentFortifyCommand::class);
    }

    public function packageBooted(): void
    {
        Fortify::loginView(function () {
            return app()->call(Auth\Login::class);
        });

        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);

        if (Features::enabled(Features::registration())) {
            Fortify::registerView(function () {
                return app()->call(Auth\Register::class);
            });
        }

        if (Features::enabled(Features::resetPasswords())) {
            Fortify::requestPasswordResetLinkView(function () {
                return app()->call(Auth\RequestPasswordReset::class);
            });

            Fortify::resetPasswordView(function ($request) {
                return app()->call(Auth\PasswordReset::class);
            });
        }

        if (Features::enabled(Features::emailVerification())) {
            Fortify::verifyEmailView(function () {
                return view('filament-fortify::verify-email');
            });
        }

        Fortify::confirmPasswordView(function () {
            return app()->call(Auth\PasswordConfirmation::class);
        });

        if (Features::enabled(Features::twoFactorAuthentication())) {
            Fortify::twoFactorChallengeView(function () {
                return app()->call(Auth\LoginTwoFactor::class);
            });
        }
    
        Route::domain(config('filament.domain'))
            ->middleware(config('filament.middleware.base'))
            ->name('filament.')
            ->group(function () {
                Route::prefix(config('filament.path'))->group(function () {
                    Route::get('/filament-login', fn () => Redirect::route('login'))
                        ->name('auth.login');
                });
            });
    }

    protected function getPages(): array
    {
        return config('filament-fortify.register-page') ? [
            Pages\TwoFactor::class,
        ] : [];
    }
}
