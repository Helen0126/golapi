<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends ApiController
{

    /**
     * Accede al sistema.
     * @return \Illuminate\Http\Response
     *
     * @OA\Post(
     *     path="/auth/login",
     *     tags={"auth"},
     *     summary="Genera un token al ingresar al sistema.",
     *     @OA\Response(
     *         response=201,
     *         description="Ok.",
     *         @OA\JsonContent()
     *     ),
     *     @OA\RequestBody(
     *         description="Credenciales para iniciar sesión",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|exists:users,name',
            'password' => 'required',
            'device_name' => 'nullable',
        ]);

        $user = User::where('name', $request->name)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['El password es incorrecto.'],
            ]);
        }

        if (!$user->hasRole([Role::ADMINISTRADOR, Role::CAPELLAN])) {
            if ($user->person->cycle->gol == null) {
                return $this->respondForbidden("El ciclo al que pertenece este usuario no tiene asignado un GOL. Por favor pida al Administrador asignarlo.");
            }
        }

        return $this->respondToken($user->createToken($request->device_name ?? $request->name)->plainTextToken);
    }

    /**
     * Cerrar sesión del sistema.
     * @return \Illuminate\Http\Response
     *
     * @OA\Post(
     *     path="/auth/logout",
     *     tags={"auth"},
     *     security={{"sanctum":{}}},
     *     summary="Destruye el token de la sesion.",
     *     @OA\Response(
     *         response=201,
     *         description="Ok.",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return $this->respondSuccess("Sesion cerrada correctamente.");
    }
}
