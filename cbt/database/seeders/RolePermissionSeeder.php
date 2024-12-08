<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // dsini untuk roles terdiri dari 2 roles ada teacher dan student
        // membuat kelas baru
        $permissions = [
            'view courses',
            'create courses',
            'edit courses',
            'delete courses',
        ];
        // entity nya di simpan ketika membuat sebuah role terbaru
        foreach ($permissions as $permission) {
            Permission::create([
                'name'=> $permission
            ]);
    }
    $teacherRole = Role::create([
        'name'=> 'teacher'
    ]);
    $teacherRole->givePermissionTo([
        'view courses',
        'create courses',
        'edit courses',
        'delete courses',
    ]);
    $studentRole = Role::create([
        'name'=>'student'
    ]);
    $studentRole->givePermissionTo([
        'view courses',
    ]);
    // membuat data user super admin
    $user = User::create([
        'name'  => 'rejes12',
        'email' => 'rejes@gmail.com',
        'password'  => bcrypt('123123123'),
    ]);
    $user->assignRole($teacherRole);
}
}