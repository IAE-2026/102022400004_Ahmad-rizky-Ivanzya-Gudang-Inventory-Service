<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ComponentSeeder::class);

        // Seed Roles
        $gudangRole = \App\Models\Role::firstOrCreate(
            ['name' => 'gudang'],
            ['description' => 'Staff Gudang / Inventory']
        );

        \App\Models\Role::firstOrCreate(
            ['name' => 'admin'],
            ['description' => 'Administrator']
        );

        // Seed simulation user from SSO credentials
        User::updateOrCreate(
            ['email' => 'warga16@ktp.iae.id'],
            [
                'name' => 'Warga 16 (Staff Gudang)',
                'password' => bcrypt('KtpDigital2026!'),
                'role_id' => $gudangRole->id,
            ]
        );
    }
}
