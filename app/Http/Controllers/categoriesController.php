<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use App\Models\categories;
use Illuminate\Http\Request;

class categoriesController extends Controller
{
    public function index(Request $request)
    {
        if (categories::all()->isEmpty()) {
            return response()->json([
                'message' => 'No hay usuarios registrados'
            ], 404);
        }elseif ($request->id) {
            $card = categories::findOrFail($request->id);
            return response()->json($card, 200);
        }
        elseif (categories::all()->isNotEmpty()) {
            $card = categories::all();
            return response()->json($card, 200);
        }
    }
    public function update(Request $request)
    {
        $card = categories::find($request->id);


        if($card){
            if ($request->has('name')) {
                $card->name = $request->name;
            }
            if ($request->has('id_set')) {
                $card->id_set = $request->id_set;
            }
            if ($request->has('release_date')) {
                $card->release_date = Carbon::createFromFormat('d/m/Y', $request->release_date)->format('Y-m-d');
            }
            if ($request->has('total_cards')) {
                $card->total_cards = $request->total_cards;
            }if ($request->has('image')){
                $card->image = $request->image;
            }if ($request->has('deleted')){
                $card->deleted = $request->deleted;
            }
        }
        $card->save();

        return response()->json([
            'name' => $card->name,
            'image' => $card->image,
            'total_cards' => $card->total_cards,
            'id_set' => $card->id_set,
            'release_date' => $card->release_date,
            'deleted' => $card->deleted
        ], 200);
    }

    public function store(Request $request)
    {
        $card = new categories();

        if ($card) {
            $card->name = $request->name;
            $card->id_set = $request->id_set;
            $card->total_cards = $request->total_cards;
            $card->image = $request->image;
            $card->release_date = Carbon::createFromFormat('d/m/Y', $request->release_date)->format('Y-m-d');


            if ($card->save()) {
                return response()->json([
                    'name' => $card->name,
                    'image' => $card->image,
                    'total_cards' => $card->total_cards,
                    'id_set' => $card->id_set,
                    'release_date' => $card->release_date,
                    'message' => 'Carta actualizada'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Error al actualizar la carta'
                ], 500);
            }
        } else {
            return response()->json([
                'message' => 'Carta no encontrada'
            ], 404);
        }
    }

    public function delete(Request $request)
    {

        $card = categories::find($request->id);

        if ($card) {
            if ($card->delete()) {
                return response()->json([
                    'Message' => 'Carta eliminada'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Error al actualizar la carta'
                ], 500);
            }
        } else {
            return response()->json([
                'message' => 'Carta no encontrada'
            ], 404);
        }
    }
}
