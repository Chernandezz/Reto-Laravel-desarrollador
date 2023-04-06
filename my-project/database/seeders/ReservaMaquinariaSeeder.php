<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Maquinaria;
use Illuminate\Database\Seeder;
use App\Models\ReservaMaquinaria;

class ReservaMaquinariaSeeder extends Seeder
{
    public function run()
    {
        $maquinarias = Maquinaria::all();
        $users = User::all();

        foreach ($maquinarias as $maquinaria) {
            $fechaInicio = Carbon::now()->addDays(rand(1, 30));
            $fechaFin = Carbon::now()->addDays(rand(31, 60));

            $dias = $fechaInicio->diffInDays($fechaFin);
            $precioTotal = $dias * $maquinaria->dailyPrice;

            $reserva = new ReservaMaquinaria();
            $reserva->maquinaria_id = $maquinaria->id;
            $reserva->user_id = $users->random()->id;
            $reserva->fecha_inicio = $fechaInicio;
            $reserva->fecha_fin = $fechaFin;
            $reserva->dias = $dias;
            $reserva->precio_total = $precioTotal;
            $reserva->save();
        }
    }
}
