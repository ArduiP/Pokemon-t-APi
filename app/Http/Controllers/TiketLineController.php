<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use App\Models\TiketLine;
use App\Models\Producto;
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
        $object = new Producto();
        $tikete = new Tiket();
        $object = $object->find($request->id_producto);
        $tikete = $tikete->find($request->id_tiket);
        $user->id_tiket = $request->id_tiket;
        $user->id_producto = $request->id_producto;
        $user->quantity = $request->quantity;
        $user->price = $request->quantity * $object->price;
        if($object->quantity < $request->quantity){
            return response()->json([
                'message' => 'No hay suficiente stock'
            ], 404);
        } else {
            $object->quantity -=  $request->quantity;
        }
        //Actualizar producto
        $product = new ProductoController();
        $tiketController = new TiketController();
        $requesty = ["id" => $request->id_producto, "quantity" => $object->quantity];
        $requestInstance = new Request($requesty);
        $product->update($requestInstance);
        //Actualziar Tiket
        $requesty = ["id" => $request->id_tiket, "total" => ($tikete->total + $user->price)];
        $requestInstance = new Request($requesty);
        $tiketController->update($requestInstance);

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
        $object = new Producto();
        $object = $object->find($user->id_producto);
        $product = new ProductoController();
        $requesty = ["id" => $user->id_producto, "quantity" => ($object->quantity-($request->quantity-$user->quantity))];
        $requestInstance = new Request($requesty);
        $object = $object->find($request->id_producto);
        $total = $request->quantity * $object->price;
        if ($user) {


            if ($request->has('id_tiket')) {
                $user->id_tiket = $request->id_tiket;
            }
            if ($request->has('id_producto')) {
                $user->id_producto = $request->id_producto;
            }
            if ($request->has('quantity')) {
                if ($object->quantity < $request->quantity) {
                    return response()->json([
                        'message' => 'No hay suficiente stock'
                    ], 404);
                } else {
                    $object->quantity -=  $request->quantity;
                    $user->quantity = $request->quantity;
                    $product->update($requestInstance);
                    $user->price = $total;//Se ejecuta aquí porque se ha actualizado el producto así se actualiza el costo
                }
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
        $object = new Producto();
        $object = $object->find($user->id_producto);

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
