<?php

namespace App\Console\Commands\Admin;

use Illuminate\Console\Command;
use App\Models\Sale;
use Carbon\Carbon;

class DeleteExpiredSales extends Command
{
 
    protected $signature = 'sale:delete-expired-sales';
    protected $description = 'Delete sales that have expired';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {
        $todayDate = Carbon::today()->format('Y-m-d');
        $expiredSales = Sale::where('EndDate', '<', $todayDate)->get();

        foreach ($expiredSales as $sale) {
            $sale->where('ID' , $sale->ID)->delete();
            
            $this->info('Deleted sale with ProductID: ' . $sale->ProductID);
        }

        $this->info('Expired sales deleted successfully!');
    }
}