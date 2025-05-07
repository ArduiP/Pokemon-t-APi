<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        if (Pago::all()->isEmpty()) {
            return response()->json([
                'message' => 'No hay categorías registradas'
            ], 404);
        }elseif ($request->id) {
            $card = Pago::findOrFail($request->id);
            return response()->json($card, 200);
        }
        elseif (Pago::all()->isNotEmpty()) {
            $card = Pago::all();
            return response()->json($card, 200);
        }
    }
    public function update(Request $request)
    {
        $card = Pago::find($request->id);


        if($card){
            if ($request->has('name')) {
                $card->name = $request->name;
            }
            if ($request->has('user_id')) {
                $card->user_id = $request->user_id;
            }
            if ($request->has('expiration_date')) {
                $card->expiration_date = Carbon::createFromFormat('d/m/Y', $request->expiration_date)->format('Y-m-d');
            }
            if ($request->has('number')) {
                $card->number = $request->number;
            }if ($request->has('cvv')){
                $card->cvv = $request->cvv;
            }
        }
        $card->save();

        return response()->json([
            'name' => $card->name,
            'user_id' => $card->user_id,
            'expiration_date' => $card->expiration_date,
            'number' => $card->number,
            'cvv' => $card->cvv
        ], 200);
    }

    public function store(Request $request)
    {
        $card = new Pago();

        if ($card) {
            $card->user_id = $request->user_id;
            $card->name = $request->name;
            $card->number = $request->number;
            $card->expiration_date = Carbon::createFromFormat('d/m/Y', $request->expiration_date)->format('Y-m-d');
            $card->cvv = $request->cvv;



            if ($card->save()) {
                return response()->json([
                    'user_id' => $card->user_id,
                    'name' => $card->name,
                    'number' => $card->number,
                    'expiration_date' => $card->expiration_date,
                    'cvv' => $card->cvv,
                    'message' => 'Pago registrado correctamente'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Error al actualizar la Tarjeta'
                ], 500);
            }
        } else {
            return response()->json([
                'message' => 'Tarjeta no encontrada'
            ], 404);
        }
    }

    public function delete(Request $request)
    {

        $card = Pago::find($request->id);

        if ($card) {
            if ($card->delete()) {
                return response()->json([
                    'Message' => 'Tarjeta eliminada'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Error al actualizar la Tarjeta'
                ], 500);
            }
        } else {
            return response()->json([
                'message' => 'Tarjeta no encontrada'
            ], 404);
        }
    }
}
