<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
        //factory(\App\Course::class,20000)->create();

        //factory(\App\Contato::class,15000)->create();
    }
}
