<?php

namespace WyChoong\FilamentFortify\Pages\Concerns;

trait ConfirmPassword
{
    /**
     * Determine if the user's password has been recently confirmed.
     *
     * @param  int|null  $maximumSecondsSinceConfirmation
     * @return bool
     */
    protected function passwordIsConfirmed($maximumSecondsSinceConfirmation = null)
    {
        $maximumSecondsSinceConfirmation = $maximumSecondsSinceConfirmation ?: config('auth.password_timeout', 900);

        return (time() - session('auth.password_confirmed_at', 0)) < $maximumSecondsSinceConfirmation;
    }

    /**
     * User password coinfirmation passed
     */
    protected function userConfirmedPassword(): void
    {
        session(['auth.password_confirmed_at' => time()]);
    }
}
