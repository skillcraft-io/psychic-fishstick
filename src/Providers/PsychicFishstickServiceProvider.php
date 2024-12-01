<?php

namespace Skillcraft\PsychicFishstick\Providers;

use Illuminate\Support\ServiceProvider;

class PsychicFishstickServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Publish configuration, migrations, or assets
        $this->publishes([
            __DIR__.'/../../config/psychic-fishstick.php' => config_path('psychic-fishstick.php'),
        ], 'pipeline-config');

        // Load custom configuration, routes, or commands if necessary
        $this->mergeConfigFrom(
            __DIR__.'/../../config/psychic-fishstick.php',
            'psychic-fishstick'
        );
    }

    public function register(): void
    {
        //
    }
}
