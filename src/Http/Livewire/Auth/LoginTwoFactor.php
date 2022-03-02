<?php

namespace WyChoong\FilamentFortify\Http\Livewire\Auth;

use Filament\Facades\Filament;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LoginTwoFactor extends Component implements HasForms
{
    use InteractsWithForms;

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('code')
                ->extraInputAttributes(['name' => 'code'])
                ->label(__('filament-fortify::two-factor.login.fields.code.label')),
            TextInput::make('recovery_code')
                ->extraInputAttributes(['name' => 'recovery_code'])
                ->label(__('filament-fortify::two-factor.login.fields.recovery_code.label')),

        ];
    }

    public function render(): View
    {
        return view('filament-fortify::login-two-factor')
            ->layout('filament::components.layouts.base', [
                'title' => __('filament-fortify::two-factor.login.title'),
            ]);
    }
}
