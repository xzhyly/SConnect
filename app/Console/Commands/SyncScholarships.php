<?php

namespace App\Console\Commands;

use App\Services\ScholarConnectMiddleware;
use Illuminate\Console\Command;

class SyncScholarships extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'scholarships:sync';

    /**
     * The console command description.
     */
    protected $description = 'Fetch and sync scholarships from all mock API sources';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Resolve the middleware via the service container and run the sync.
        app(ScholarConnectMiddleware::class)->syncAll();
        $this->info('Scholarships sync completed.');
        return 0;
    }
}
