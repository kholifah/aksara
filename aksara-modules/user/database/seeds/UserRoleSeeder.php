<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Model::unguard();

        App\Role::truncate();

        $role = App\Role::create([
            'name' => 'Admin User',
            'permissions' => [
                //manage user
                'list-user',
                'add-user',
                'edit-user',
                'delete-user',
                'add-user-role',
                'remove-user-role',

                //manage role
                'list-role',
                'add-role',
                'edit-role',
                'delete-role',
            ],
        ]);

        $adminEmail = 'admin@gmail.com';

        $user = App\User::where('email', $adminEmail)->first();
        if (!$user) {
            throw new \Exception("Admin user not found with email $adminEmail");
        }

        $user->roles()->attach($role);

        Model::reguard();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
