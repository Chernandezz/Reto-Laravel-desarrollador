<?php

namespace Database\Seeders;

use App\Models\Maquinaria;
use Illuminate\Database\Seeder;

class MaquinariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            Maquinaria::factory()->create([
                'name' => 'Maquina ' . $i,
                'description' => 'Descripcion ' . $i,
                'dailyPrice' => rand(1, 10) * rand(1, 10),
                'category' => 'Alicates',
                'availability' => '1'
            ]);
        }
        for ($i = 10; $i < 15; $i++) {
            Maquinaria::factory()->create([
                'name' => 'Maquina ' . $i,
                'description' => 'Descripcion ' . $i,
                'dailyPrice' => rand(1, 10) * rand(1, 10),
                'category' => 'Pesada',
                'availability' => '1'
            ]);
        }
        for ($i = 20; $i < 25; $i++) {
            Maquinaria::factory()->create([
                'name' => 'Maquina ' . $i,
                'description' => 'Descripcion ' . $i,
                'dailyPrice' => rand(1, 10) * rand(1, 10),
                'category' => 'Taladro',
                'availability' => '1'
            ]);
        }
    }
}
