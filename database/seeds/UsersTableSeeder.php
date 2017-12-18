<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class, 1)->states('admin')->create([
            'email' => 'admin@user.com'
        ]);

        factory(\App\User::class, 1)->states('responsavel')->create([
            'email' => 'responsavel@user.com'
        ]);

        factory(\App\User::class, 1)->states('atendente')->create([
            'email' => 'atendente@user.com'
        ]);

        factory(\App\User::class, 1)->states('suporte')->create([
            'email' => 'suporte@user.com'
        ]);

        factory(\App\User::class, 1)->states('at_temporario')->create([
            'email' => 'temporario@user.com'
        ]);

    }
}
