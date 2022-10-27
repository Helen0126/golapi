<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        return $this->respondToken($user->createToken($request->device_name ?? $request->name)->plainTextToken);
    }
}
