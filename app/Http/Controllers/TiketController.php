<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Tiket;
use App\Models\TiketLine;
use App\Models\Producto;

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
        } elseif ($request->id_user) {
            $user = Tiket::where('id_user', $request->id_user)->get();
            return response()->json($user, 200);
        }elseif (Tiket::all()->isNotEmpty()) {
            $user = Tiket::all();
            return response()->json($user, 200);
        }
    }

    public function create(Request $request)
{
    $ticket = new Tiket();
    $ticket->id_user = $request->input('id_user');
    $ticket->id_adress = $request->input('id_adress'); // si aplica
    $ticket->total = 0;
    $ticket->completed = 0;
    $ticket->deleted = 0;

    if ($ticket->save()) {
        return response()->json([
            'message' => 'Ticket creado correctamente',
            'ticket' => $ticket
        ], 201);
    } else {
        return response()->json([
            'message' => 'Error al crear el ticket'
        ], 500);
    }
}



public function store(Request $request)
{
    // Verifica que el ticket existe
    $tikete = Tiket::findOrFail($request->id_tiket);

    // Verifica que el ticket no esté completo
    if ($tikete->completed === 1) {
        return response()->json(['message' => 'Este ticket ya está completo'], 400);
    }

    $producto = Producto::findOrFail($request->id_producto);

    // Verifica si hay suficiente stock
    if ($producto->quantity < $request->quantity) {
        return response()->json(['message' => 'No hay suficiente stock'], 400);
    }

    // Crea la línea de ticket
    $ticketLine = new TiketLine();
    $ticketLine->id_tiket = $request->id_tiket;
    $ticketLine->id_producto = $request->id_producto;
    $ticketLine->quantity = $request->quantity;
    $ticketLine->price = $producto->price * $request->quantity;

    // Actualiza el stock del producto
    $producto->quantity -= $request->quantity;
    $producto->save();

    // Actualiza el total del ticket
    $tikete->total += $ticketLine->price;
    $tikete->save();

    // Guarda la línea de ticket
    $ticketLine->save();

    return response()->json([
        'id_tiket' => $ticketLine->id_tiket,
        'id_producto' => $ticketLine->id_producto,
        'quantity' => $ticketLine->quantity,
        'price' => $ticketLine->price
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
