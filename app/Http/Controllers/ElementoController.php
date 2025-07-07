<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreElementoRequest;
use App\Models\Elemento;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ElementoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $elemento = Elemento::all();

        $message = $elemento->isEmpty()
        ? "No hay elementos registrados" 
        : "Lista de elementos";

        return response()->json([
            'message'       =>     $message ,
            'data'          =>      $elemento,
        ],Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( StoreElementoRequest $request)
    {
        $data = $request -> validated();

        $elemento = Elemento::create($data);

        return response()->json([
            'message'  => 'Elemento creado correctamente',
            'data'     => $elemento
        ], Response::HTTP_CREATED)->header('Location', route('elementos.show', $elemento));
    }

    /**
     * Display the specified resource.
     */
    public function show(Elemento $elemento)
    {
        return response()->json([
            'message'  => 'Elementos obtenidos con exito',
            'data'     => $elemento 
        ], Response::HTTP_OK);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Elemento $elemento)
    {
        $elemento->update($request->validated());

        return response()->json([
            'message' => 'Elemento actualizado con exito',
            'data'    => $elemento
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Elemento $elemento)
    {
        $elemento->delete();

        #Devolviendo u mensaje vacio

        #return response()->noContent()

        return response()->json([
            'message'  => 'Elemento eliminado con exito'
        ], Response::HTTP_OK);
    }
}
