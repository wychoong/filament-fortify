<?php

namespace WyChoong\FilamentFortify;

use Filament\PluginServiceProvider;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;

use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;

use WyChoong\FilamentFortify\Commands\FilamentFortifyCommand;
use WyChoong\FilamentFortify\Http\Responses\LoginResponse;

class FilamentFortifyServiceProvider extends PluginServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
        * This class is a Package Service Provider
        *
        * More info: https://github.com/spatie/laravel-package-tools
        */
        $package
            ->name('filament-fortify')
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations()
            ->hasCommand(FilamentFortifyCommand::class);
    }

    public function packageBooted(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/filament-fortify.php', 'filament-fortify');

        config([
            ## override filament login page
            'filament.auth.pages.login' => config('filament-fortify.auth.login'),
            ## force fortify view enabled
            'fortify.views' => true,
            ## force fortify to use filament home_url
            'fortify.home' => config('filament.home_url'),
            ## mirror admin config
            'forms.dark_mode' => config('filament.dark_mode'),
        ]);

        Livewire::component(config('filament-fortify.auth.register')::getName(), config('filament-fortify.auth.register'));
        Livewire::component(config('filament-fortify.auth.password-reset')::getName(), config('filament-fortify.auth.password-reset'));
        Livewire::component(config('filament-fortify.auth.request-password-reset')::getName(), config('filament-fortify.auth.request-password-reset'));
        Livewire::component(config('filament-fortify.pages.two-factor')::getName(), config('filament-fortify.pages.two-factor'));

        Fortify::loginView(function () {
            return app()->call(config('filament-fortify.auth.login'));
        });

        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);

        if (Features::enabled(Features::registration())) {
            Fortify::registerView(function () {
                return app()->call(config('filament-fortify.auth.register'));
            });
        }

        if (Features::enabled(Features::resetPasswords())) {
            Fortify::requestPasswordResetLinkView(function () {
                return app()->call(config('filament-fortify.auth.request-password-reset'));
            });

            Fortify::resetPasswordView(function ($request) {
                return app()->call(config('filament-fortify.auth.password-reset'));
            });
        }

        if (Features::enabled(Features::emailVerification())) {
            Fortify::verifyEmailView(function () {
                return view(config('filament-fortify.view.verify-email'));
            });
        }

        Fortify::confirmPasswordView(function () {
            return app()->call(config('filament-fortify.auth.password-confirmation'));
        });

        if (Features::enabled(Features::twoFactorAuthentication())) {
            Fortify::twoFactorChallengeView(function () {
                return app()->call(config('filament-fortify.auth.login-two-factor'));
            });
        }

        Route::domain(config('filament.domain'))
            ->middleware(config('filament.middleware.base'))
            ->name('filament.')
            ->group(function () {
                /**
                 * We do not need to override logout response and logout path as:
                 * - logout response for both filament and fortify does
                 *    basically the same things except fortify handle for api calls
                 * - for api calls still can use POST fortify's /logout route
                 * - filament's logout route is at /filament/logout
                 */

                /**
                 * Redeclare filament.auth.login route as fortify override it
                 * This route name is used multiple places in filament.
                 */
                Route::prefix(config('filament.path'))->group(function () {
                    Route::get('/filament-login', fn () => Redirect::route('login'))
                        ->name('auth.login');
                });
            });
    }

    protected function getPages(): array
    {
        return config('filament-fortify.register-page') ? [
            config('filament-fortify.pages.two-factor'),
        ] : [];
    }

    protected function mergeConfigFrom($path, $key): void
    {
        $config = $this->app['config']->get($key, []);

        $this->app['config']->set($key, $this->mergeConfig(require $path, $config));
    }

    protected function mergeConfig(array $original, array $merging): array
    {
        $array = array_merge($original, $merging);

        foreach ($original as $key => $value) {
            if (! is_array($value)) {
                continue;
            }

            if (! Arr::exists($merging, $key)) {
                continue;
            }

            if (is_numeric($key)) {
                continue;
            }

            $array[$key] = $this->mergeConfig($value, $merging[$key]);
        }

        return $array;
    }
}
