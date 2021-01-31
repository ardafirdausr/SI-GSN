<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = ['admin', 'petugas terminal', 'petugas agen'];
        $permissions = [
            'melihat daftar user',
            'membuat user',
            'mengupdate user',
            'menghapus user',
            'melihat daftar agen pelayaran',
            'membuat agen pelayaran',
            'mengupdate agen pelayaran',
            'menghapus agen pelayaran',
            'melihat daftar kapal',
            'membuat kapal',
            'mengupdate kapal',
            'menghapus kapal',
            'melihat daftar jadwal',
            'melihat daftar jadwal keberangkatan',
            'melihat daftar jadwal kedatangan',
            'membuat jadwal',
            'mengupdate jadwal',
            'menghapus jadwal',
        ];

        // create permissions
        foreach($permissions as $permission){
            Permission::create(['name' => $permission]);
        }

        //create roles
        foreach($roles as $role){
            Role::create(['name' => $role]);
        }

        // assign permission to role
        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->givePermissionTo(Permission::all());

        $petugasTerminalRole = Role::where('name', 'petugas terminal')->first();
        $petugasTerminalRole->givePermissionTo(['mengupdate jadwal']);


        $petugasAgenRole = Role::where('name', 'petugas agen')->first();
        $petugasAgenRole->givePermissionTo(['mengupdate jadwal']);
    }
}
