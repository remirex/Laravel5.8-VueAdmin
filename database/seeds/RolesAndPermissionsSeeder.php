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


        Role::create(['name' => 'user']);
        Permission::create(['name' => 'view']);
        /** @var \App\User $user */
        $user = factory(\App\User::class)->create();

        $user->assignRole('user');
        $user->givePermissionTo('view');

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'moderator']);
        Permission::create(['name' => 'create']);

        /** @var \App\User $user */
        $admin = factory(\App\User::class)->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $admin->assignRole(['admin', 'moderator']);
        $user->givePermissionTo('create');
    }
}
