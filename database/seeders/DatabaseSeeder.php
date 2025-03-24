<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Role::create(['name' => 'client','guard_name' => 'api']);
        Role::create(['name' => 'employee','guard_name' => 'api']);
        Role::create(['name' => 'admin','guard_name' => 'api']);

        $permissions = [
            'view plants',
            'order plant',
            'view order status',
            'cancel own command',
            'cancel all commands',
            'view all orders',
            'view own orders',
            'modify order status',
            'view statistics',
            'manage plants',
        ];
        foreach($permissions as $permission)
        {
            Permission::create(["name"=>$permission,'guard_name' => 'api']);
        }


        $clientPerms = [
            'view plants',
            'order plant',
            'view order status',
            'cancel own command',
            'view own orders',
        ];
        $client = Role::findByName('client');
        foreach($clientPerms as $permission){
            $client->givePermissionTo($permission);
        }

        $emplPerms = [
            'cancel all commands',
            'view all orders',
            'modify order status',
        ];
        $employee = Role::findByName('employee');
        foreach($emplPerms as $permission){
            $employee->givePermissionTo($permission);
        }

        $adminPerms = [
            'view statistics',
            'manage plants',
        ];
        $admin = Role::findByName('admin');
        foreach($adminPerms as $permission){
            $admin->givePermissionTo($permission);
        }
    }
}
