<?php

namespace WyChoong\FilamentFortify\Http\Livewire\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Facades\Filament;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Auth\Events\Registered;

use Illuminate\Contracts\View\View;
use Laravel\Fortify\Contracts\CreatesNewUsers;

use Laravel\Fortify\Contracts\RegisterResponse;
use Livewire\Component;

class Register extends Component implements HasForms
{
    use InteractsWithForms;
    use WithRateLimiting;

    public $name = '';
    public $email = '';
    public $password = '';

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->extraInputAttributes(['name' => 'name'])
                ->label(__('filament-fortify::register.fields.name.label'))
                ->maxLength(255)
                ->required(),
            TextInput::make('email')
                ->extraInputAttributes(['name' => 'email'])
                ->label(__('filament-fortify::register.fields.email.label'))
                ->email()
                ->required()
                ->autocomplete(),
            TextInput::make('password')
                ->extraInputAttributes(['name' => 'password'])
                ->label(__('filament-fortify::register.fields.password.label'))
                ->password()
                ->required()
                ->rules(['confirmed'])
                ->autocomplete('new-password'),
            TextInput::make('password_confirmation')
                ->extraInputAttributes(['name' => 'password_confirmation'])
                ->label(__('filament-fortify::register.fields.password_confirm.label'))
                ->password()
                ->autocomplete('new-password')
                ->required(),
        ];
    }

    public function render(): View
    {
        return view('filament-fortify::register')
            ->layout('filament::components.layouts.base', [
                'title' => __('filament-fortify::register.title'),
            ]);
    }

    public function register(CreatesNewUsers $creator)
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->addError('email', __('filament-fortify::register.messages.throttled', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => ceil($exception->secondsUntilAvailable / 60),
            ]));

            return;
        }

        $data = $this->form->getState();

        event(new Registered($user = $creator->create($data)));

        Filament::auth()->login($user);

        return app(RegisterResponse::class);
    }
}
