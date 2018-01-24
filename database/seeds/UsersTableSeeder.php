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
        $user = factory(App\User::class)->create([
            'name'  => 'Ivan Iglesias',
            'email' => 'ivan.iglesias@3dbconsult.com',
            'role'  => 'super_admin'
        ]);

        $user = factory(App\User::class)->create([
            'name'  => 'Diego Membibre',
            'email' => 'diego.membibre@3dbconsult.com',
            'role'  => 'admin'
        ]);
/*
        $user = factory(App\User::class)->create([
            'name'  => 'Admin User',
            'email' => 'admin@3dbconsult.com',
            'role'  => 'admin'
        ]);
*/
        $user = factory(App\User::class)->create([
            'name'  => 'Regular User',
            'email' => 'user@3dbconsult.com'
        ]);

    }
}
