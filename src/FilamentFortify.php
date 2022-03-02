<?php

namespace WyChoong\FilamentFortify;

class FilamentFortify
{
    protected static ?string $pageTitle = null;

    protected static ?string $navigationGroup = null;

    protected static ?string $navigationLabel = null;

    public static bool $registerPage = true;

    public static function navigationGroup($navigationGroup = null): string
    {
        if ($navigationGroup === null) {
            return static::$navigationGroup !== null ? static::$navigationGroup : __('filament-fortify::two-factor.page.navigation-group');
        }

        return static::$navigationGroup = $navigationGroup;
    }

    public static function navigationLabel($navigationLabel = null): string
    {
        if ($navigationLabel === null) {
            return static::$navigationLabel !== null ? static::$navigationLabel : __('filament-fortify::two-factor.page.navigation-label');
        }

        return static::$navigationLabel = $navigationLabel;
    }

    public static function pageTitle($pageTitle = null): string
    {
        if ($pageTitle === null) {
            return static::$pageTitle !== null ? static::$pageTitle : __('filament-fortify::two-factor.page.title');
        }

        return static::$pageTitle = $pageTitle;
    }
}
