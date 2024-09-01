<?php

namespace App\Console\Commands\User;

use Illuminate\Console\Command;
use App\Models\Product;
use Carbon\Carbon;

class RemoveExpiredSales extends Command
{
    protected $signature = 'sales:remove-expired';
    protected $description = 'Remove products from sale if the sale end date has passed';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Fetch products with active sales that have an end date in the past
        $expiredSales = Product::whereHas('sale', function($query) {
            $query->where('EndDate', '<', Carbon::now());
        })->get();

        foreach ($expiredSales as $product) {
            $product->sale()->delete();


            $this->info('Expired sale removed for product ID: ' . $product->ID);
        }

        $this->info('Expired sales removal completed.');
    }
}