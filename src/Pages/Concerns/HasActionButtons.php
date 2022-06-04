<?php

namespace WyChoong\FilamentFortify\Pages\Concerns;

use Filament\Pages\Actions\Action;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\TextInput;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;

trait HasActionButtons
{

    protected ?array $cachedButtons = null;

    protected function getCachedButtons(): array
    {
        if ($this->cachedButtons === null) {
            $this->cacheButtons();
        }

        return $this->cachedButtons;
    }

    protected function cacheButtons(): void
    {
        $this->cachedButtons = collect($this->getButtons())
            ->mapWithKeys(function (Action $action): array {
                $action->livewire($this);

                return [$action->getName() => $action];
            })
            ->toArray();
    }

    protected function getCachedAction(string $name): ?Action
    {
        return $this->getCachedButtons()[$name] ?? parent::getCachedAction($name);
    }

    protected function getButtons(): array | View | null
    {
        $confirmation = fn () => !$this->passwordIsConfirmed();

        $confirmationForm = $confirmation() ? [
            TextInput::make("current_password")
                ->label(__("filament-fortify::two-factor.fields.current_password.label"))
                ->dehydrateStateUsing(fn ($state) => filled($state))
                ->required()
                ->password()
                ->inlineLabel()
                ->rule("current_password")
        ] : [];

        $buttons = [
            'enable' => [
                'action' => 'enableTwoFactorAuthentication',
            ],
            'disable' => [
                'action' => 'disableTwoFactorAuthentication',
                'confirmation' => fn () => is_null(Auth::user()->two_factor_confirmed_at) ? false : $confirmation(),
                'color' => 'danger',
            ],
            'regenerate' => [
                'action' => 'regenerateRecoveryCodes',
                'color' => 'secondary',
            ],
            'confirm' => [
                'action' => 'confirmTwoFactorAuthentication',
                'color' => 'success',
            ],
            'show-recovery-code' => [
                'action' => 'showRecoveryCodes',
                'color' => 'secondary',
            ],
        ];

        return collect($buttons)->map(function ($button, $name) use ($confirmation, $confirmationForm) {
            $action = $button['action'];
            $buttonColor = $button['color'] ?? 'primary';
            $confirmation = isset($button['confirmation']) ? $button['confirmation'] : $confirmation;

            return Action::make($name)
                ->label(__("filament-fortify::two-factor.buttons.{$name}.label"))
                ->form($confirmation() ? $confirmationForm : [])
                ->color($buttonColor)
                ->action(function ($data) use ($action) {

                    if (isset($data['current_password']) && $data['current_password']) {
                        $this->userConfirmedPassword();
                    }

                    app()->call([$this, $action]);
                })
                ->modalHeading(__("filament-fortify::two-factor.confirm-password.modal-heading"))
                ->modalSubheading(__("filament-fortify::two-factor.confirm-password.modal-subheading"))
                ->requiresConfirmation($confirmation);
        })->toArray();
    }

    /**
     * Enable two factor authentication for the user.
     *
     * @param  \Laravel\Fortify\Actions\EnableTwoFactorAuthentication  $enable
     * @return void
     */
    abstract public function enableTwoFactorAuthentication(EnableTwoFactorAuthentication $enable);

    /**
     * Disable two factor authentication for the user.
     *
     * @param  \Laravel\Fortify\Actions\DisableTwoFactorAuthentication  $disable
     * @return void
     */
    abstract public function disableTwoFactorAuthentication(DisableTwoFactorAuthentication $disable);

    /**
     * Display the user's recovery codes.
     *
     * @return void
     */
    abstract public function showRecoveryCodes();

    /**
     * Generate new recovery codes for the user.
     *
     * @param  \Laravel\Fortify\Actions\GenerateNewRecoveryCodes  $generate
     * @return void
     */
    abstract public function regenerateRecoveryCodes(GenerateNewRecoveryCodes $generate);

    /**
     * Confirm two factor authentication for the user.
     *
     * @param  \Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication  $confirm
     * @return void
     */
    abstract public function confirmTwoFactorAuthentication(ConfirmTwoFactorAuthentication $confirm);
}
