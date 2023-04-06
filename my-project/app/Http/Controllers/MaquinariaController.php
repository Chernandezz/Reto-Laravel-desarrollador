<?php

namespace App\Http\Controllers;

use App\Models\Maquinaria;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

class MaquinariaController extends Controller
{


    public function create(Request $request)
    {

        if (!AuthController::isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $maquinaria = new Maquinaria();
        $maquinaria->name = $request->name;
        $maquinaria->description = $request->description;
        $maquinaria->availability = $request->availability;
        $maquinaria->dailyPrice = $request->dailyPrice;
        $maquinaria->save();

        return response()->json(['message' => 'Maquina creada con exito'], 201);
    }

    public function list()
    {
        if (!AuthController::isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $maquinaria = Maquinaria::all();

        return response()->json($maquinaria);
    }

    public function update()
    {
        if (!AuthController::isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = request()->all();

        $maquinaria = Maquinaria::find($data['id']);
        $maquinaria->name = $data['name'];
        $maquinaria->description = $data['description'];
        $maquinaria->availability = $data['availability'];
        $maquinaria->dailyPrice = $data['dailyPrice'];
        $maquinaria->save();

        return response()->json(['message' => 'Maquina editada con exito'], 201);
    }

    public function delete($id)
    {
        if (!AuthController::isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $maquinaria = Maquinaria::find($id);
        $maquinaria->delete();
        return response()->json(['message' => 'Maquina eliminada con exito'], 201);
    }

    public function listCategoria($categoria)
    {
        $maquinaria = Maquinaria::where('category', $categoria)->get();
        return response()->json($maquinaria);
    }
}
