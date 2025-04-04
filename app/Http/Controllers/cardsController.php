<?php

namespace App\Http\Controllers;

use App\Models\cards;
use Illuminate\Http\Request;

class cardsController extends Controller
{
    public function index(Request $request)
    {
        if (cards::all()->isEmpty()) {
            return response()->json([
                'message' => 'No hay cartas registrados'
            ], 404);
        }elseif ($request->id) {
            $card = cards::findOrFail($request->id);
            return response()->json($card, 200);
        }
        elseif (cards::all()->isNotEmpty()) {
            $card = cards::all();
            return response()->json($card, 200);
        }
    }
    public function update(Request $request)
    {
        $card = cards::find($request->id);


        if($card){
            if ($request->has('name')) {
                $card->name = $request->name;
            }
            if ($request->has('image')) {
                $card->image = $request->image;
            }
            if ($request->has('id_card')) {
                $card->id_card = $request->id_card;
            }
            if ($request->has('id_set')) {
                $card->id_set = $request->id_set;
            }if ($request->has('deleted')){
                $card->deleted = $request->deleted;
            }if($request->has('description')){
                $card->description = $request->description;
            }
        }
        $card['description'] = json_encode($card['description']);
        $card->save();

        return response()->json([
            'name' => $card->name,
            'image' => $card->image,
            'id_card' => $card->id_card,
            'id_set' => $card->id_set,
            'description' => $card->description,
            'deleted' => $card->deleted
        ], 200);
    }

    public function store(Request $request)
    {
        $card = new cards();

        if ($card) {
            $card->id_card = $request->id_card;
            $card->id_set = $request->id_set;
            $card->name = $request->name;
            $card->image = $request->image;
            $card->description = $request->description;

            if ($card->save()) {
                return response()->json([
                    'name' => $card->name,
                    'image' => $card->image,
                    'id_card' => $card->id_card,
                    'id_set' => $card->id_set,
                    'description' => $card->description,
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

        $card = cards::find($request->id);

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
