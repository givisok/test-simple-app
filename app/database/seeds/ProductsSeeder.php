<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    const TABLE = 'products';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table(self::TABLE)->insert([
            [
                'name'       => 'iPhone 7+',
                'price'      => '55000', //550$
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'       => 'iPhone 6+',
                'price'      => '22500',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'       => 'iPhone 5',
                'price'      => '20000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'       => 'iPhone 4',
                'price'      => '15000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'       => 'Samsung s9',
                'price'      => '100000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'       => 'Samsung s8',
                'price'      => '55000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
