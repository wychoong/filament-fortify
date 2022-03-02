<?php

namespace WyChoong\FilamentFortify;

class FilamentFortify
{
    protected static string $title = '';

    protected static string $navigationGroup = '';

    protected static string $navigationLabel = '';

    public static bool $registerPage = true;

    public static function navigationGroup($navigationGroup = null): string
    {
        if (filled($navigationGroup)) static::$navigationGroup = $navigationGroup;
        return filled(static::$navigationGroup) ? static::$navigationGroup : __('filament-fortify::two-factor.page.navigation-group');
    }

    public static function navigationLabel($navigationLabel = null): string
    {
        if (filled($navigationLabel)) static::$navigationLabel = $navigationLabel;
        return filled(static::$navigationLabel) ? static::$navigationLabel : __('filament-fortify::two-factor.page.navigation-label');
    }

    public static function title($title = null): string
    {
        if (filled($title)) static::$title = $title;
        return filled(static::$title) ? static::$title : __('filament-fortify::two-factor.page.title');
    }
}
