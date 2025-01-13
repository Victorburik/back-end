<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RolesAndAdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'permissions' => json_encode(['manage_users', 'approve_suggestions', 'edit_links']),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'user',
                'permissions' => json_encode(['suggest_links']),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
