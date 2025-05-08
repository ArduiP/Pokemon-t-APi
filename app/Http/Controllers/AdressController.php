<?php

namespace App\Http\Controllers;

use App\Models\Adress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class AdressController extends Controller
{



    public function index(Request $request)
    {
        if (adress::all()->isEmpty()) {
            return response()->json([
                'message' => 'No hay direcciones registrados'
            ], 404);
        }elseif ($request->id) {
            $card = adress::findOrFail($request->id);
            return response()->json($card, 200);
        } elseif ($request->id_user) {
            $card = adress::where('id_user', $request->id_user)->get();
            return response()->json($card, 200);
        } elseif (adress::all()->isNotEmpty()) {
            $card = adress::all();
            return response()->json($card, 200);
        }
    }
    public function update(Request $request)
    {
        $card = adress::find($request->id);

        if($card){
            if ($request->has('adress')) {
                $card->adress = $request->adress;
            }
            if ($request->has('number')) {
                $card->number = $request->number;
            }
            if ($request->has('id_user')) {
                $card->id_user = $request->id_user;
            }
            if ($request->has('deleted')){
                $card->deleted = $request->deleted;
            }
        }
        $card->save();

        return response()->json([
            'adress' => $card->adress,
            'number' => $card->number,
            'id_user' => $card->id_user,
            'deleted' => $card->deleted,
        ], 200);
    }

    public function store(Request $request)
    {
        $card = new adress();

        if ($card) {
            $card->adress = $request->adress;
            $card->number = $request->number;
            $card->id_user = $request->id_user;

            if ($card->save()) {
                return response()->json([
                    'adress' => $card->adress,
                    'number' => $card->number,
                    'id_user' => $card->id_user,
                    'message' => 'Dirección actualizada'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Error al actualizar la Dirección'
                ], 500);
            }
        } else {
            return response()->json([
                'message' => 'Dirección no encontrada'
            ], 404);
        }
    }

    public function delete(Request $request)
    {

        $card = adress::find($request->id);

        if ($card) {
            if ($card->delete()) {
                return response()->json([
                    'Message' => 'Dirección eliminada'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Error al actualizar la Dirección'
                ], 500);
            }
        } else {
            return response()->json([
                'message' => 'Dirección no encontrada'
            ], 404);
        }
    }
}
