<?php

namespace WyChoong\FilamentFortify;

class FilamentFortify
{
    protected static string $pageTitle = '';

    protected static string $navigationGroup = '';

    protected static string $navigationLabel = '';

    public static bool $registerPage = true;

    public static function navigationGroup($navigationGroup = null): string
    {
        if (filled($navigationGroup)) {
            static::$navigationGroup = $navigationGroup;
        }

        return filled(static::$navigationGroup) ? static::$navigationGroup : __('filament-fortify::two-factor.page.navigation-group');
    }

    public static function navigationLabel($navigationLabel = null): string
    {
        if (filled($navigationLabel)) {
            static::$navigationLabel = $navigationLabel;
        }

        return filled(static::$navigationLabel) ? static::$navigationLabel : __('filament-fortify::two-factor.page.navigation-label');
    }

    public static function pageTitle($pageTitle = null): string
    {
        if (filled($pageTitle)) {
            static::$pageTitle = $pageTitle;
        }

        return filled(static::$pageTitle) ? static::$pageTitle : __('filament-fortify::two-factor.page.title');
    }
}
