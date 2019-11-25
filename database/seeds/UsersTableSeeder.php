<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        App\User::truncate();

        factory(App\User::class, 4)->create();
    }
}
