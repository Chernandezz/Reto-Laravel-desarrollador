<?php

namespace App\Http\Controllers;

use App\Models\Maquinaria; // importa el modelo Maquinaria
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

class MaquinariaController extends Controller
{
    // Función para crear una nueva máquina
    public function create(Request $request)
    {
        // Comprueba si el usuario es un administrador utilizando la función isAdmin del controlador AuthController.
        if (!AuthController::isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Crea un nuevo objeto Maquinaria y guarda los datos enviados en la solicitud
        $maquinaria = new Maquinaria();
        $maquinaria->name = $request->name;
        $maquinaria->description = $request->description;
        $maquinaria->availability = $request->availability;
        $maquinaria->dailyPrice = $request->dailyPrice;
        $maquinaria->save();

        // Retorna una respuesta en formato JSON con un mensaje de éxito y un código de estado 201
        return response()->json(['message' => 'Maquina creada con exito'], 201);
    }

    // Función para listar todas las máquinas
    public function list()
    {
        // Comprueba si el usuario es un administrador utilizando la función isAdmin del controlador AuthController.
        if (!AuthController::isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Obtiene todas las máquinas de la base de datos y las retorna en formato JSON
        $maquinaria = Maquinaria::all();
        return response()->json($maquinaria);
    }

    // Función para actualizar una máquina
    public function update()
    {
        // Comprueba si el usuario es un administrador utilizando la función isAdmin del controlador AuthController.
        if (!AuthController::isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Obtiene los datos enviados en la solicitud y actualiza la máquina correspondiente en la base de datos
        $data = request()->all();
        $maquinaria = Maquinaria::find($data['id']);
        $maquinaria->name = $data['name'];
        $maquinaria->description = $data['description'];
        $maquinaria->availability = $data['availability'];
        $maquinaria->dailyPrice = $data['dailyPrice'];
        $maquinaria->save();

        // Retorna una respuesta en formato JSON con un mensaje de éxito y un código de estado 201
        return response()->json(['message' => 'Maquina editada con exito'], 201);
    }

    // Función para eliminar una máquina
    public function delete($id)
    {
        // Comprueba si el usuario es un administrador utilizando la función isAdmin del controlador AuthController.
        if (!AuthController::isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Elimina la máquina correspondiente en la base de datos y retorna una respuesta en formato JSON con un mensaje de éxito y un código de estado 201
        $maquinaria = Maquinaria::find($id);
        $maquinaria->delete();
        return response()->json(['message' => 'Maquina eliminada con exito'], 201);
    }

    public function listCategoria($categoria)
    {
        $maquinaria = Maquinaria::where('category', $categoria)->get(); // Busca todas las máquinas en la base de datos que pertenecen a la categoría proporcionada
        return response()->json($maquinaria); // Devuelve la lista de máquinas encontradas en formato JSON
    }
}
