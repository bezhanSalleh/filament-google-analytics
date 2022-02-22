<?php

namespace BezhanSalleh\FilamentGoogleAnalytics\Commands;

use Illuminate\Console\Command;

class FilamentGoogleAnalyticsCommand extends Command
{
    public $signature = 'filament-google-analytics';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
