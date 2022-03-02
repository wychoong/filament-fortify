<?php

namespace WyChoong\FilamentFortify\Http\Livewire\Auth;

use Filament\Facades\Filament;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PasswordReset extends Component implements HasForms
{
    use InteractsWithForms;

    public $email = '';
    public $password = '';
    public $token = '';

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->form->fill();

        if (session('status')) {
            Filament::notify('success', session('status'), true);
        }
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('email_label')
                ->label(__('filament-fortify::register.fields.email.label'))
                ->afterStateHydrated(fn ($component) => $component->state(request()->get('email')))
                ->disabled(),
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
            Hidden::make('email')
                ->extraAttributes(['name' => 'email'])
                ->afterStateHydrated(fn ($component) => $component->state(request()->get('email'))),
            Hidden::make('token')
                ->extraAttributes(['name' => 'token'])
                ->afterStateHydrated(fn ($component) => $component->state(request()->route('token'))),
        ];
    }

    public function render(): View
    {
        return view('filament-fortify::password-reset')
            ->layout('filament::components.layouts.base', [
                'title' => __('filament-fortify::password-reset.title'),
            ]);
    }
}
