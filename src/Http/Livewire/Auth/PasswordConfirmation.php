<?php

namespace WyChoong\FilamentFortify\Http\Livewire\Auth;

use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PasswordConfirmation extends Component implements HasForms
{
    use InteractsWithForms;

    public function mount(): void
    {
        $this->form->fill();

        if (session('status')) {
            Filament::notify('success', session('status'), true);
        }
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('password')
                ->extraInputAttributes(['name' => 'password'])
                ->label(__('filament-fortify::password-confirmation.fields.password.label'))
                ->password()
                ->required(),
        ];
    }

    public function render(): View
    {
        return view('filament-fortify::password-confirmation')
            ->layout('filament::components.layouts.app', [
                'title' => __('filament-fortify::password-confirmation.title'),
                'breadcrumbs' => [
                    __('filament-fortify::password-confirmation.title'),
                ]
            ]);
    }
}
