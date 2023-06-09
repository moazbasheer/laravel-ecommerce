<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coupon;
class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::create([
            'code' => 'ABC123',
            'type' => 'fixed',
            'value' => 30
        ]);

        Coupon::create([
            'code' => 'DEF456',
            'type' => 'percent',
            'percent' => 50
        ]);
    }
}
