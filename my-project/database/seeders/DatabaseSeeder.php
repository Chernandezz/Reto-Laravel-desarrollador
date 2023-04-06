<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\MaquinariaSeeder;
use Database\Seeders\ReservaMaquinariaSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'role' => 'admin'
        ]);

        User::factory()->create([
            'name' => 'user',
            'email' => 'user@user.com',
            'password' => bcrypt('user'),
            'role' => 'usuario'
        ]);

        $this->call([
            MaquinariaSeeder::class,
            ReservaMaquinariaSeeder::class
        ]);
    }
}
