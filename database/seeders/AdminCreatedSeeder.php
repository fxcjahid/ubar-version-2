<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminCreatedSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory(1)->create()->first();

        $this->assignRoleToUser($user);
    }

    /**
     * Assign admin role to the given user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    private function assignRoleToUser(User $user)
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $permissions = Permission::pluck('id')->all();

        $adminRole->syncPermissions($permissions);

        $user->assignRole($adminRole);
    }
}