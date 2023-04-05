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
        for ($i = 0; $i < 10; $i++) {
            Maquinaria::factory()->create([
                'name' => 'Maquina ' . $i,
                'description' => 'Descripcion ' . $i,
                'dailyPrice' => rand(1, 10) * rand(1, 10),
                'availability' => '1'
            ]);
        }
    }
}
