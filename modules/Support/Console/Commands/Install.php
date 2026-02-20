<?php

namespace Modules\Support\Console\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'up:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install up system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Installed');
    }
}
