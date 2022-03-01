<?php

namespace WyChoong\FilamentFortify;

use Spatie\LaravelPackageTools\Package;
use WyChoong\FilamentFortify\Commands\FilamentFortifyCommand;
use WyChoong\FilamentFortify\Http\Livewire\Auth\Login;
use Filament\PluginServiceProvider;
use Livewire\Livewire;
use Illuminate\Support\Facades\App;
use Laravel\Fortify\Fortify;
use WyChoong\FilamentFortify\Http\Livewire\Auth\PasswordReset;
use WyChoong\FilamentFortify\Http\Livewire\Auth\Register;
use WyChoong\FilamentFortify\Http\Livewire\Auth\RequestPasswordReset;



use Illuminate\Support\Facades\Route;
use WyChoong\FilamentFortify\Http\Livewire\Auth;

use WyChoong\FilamentFortify\Http\Responses\LoginResponse;
use Illuminate\Support\Facades\Redirect;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Features;

class FilamentFortifyServiceProvider extends PluginServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
        * This class is a Package Service Provider
        *
        * More info: https://github.com/spatie/laravel-package-tools
        */

        ## override filament login page
        config(['filament.auth.pages.login' => Login::class]);

        config([
            ## force fortify view enabled
            'fortify.views' => true,
            ## force fortify to use filament home_url
            'fortify.home' => config('filament.home_url'),
        ]);

        Livewire::component(Register::getName(), Register::class);
        Livewire::component(PasswordReset::getName(), PasswordReset::class);
        Livewire::component(RequestPasswordReset::getName(), RequestPasswordReset::class);

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
}
