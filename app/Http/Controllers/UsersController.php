<?php
namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Requests\Usuarios\UpdateUserRequest;
use App\Models\User;


class UsersController extends Controller{

     public function index()
    {
        $user = User::all();
        return response()->json($user, 200);
    }

    //el store esta en auth

    public function show($nombre){ //busca uno

        $user = User::where('nombre', $nombre)->first();

        if(!$user){
            return response()->json(['message'=>'Usuario no encontrado'],404);
        }

        return response()->json($user,200);
    }

    public function update(UpdateUserRequest $request, $id) {
        $user = User::find($id);

        if(!$user){
            return response()->json(['message' => 'Usuario no encontrado'],404);
        }

        $user->update($request->validated());

        return response()->json($user,200);
    }

    public function updateState($id) 
    {
        $user = User::find($id);

        if(!$user){
            return response()->json(['message' => 'Usuario no encontrado'],404);
        }

        $user->update(['estado' => !$user->estado]);

        return response()->json(['message' => 'Estado cambiado exitosamente'],200);

    }



}