<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'mustafaelsayedfouda@hotmail.com',
            'mobile' => '0123456789',
            'role' => 'admin',
            'password' => 'password',
            'is_active' => '1',
        ]);

        User::factory(10)->create();
    }
}
