<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Storage::deleteDirectory('berkas');

        $roles = [
            'admin',
            'manager',
            'user',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        $userAdmin = User::create([
            'name' => 'Mustafa A.',
            'email' => 'mustafa@mail',
            'email_verified_at' => now(),
            'password' => bcrypt('$srb_admin#1224'),
        ]);

        $userAdmin->roles()->sync([1]);

        $userManager = User::create([
            'name' => 'Pjs Kabag Penjaminan',
            'email' => 'pjskabagpenjaminan@mail',
            'email_verified_at' => now(),
            'password' => bcrypt('suretybond@1224'),
        ]);

        $userManager->roles()->sync([2]);
    }
}
