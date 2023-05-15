<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Funcion que devuelve una lista de todos los juegos de la bd
     */
    public function index()
    {
        //obtengo todos los juegos
        $games = Game::all();

        //devuelvo respuesta
        return response()->json([
            'message' => 'Games find succesfully',
            'data' => $games
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            //valido los datos recibidos
            $data = $request->validate([
                'name' => 'required|unique:games|string',
                'autor' => 'required|string',
                'genre' => 'required|string',
                'img' => 'required|string',
                'release_date' => 'required|date',
                'description' => 'required|string',
            ]);

            //guardo el juego en la base de datos
            $game = Game::create($data);

            //devuelvo respuesta
            return response()->json([
                'message' => 'Game created successfully',
                'data' => $game
            ], 201);
        } catch (QueryException $exception) {

            //devuelvo respuesta de error
            return response()->json([
                'message' => 'Duplicate entry for name'
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public
    function show(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public
    function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Metodo para eliminar un juego de la base de datos por su id
     */
    public
    function destroy($id)
    {
        //obtengo juego por id
        $game = Game::find($id);

        //si no hay juego devuelvo error
        if (!$game) {
            return response()->json([
                'message' => 'Game not found'
            ]);
        }
        try {
            //elimino juego
            $game->delete();

            //devuelvo respuesta
            return response()->json([
                'message' => 'Game deleted succesfully'
            ]);

        } catch (\Exception $exception) {

            return response()->json([
                'message' => 'Error deleting game',
                'error' => $exception->getMessage()
            ]);
        }
    }
}
