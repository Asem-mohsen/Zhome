<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserPhone;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Instantiate Faker
        $faker = Faker::create();

        User::factory(30)->create()->each(function ($user) {
            // Create 2 phones for each user
            UserPhone::factory()->create(['user_id' => $user->id]);
            UserPhone::factory()->create(['user_id' => $user->id]);

            // Create 1 address for each user
            UserAddress::factory()->create(['user_id' => $user->id]);
        });

        $role = Role::where('role', 'master admin')->first();

        $adminUser = User::factory()->create([
            'name' => 'Smarven Admin',
            'email' => 'smarven-admin@smarven.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'is_admin' => true,
            'status' => 'active',
            'zip_code' => $faker->postcode,
            'role_id' => $role->id,
        ]);

        UserPhone::factory()->count(2)->create(['user_id' => $adminUser->id]);

        UserAddress::factory()->create(['user_id' => $adminUser->id]);
    }
}
