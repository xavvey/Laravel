<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions_tree = [
            [
                'name' => 'admin',
                'permissions' => [
                    ['name' => 'edit own profile'],
                    ['name' => 'delete own profile'],
                    ['name' => 'change roles'],
                    ['name' => 'edit all profiles'],
                    ['name' => 'delete all profiles'],
                ],
            ],
            [
                'name' => 'power user',
                'permissions' => [
                    ['name' => 'edit own profile'],
                    ['name' => 'delete own profile'],
                    ['name' => 'edit all profiles'],
                    ['name' => 'delete all profiles'],
                ],
            ],
            [
                'name' => 'user',
                'permissions' => [
                    ['name' => 'edit own profile'],
                    ['name' => 'delete own profile'],
                ],
            ],
        ];

        foreach($permissions_tree as $role)
        {
            $spatie_role = Role::firstOrCreate([
                'name' => $role['name'],
            ]);

            foreach($role['permissions'] as $permission)
            {
                $spatie_permission = Permission::firstOrCreate([
                    'name' => $permission['name'],
                ]);

                $spatie_role->givePermissionTo($spatie_permission);
            }
        }
    }
}