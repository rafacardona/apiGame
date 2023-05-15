<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //obtengo todos los usuarios
        $users = User::all();

        return response()->json([
            'message' => 'Users find succesfully',
            'data' => $users
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos recibidos del usuario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        try {
                //creo usuario en la bd
                $user = User::create($validatedData);

                return response()->json([
                    'message' => 'User created successfully',
                    'data' => $user,
                ], 201);
            }catch (QueryException $exception){
                return response()->json([
                    'message' => 'Duplicate entry for email',
                ], 400);
        }
    }

    /**
     * Este metodo muestra un usuario en funcion de  su id
     * /usuarios/2 por ejemplo
     */
    public function show($id)
    {
        //obtengo usuario
        $user = User::find($id);

        //si no hay usuario devuelvo error
        if(!$user){
            return response()->json([
                'message' => 'User not found',
            ], 400);
        }

        //devuelvo usuario encontrado
        return response()->json([
           'message' => 'User found succesfully',
            'data' => $user
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //Obtengo usuario por id
        $user = User::find($id);

        //si no hay usuario devuelvo error
        if(!$user){
            return response()->json([
                'message' => 'User not found',
            ], 400);
        }

        //elimino usuario
        $user->delete();

        //devuelvo respuesta
        return response()->json([
            'message' => 'User deleted succesfully',
        ], 200);
    }
}
