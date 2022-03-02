<?php

namespace WyChoong\FilamentFortify\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string pageTitle($pageTitle = null)
 * @method static string navigationGroup($navigationGroup = null)
 * @method static string navigationLabel($navigationLabel = null)
 *
 * @see \WyChoong\FilamentFortify\FilamentFortify
 */
class FilamentFortify extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \WyChoong\FilamentFortify\FilamentFortify::class;
    }
}
