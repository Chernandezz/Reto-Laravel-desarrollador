<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Maquinaria;
use Illuminate\Http\Request;
use App\Models\ReservaMaquinaria;

class ReservaMaquinariaController extends Controller
{

    public function create(Request $request)
    {


        $maquinaria = Maquinaria::findOrFail($request->maquinaria_id);
        $fechaInicio = Carbon::parse($request->fecha_inicio);
        $fechaFin = Carbon::parse($request->fecha_fin);

        if ($fechaInicio->greaterThan($fechaFin)) {
            return response()->json(['message' => 'La fecha de inicio no puede ser mayor que la fecha de fin'], 400);
        }

        $reservas = ReservaMaquinaria::where('maquinaria_id', $maquinaria->id)
            ->where(function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
                    ->orWhereBetween('fecha_fin', [$fechaInicio, $fechaFin])
                    ->orWhere(function ($query) use ($fechaInicio, $fechaFin) {
                        $query->where('fecha_inicio', '<', $fechaInicio)
                            ->where('fecha_fin', '>', $fechaFin);
                    });
            })
            ->get();

        if ($reservas->count() > 0) {
            return response()->json(['message' => 'La maquinaria no está disponible para las fechas seleccionadas'], 400);
        }

        $dias = $fechaInicio->diffInDays($fechaFin);
        $precioTotal = $dias * $maquinaria->dailyPrice;

        $reserva = new ReservaMaquinaria();
        $reserva->maquinaria_id = $maquinaria->id;
        $reserva->user_id = auth()->user()->id;
        $reserva->fecha_inicio = $fechaInicio;
        $reserva->fecha_fin = $fechaFin;
        $reserva->dias = $dias;
        $reserva->precio_total = $precioTotal;
        $reserva->save();

        return response()->json(['message' => 'Reserva creada exitosamente'], 200);
    }

    public function list()
    {
        $reservas = ReservaMaquinaria::all();
        return response()->json($reservas);
    }

    public function listUser($id)
    {
        $reservas = ReservaMaquinaria::where('user_id', $id)->get();
        return response()->json($reservas);
    }

    public function listUserMaquinaria($id, $idMaquinaria)
    {
        $reservas = ReservaMaquinaria::where('user_id', $id)->where('maquinaria_id', $idMaquinaria)->get();
        return response()->json($reservas);
    }

    public function listRangoFechas()
    {
        $rango = request()->all();
        $fechaInicio = Carbon::parse($rango['fecha_inicio']);
        $fechaFin = Carbon::parse($rango['fecha_fin']);
        $reservas = ReservaMaquinaria::whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
            ->orWhereBetween('fecha_fin', [$fechaInicio, $fechaFin])
            ->orWhere(function ($query) use ($fechaInicio, $fechaFin) {
                $query->where('fecha_inicio', '<', $fechaInicio)
                    ->where('fecha_fin', '>', $fechaFin);
            })
            ->get();
        return response()->json($reservas);
    }
}
