<?php

namespace App\Http\Controllers;

use Carbon\Carbon; // se importa la clase Carbon para trabajar con fechas
use App\Models\Maquinaria; // se importa el modelo Maquinaria
use Illuminate\Http\Request; // se importa la clase Request
use App\Models\ReservaMaquinaria; // se importa el modelo ReservaMaquinaria

class ReservaMaquinariaController extends Controller
{

    // Función para crear una reserva de maquinaria
    public function create(Request $request)
    {
        // Se obtiene la maquinaria seleccionada
        $maquinaria = Maquinaria::findOrFail($request->maquinaria_id);

        // Se parsean las fechas de inicio y fin de la reserva
        $fechaInicio = Carbon::parse($request->fecha_inicio);
        $fechaFin = Carbon::parse($request->fecha_fin);

        // Se valida que la fecha de inicio no sea mayor que la de fin
        if ($fechaInicio->greaterThan($fechaFin)) {
            return response()->json(['message' => 'La fecha de inicio no puede ser mayor que la fecha de fin'], 400);
        }

        // Se busca si hay alguna reserva para la misma maquinaria y fechas seleccionadas
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

        // Si se encuentra alguna reserva en el mismo rango de fechas, se devuelve un mensaje de error
        if ($reservas->count() > 0) {
            return response()->json(['message' => 'La maquinaria no está disponible para las fechas seleccionadas'], 400);
        }

        // Se calcula el precio total de la reserva en base a la cantidad de días y el precio diario de la maquinaria
        $dias = $fechaInicio->diffInDays($fechaFin);
        $precioTotal = $dias * $maquinaria->dailyPrice;

        // Se crea la reserva y se guarda en la base de datos
        $reserva = new ReservaMaquinaria();
        $reserva->maquinaria_id = $maquinaria->id;
        $reserva->user_id = auth()->user()->id;
        $reserva->fecha_inicio = $fechaInicio;
        $reserva->fecha_fin = $fechaFin;
        $reserva->dias = $dias;
        $reserva->precio_total = $precioTotal;
        $reserva->save();

        // Se devuelve un mensaje de éxito
        return response()->json(['message' => 'Reserva creada exitosamente'], 200);
    }

    // Función para obtener todas las reservas de maquinarias
    public function list()
    {
        $reservas = ReservaMaquinaria::all();
        return response()->json($reservas);
    }

    // Función para obtener todas las reservas de maquinarias de un usuario en particular
    public function listUser($id)
    {
        $reservas = ReservaMaquinaria::where('user_id', $id)->get(); // se buscan todas las reservas de maquinarias del usuario con el id proporcionado
        return response()->json($reservas); // se devuelve una respuesta JSON con las reservas encontradas
    }

    // Función para obtener todas las reservas de una maquinaria de un usuario en particular
    public function listUserMaquinaria($id, $idMaquinaria)
    {
        $reservas = ReservaMaquinaria::where('user_id', $id)->where('maquinaria_id', $idMaquinaria)->get(); // se buscan todas las reservas de la maquinaria con el id proporcionado del usuario con el id proporcionado
        return response()->json($reservas); // se devuelve una respuesta JSON con las reservas encontradas
    }

    // Función para obtener todas las reservas que caen dentro de un rango de fechas
    public function listRangoFechas()
    {
        $rango = request()->all(); // se obtienen todas las entradas de la solicitud HTTP
        $fechaInicio = Carbon::parse($rango['fecha_inicio']); // se convierte la fecha de inicio proporcionada a un objeto Carbon
        $fechaFin = Carbon::parse($rango['fecha_fin']); // se convierte la fecha de fin proporcionada a un objeto Carbon
        $reservas = ReservaMaquinaria::whereBetween('fecha_inicio', [$fechaInicio, $fechaFin]) // se buscan las reservas que comienzan dentro del rango de fechas proporcionado
            ->orWhereBetween('fecha_fin', [$fechaInicio, $fechaFin]) // se buscan las reservas que finalizan dentro del rango de fechas proporcionado
            ->orWhere(function ($query) use ($fechaInicio, $fechaFin) { // se busca las reservas que cubren todo el rango de fechas proporcionado
                $query->where('fecha_inicio', '<', $fechaInicio)
                    ->where('fecha_fin', '>', $fechaFin);
            })
            ->get(); // se obtienen todas las reservas encontradas
        return response()->json($reservas); // se devuelve una respuesta JSON con las reservas encontradas
    }
}
