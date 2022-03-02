<?php

namespace WyChoong\FilamentFortify\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FilamentFortifyCommand extends Command
{
    public $signature = 'filament-fortify:install';

    public $description = 'My command';

    public function handle(): int
    {
        $this->line('Publishing Fortify Assets');
        $this->call('vendor:publish', ['--provider' => 'Laravel\Fortify\FortifyServiceProvider']);

        $this->addProvider();

        $this->comment('All done');
        $this->warn('Don\'t forget to run `php artisan migrate`');

        return self::SUCCESS;
    }

    private function addProvider()
    {
        $appConfig = file_get_contents(config_path('app.php'));

        if (! Str::contains($appConfig, 'App\\Providers\\FortifyServiceProvider::class')) {
            $this->line('Adding FortifyServiceProvider to config/app.php');
            File::put(
                config_path('app.php'),
                str_replace(
                    "App\Providers\RouteServiceProvider::class,",
                    "App\Providers\RouteServiceProvider::class," . PHP_EOL . "        App\Providers\FortifyServiceProvider::class,",
                    $appConfig
                )
            );
            $this->info('FortifyServiceProvider configured');
        } else {
            $this->line('FortifyServiceProvider already configured');
        }
    }
}
