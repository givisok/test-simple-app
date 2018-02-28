<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    const TABLE = 'users';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table(self::TABLE)->insert([
            'name'      => 'captain_obvious',
            'email'     => 'captain_obvious@mail.ru',
            'api_token' => '1labatjYdyWZdp774azGJG71JSrfeKryxGglapg1WuwnxT6qGRdBaYHqY1Am',
            'password'  => bcrypt('captain_obvious'),
        ]);
    }
}
