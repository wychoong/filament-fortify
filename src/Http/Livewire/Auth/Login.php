<?php

namespace WyChoong\FilamentFortify\Http\Livewire\Auth;

use Filament\Facades\Filament;
use Filament\Http\Livewire\Auth\Login as BasePage;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\View\View;
use Laravel\Fortify\Features;

class Login extends BasePage
{

    public $email = '';

    public $resetPasswordEnabled = false;

    public $registrationEnabled = false;

    public function mount(): void
    {
        parent::mount();

        $this->resetPasswordEnabled = Features::enabled(Features::resetPasswords());
        $this->registrationEnabled = Features::enabled(Features::registration());

        if (session('status')) {
            Filament::notify('success', session('status'), true);
        }
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->extraInputAttributes(['name' => 'email'])
                ->label(__('filament::login.fields.email.label'))
                ->email()
                ->required()
                ->autocomplete(),
            TextInput::make('password')
                ->extraInputAttributes(['name' => 'password'])
                ->label(__('filament::login.fields.password.label'))
                ->password()
                ->required(),
            Checkbox::make('remember')
                ->extraInputAttributes(['name' => 'remember'])
                ->label(__('filament::login.fields.remember.label')),
        ];
    }

    public function render(): View
    {
        return view('filament-fortify::login')
            ->layout('filament::components.layouts.base', [
                'title' => __('filament::login.title'),
            ]);
    }
}
