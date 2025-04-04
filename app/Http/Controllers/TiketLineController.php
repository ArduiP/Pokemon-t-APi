<?php

namespace App\Http\Controllers;

use App\Models\TiketLine;
use Illuminate\Http\Request;

class TiketLineController extends Controller
{
    public function index(Request $request)
    {
        if (TiketLine::all()->isEmpty()) {
            return response()->json([
                'message' => 'No hay lineas de tíquets registradas'
            ], 404);
        } elseif ($request->id) {
            $user = TiketLine::findOrFail($request->id);
            return response()->json($user, 200);
        } elseif (TiketLine::all()->isNotEmpty()) {
            $user = TiketLine::all();
            return response()->json($user, 200);
        }
    }


    public function store(Request $request)
    {
        $user = new TiketLine();
        $user->id_tiket = $request->id_tiket;
        $user->id_producto = $request->id_producto;
        $user->quantity = $request->quantity;
        $user->price = $request->price;

        $user->save();

        return response()->json([
            'id_tiket' => $user->id_tiket,
            'id_producto' => $user->id_producto,
            'quantity' => $user->quantity,
            'price' => $user->price
        ], 200);
    }

    public function update(Request $request)
    {
        $user = TiketLine::findOrFail($request->id);
        $total = $request->quantity * $request->price;
        if ($user) {


            if ($request->has('id_tiket')) {
                $user->id_tiket = $request->id_tiket;
            }
            if ($request->has('id_producto')) {
                $user->id_producto = $request->id_producto;
            }
            if ($request->has('quantity')) {
                $user->quantity = $request->quantity;
            }
            if ($request->has('price')) {
                $user->price = $request->price;
            }
            if ($request->has('deleted')) {
                $user->deleted = $request->deleted;
            }

            if ($user->save()) {
                return response()->json([
                    'id_tiket' => $user->id_tiket,
                    'id_producto' => $user->id_producto,
                    'quantity' => $user->quantity,
                    'price' => $user->price,
                    'deleted' => $user->deleted,
                    'message' => 'Linea de Tíquet actualizado'
                ], 200);
            }
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    public function delete(Request $request)
    {

        $user = TiketLine::find($request->id);

        if ($user) {
            if ($user->delete()) {
                return response()->json([
                    'Message' => 'Linea de tíquet eliminada'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Error al actualizar al usuario'
                ], 500);
            }
        } else {
            return response()->json([
                'message' => 'Linea de tíquet no encontrada'
            ], 404);
        }
    }
}
