<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Tiket;

class TiketController extends Controller
{
    public function index(Request $request)
    {
        if (Tiket::all()->isEmpty()) {
            return response()->json([
                'message' => 'No hay Tickets registrados'
            ], 404);
        } elseif ($request->id) {
            $user = Tiket::findOrFail($request->id);
            return response()->json($user, 200);
        } elseif (Tiket::all()->isNotEmpty()) {
            $user = Tiket::all();
            return response()->json($user, 200);
        }
    }


    public function store(Request $request)
    {
        $user = new Tiket();
        $user->id_user = $request->id_user;
        $user->id_adress = $request->id_adress;
        $user->total = $request->total;
        $user->completed = $request->completed;

        $user->save();

        return response()->json([
            'id_user' => $user->id_user,
            'id_adress' => $user->id_adress,
            'total' => $user->total,
            'completed' => $user->completed,
        ], 200);
    }

    public function update(Request $request)
    {
        $user = Tiket::findOrFail($request->id);

        if ($user) {


            if ($request->has('id_user')) {
                $user->id_user = $request->id_user;
            }
            if ($request->has('id_adress')) {
                $user->id_adress = $request->id_adress;
            }
            if ($request->has('total')) {
                $user->total = $request->total;
            }
            if ($request->has('completed')) {
                $user->completed = $request->completed;
            }
            if ($request->has('deleted')) {
                $user->deleted = $request->deleted;
            }

            if ($user->save()) {
                return response()->json([
                    'id_user' => $user->id_user,
                    'id_adress' => $user->id_adress,
                    'total' => $user->total,
                    'completed' => $user->completed,
                    'deleted' => $user->deleted,
                    'message' => 'Tiquet actualizado'
                ], 200);
            }
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    public function delete(Request $request)
    {

        $user = Tiket::find($request->id);

        if ($user) {
            if ($user->delete()) {
                return response()->json([
                    'Message' => 'Ticket eliminado'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Error al actualizar al usuario'
                ], 500);
            }
        } else {
            return response()->json([
                'message' => 'Ticket no encontrado'
            ], 404);
        }
    }
}
