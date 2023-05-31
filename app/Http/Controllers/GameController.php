<?php

namespace App\Http\Controllers;


use App\Models\Assessment;
use App\Models\Comment;
use App\Models\Game;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            //devuelvo respuesta con error
            return response()->json([
                'message' => 'Error deleting game',
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function valorarJuego(Request $request, $idJuego, $idUsuario)
    {
        //obtengo juego a valorar
        $game = Game::find($idJuego);

        //obtengo el usuario a valorar
        $user = User::find($idUsuario);

        //compruebo si no existe para devolver un error
        if (!$game) {
            return response()->json([
                'message' => 'Game not found'
            ]);
        }

        //obtengo los puntos
        $data = $request->validate([
            'points' => 'required|int',
        ]);

        //creo una instancia de assesments
        $assessment = new Assessment();

        //asigno puntos a la valoracion
        $assessment->points = $data['points'];

        $assessment->user()->associate($user);
        $assessment->game()->associate($game);
        $assessment->save();

        //devuelvo respuesta correcta
        return response()->json([
            'message' => 'Valoracion agregada correctamente',
            'data' => $assessment
        ]);
    }

    public function eliminarValoracion($idValoracion)
    {
        //obtengo Valoracion a eliminar
        $assessment = Assessment::find($idValoracion);

        if (!$assessment) {
            return response()->json([
                'message' => 'Valoracion not found'
            ]);
        }
        //elimino valoracion
        $assessment->delete();

        return response()->json([
            'message' => 'Valoracion eliminada'
        ]);
    }

    public function  comentarJuego(Request $request, $idJuego, $idUsuario)
    {
        //obtengo juego a comentar
        $game = Game::find($idJuego);

        //obtengo el usuario que va a comentar
        $user = User::find($idUsuario);

        //compruebo si no existe para devolver un error
        if (!$game) {
            return response()->json([
                'message' => 'Game not found'
            ]);
        }

        //obtengo el comentario
        $data = $request->validate([
            'comment' => 'required|string',
        ]);

        //creo una instancia de assesments
        $comment = new Comment();
        //asigno comentario al Comentario
        $comment->text = $data['comment'];

        $comment->user()->associate($user);
        $comment->game()->associate($game);
        $comment->save();

        //devuelvo respuesta correcta
        return response()->json([
            'message' => 'Comentario agregado correctamente',
            'data' => $comment
        ]);
    }

    public function eliminarComentario(Request $request, $idComment)
    {

        //obtengo comentario a eliminar
        $comentario = Comment::find($idComment);

        if (!$comentario) {
            return response()->json([
                'message' => 'Comentario not found'
            ]);
        }

        //elimino comentario
        $comentario->delete();

        return response()->json([
            'message' => 'Comentario eliminado'
        ]);
    }

    public function mostrarValoracionesJuego($idJuego)
    {
        //obtener valoraciones del juego
        $valoraciones = DB::table('assessments')
            ->where('game_id', $idJuego)->get();
        //devuelvo valoraciones
        return response()->json([
            'data' => $valoraciones
        ]);
    }

    public function mostrarComentariosJuego($idJuego)
    {
        //obtener valoraciones del juego
        $comentarios = DB::table('comments')
            ->where('game_id', $idJuego)->get();


        // Crear un nuevo array con los datos necesarios
        $comentariosConUsuario = [];
        //recorro lista comentarios
        foreach ($comentarios as $comentario) {

            $comentariosConUsuario[] = [
                'comentario' => $comentario,
                'username' => $comentario->user()->name,
                'img' => $comentario->user()->img
            ];
        }

        //devuelvo valoraciones
        return response()->json([
            'data' => $comentariosConUsuario
        ]);
    }
}
