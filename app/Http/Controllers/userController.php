<?php

namespace App\Http\Controllers;

use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class userController extends Controller
{
    public function index(Request $request)
    {
        if (users::all()->isEmpty()) {
            return response()->json([
                'message' => 'No hay usuarios registrados'
            ], 404);
        } elseif ($request->id) {
            $user = users::findOrFail($request->id);
            return response()->json($user, 200);
        } elseif (users::all()->isNotEmpty()) {
            $user = users::all();
            return response()->json($user, 200);
        }
    }


    public function store(Request $request)
    {
        $user = new users();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->surname = $request->surname;
        if ($request->password) {
            $user->password = Hash::make($request->password); // Hashear la contraseña si se proporciona
        }
        $user->role = $request->role;
        $user->birth_date = $request->birth_date;
        $user->gender = $request->gender;
        $user->vendor = $request->vendor;

        $user->save();

        return response()->json([
            'username' => $user->username,
            'email' => $user->email,
            'name' => $user->name,
            'surname' => $user->surname,
            'password' => $user->password,
            'role' => $user->role,
            'gender' => $user->gender
        ], 200);
    }

    public function update(Request $request)
    {
        $user = users::findOrFail($request->id);

        if ($user) {


            if ($request->has('username')) {
                $user->username = $request->username;
            }
            if ($request->has('email')) {
                $user->email = $request->email;
            }
            if ($request->has('name')) {
                $user->name = $request->name;
            }
            if ($request->has('surname')) {
                $user->surname = $request->surname;
            }
            if ($request->has('password')) {
                $user->old_password = $user->password; // Guardar la contraseña anterior
                $user->password = Hash::make($request->password); // Hashear la contraseña si se proporciona
            }
            if ($request->has('role')) {
                $user->role = $request->role;
            }
            if ($request->has('vendor')) {
                $user->vendor = $request->vendor;
            }
            if ($request->has('birth_date')) {
                $user->birth_date = $request->birth_date;
            }
            if ($request->has('gender')) {
                $user->gender = $request->gender;
            }
            if ($request->has('deleted')) {
                $user->deleted = $request->deleted;
            }

            if ($user->save()) {
                return response()->json([
                    'username' => $user->username,
                    'email' => $user->email,
                    'name' => $user->name,
                    'surname' => $user->surname,
                    'password' => $user->password,
                    'birth_date' => $user->birth_date,
                    'gender' => $user->gender,
                    'deleted' => $user->deleted,
                    'message' => 'Usuario actualizado'
                ], 200);
            }
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    public function delete(Request $request)
    {

        $user = users::find($request->id);

        if ($user) {
            if ($user->delete()) {
                return response()->json([
                    'Message' => 'Usuario eliminado'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Error al actualizar al usuario'
                ], 500);
            }
        } else {
            return response()->json([
                'message' => 'usuario no encontrado'
            ], 404);
        }
    }
}
