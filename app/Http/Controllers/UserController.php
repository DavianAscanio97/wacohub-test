<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;

class UserController extends Controller
{
    /**
     * Muestra una lista de usuarios utilizando DataTables.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $users = User::select(['id', 'name', 'email']); // Seleccionar solo las columnas necesarias
                return DataTables::of($users)->toJson(); // Devolver datos en formato JSON para DataTables
            }

            return view('components.users.user'); // Mostrar la vista para la tabla de usuarios
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener la lista de usuarios'], 500);
        }
    }

    /**
     * Muestra la información de un usuario específico.
     *
     * @param  int  $userID
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($userID)
    {
        try {
            $user = User::findOrFail($userID); // Encontrar un usuario por su ID
            return response()->json(['user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
    }

    /**
     * Actualiza la información de un usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $userID
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $userID)
    {
        try {
            $user = User::findOrFail($userID); // Encontrar el usuario por su ID

            // Validaciones de campos
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email',
                // Agrega aquí más reglas de validación según tus necesidades
            ]);

            // Actualizar los datos del usuario con los datos proporcionados en la solicitud
            $user->update($request->all());

            // Devolver una respuesta JSON con un mensaje de éxito
            return response()->json(['message' => 'Usuario actualizado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar el usuario'], 500);
        }
    }

    /**
     * Elimina un usuario.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        try {
            $user->delete(); // Eliminar el usuario
            return response()->json(['message' => 'Usuario eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el usuario'], 500);
        }
    }
}
