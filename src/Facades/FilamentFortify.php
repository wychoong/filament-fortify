<?php

namespace WyChoong\FilamentFortify\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \WyChoong\FilamentFortify\FilamentFortify
 */
class FilamentFortify extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filament-fortify';
    }
}
