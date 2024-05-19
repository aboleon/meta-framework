<?php

namespace _docs\seeders;

use _docs\app\Models\User;
use Illuminate\Database\Seeder;
use MetaFramework\Models\UserRole;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@web.dev'],
            [
                'name' => 'Admin Dev',
                'first_name' => 'Admin',
                'last_name' => 'Dev',
                'password' => bcrypt('randompassword'),
            ]);

        $user->roles()->save(new UserRole(['role_id' => 1]));
    }
}
