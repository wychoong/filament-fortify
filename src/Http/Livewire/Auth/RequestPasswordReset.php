<?php

namespace WyChoong\FilamentFortify\Http\Livewire\Auth;

use Filament\Facades\Filament;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class RequestPasswordReset extends Component implements HasForms
{
    use InteractsWithForms;

    public $email = '';

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->form->fill();

        if (session('status')) {
            Filament::notify('success', session('status'), true);
            redirect()->route('login');
        }
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->extraInputAttributes(['name' => 'email'])
                ->label(__('filament-fortify::password-reset.fields.email.label'))
                ->email()
                ->required()
                ->autocomplete(),
        ];
    }

    public function render(): View
    {
        return view('filament-fortify::request-password-reset')
            ->layout('filament::components.layouts.card', [
                'title' => __('filament-fortify::password-reset.heading'),
            ]);
    }
}
