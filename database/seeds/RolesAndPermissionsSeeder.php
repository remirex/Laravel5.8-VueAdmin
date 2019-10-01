<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');


        Role::create(['name' => 'admin']);
        /** @var \App\User $user */
        $admin = factory(\App\User::class)->create([
            'name' => 'Admin Admin',
            'email' => 'admin@example.com',
            'status' => 'Active',
            'activation_token' => ''
        ]);

        $admin->assignRole('admin');

        Role::create(['name' => 'guest']);

        /** @var \App\User $user */
        $user = factory(\App\User::class)->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'status' => 'Active',
            'activation_token' => ''
        ]);

        $user->assignRole('guest');

    }
}
