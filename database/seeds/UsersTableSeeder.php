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
            'username'  => 'ivan.iglesias',
            'name'  => 'Ivan Iglesias',
            'email' => 'ivan.iglesias@3dbconsult.com',
            'role'  => 'super_admin'
        ]);

        $user = factory(App\User::class)->create([
            'username'  => 'diego.membibre',
            'name'  => 'Diego Membibre',
            'email' => 'diego.membibre@3dbconsult.com',
            'role'  => 'admin'
        ]);

        $user = factory(App\User::class)->create([
            'username'  => 'admin.user',
            'name'  => 'Admin User',
            'email' => 'admin@3dbconsult.com',
            'role'  => 'admin'
        ]);

        $user = factory(App\User::class)->create([
            'username'  => 'regular.user',
            'name'  => 'Regular User',
            'email' => 'user@3dbconsult.com'
        ]);

        $user = factory(App\User::class)->create([
            'username'  => 'regular.user.disable',
            'name'  => 'Regular User Disabled',
            'email' => 'user.disabled@3dbconsult.com',
            'enabled' => false
        ]);
    }
}
