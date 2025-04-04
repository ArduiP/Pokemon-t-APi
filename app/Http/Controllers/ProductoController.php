<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        if (Producto::all()->isEmpty()) {
            return response()->json([
                'message' => 'No hay productos registrados'
            ], 404);
        }elseif ($request->id) {
            $product = Producto::findOrFail($request->id);
            return response()->json($product, 200);
        }
        elseif (Producto::all()->isNotEmpty()) {
            $product = Producto::all();
            return response()->json($product, 200);
        }
    }
    public function store(Request $request)
    {
        $product = new Producto();
        $product->id_user = $request->id_user;
        $product->id_card = $request->id_card;
        $product->quantity = $request->quantity;
        $product->price = $request->price;

        $product->save();

        return response()->json([
            'quantity' => $product->quantity,
            'price' => $product->price,
            'id_card' => $product->id_card,
            'id_user' => $product->id_user
        ], 200);
    }

    public function update(Request $request)
    {
        $product = Producto::find($request->id);

        if ($product) {
            if ($request->has('quantity')) {
                $product->quantity = $request->quantity;
            }
            if ($request->has('price')) {
                $product->price = $request->price;
            }
            if ($request->has('id_card')) {
                $product->id_card = $request->id_card;
            }
            if ($request->has('id_user')) {
                $product->id_user = $request->id_user;
            }if ($request->has('deleted')){
                $product->deleted = $request->deleted;
            }

            if ($product->save()) {
                return response()->json([
                    'quantity' => $product->quantity,
                    'price' => $product->price,
                    'id_card' => $product->id_card,
                    'id_user' => $product->id_user,
                    'deleted' => $product->deleted,
                    'message' => 'Producto actualizado'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Error al actualizar el producto'
                ], 500);
            }
        } else {
            return response()->json([
                'message' => 'Procuto no encontrado'
            ], 404);
        }
    }

    public function delete(Request $request)
    {

        $product = Producto::find($request->id);

        if ($product) {
            if ($product->delete()) {
                return response()->json([
                    'Message' => 'Producto eliminado'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Error al actualizar el producto'
                ], 500);
            }
        } else {
            return response()->json([
                'message' => 'Producto no encontrado'
            ], 404);
        }
    }
}
