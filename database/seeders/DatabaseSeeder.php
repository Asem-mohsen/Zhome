<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{


    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            BrandSeeder::class,
            PlatformSeeder::class,
            PlatformFAQSeeder::class,
            TechnologySeeder::class,
            CategorySeeder::class,
            SubcategorySeeder::class,
            FeatureSeeder::class,
            CollectionSeeder::class,
            ProductSeeder::class,
            PromotionSeeder::class,
            SubscriptionSeeder::class,
            CollectionFeatureSeeder::class,
            ProductCollectionSeeder::Class,
            SaleSeeder::class,
            CountrySeeder::class,
            SiteSettingSeeder::class,
            OrderSeeder::class,
            ToolSeeder::class,
        ]);
    }
}
