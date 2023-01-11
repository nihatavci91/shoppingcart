<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(10)->create();

        Coupon::create([
            'code' => 'Code15',
            'discount' => 15
        ]);

        Coupon::create([
            'code' => 'Code25',
            'discount' => 25
        ]);

        User::create([
            'name' => 'Nihat',
            'surname' => 'AVCI',
            'email' => 'nihatavci91@gmail.com',
            'password' => Hash::make('12345678')
        ]);
    }
}
