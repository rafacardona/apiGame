<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

$userController = new UserController();
app()->instance(UserController::class, $userController);

/*
 * RUTAS
 */

///////////////////////////
/// USUARIO             ///
///////////////////////////
///

//ruta para obtener todos los usuarios
Route::get('/usuarios', 'App\Http\Controllers\UserController@index');

//ruta para obtener usuario por su id
Route::get('/usuarios/find/{id}', 'App\Http\Controllers\UserController@show');

//ruta para crear un usuario
Route::post('/crearUsuario', 'App\Http\Controllers\UserController@store');

//Ruta para buscar un usuario por su mail

//ruta para borrar usuario por su id
Route::get('/usuarios/delete/{id}', 'App\Http\Controllers\UserController@destroy');


///////////////////////////
/// JUEGOS              ///
///////////////////////////

//Ruta para obtener todos los juegos
Route::get('/juegos', 'App\Http\Controllers\GameController@index');

//Ruta para borrar juego por su id
Route::get('/juegos/delete/{id}', 'App\Http\Controllers\GameController@destroy');

//Ruta para crear un juego
Route::post('/juegos/crear', 'App\Http\Controllers\GameController@store');

//Ruta para valorar juego
Route::post('/juegos/{idJuego}/valorar/{idUsuario}', 'App\Http\Controllers\GameController@valorarJuego');
//ruta para comentar juego

//ruta para obtener juego por nombre.
