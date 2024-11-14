<?php

namespace App\Console\Commands;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ClearExpiredSales extends Command
{
    protected $signature = 'app:clear-expired-sales';

    protected $description = 'Deletes expired sales';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Sale::where('end_date', '<', Carbon::now())->delete();
    }
}
