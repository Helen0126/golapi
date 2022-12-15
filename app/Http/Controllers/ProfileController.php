<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Resources\UserDetailResource;

class ProfileController extends ApiController
{
    /**
     * Sube imagen al servidor.
     * @return \Illuminate\Http\Response
     *
     *
     * @OA\Post(
     *     path="/user/upload-avatar",
     *     tags={"user"},
     *     summary="Actualiza el avatar del usuario",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Ok.",
     *         @OA\JsonContent()
     *     ),
     *     @OA\RequestBody(
     *         description="Datos en formato 'multipart/form-data'",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="avatar",
     *                     title="Avatar",
     *                     description="Imagen en formato .jpg,.jpeg,.png",
     *                     type="string",
     *                     format="binary"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image',
        ]);
        // !FIX: ¿Se podria hacer un TRANSACTION aqui?
        Auth::user()->detachMedia();
        Auth::user()->attachMedia($request->avatar, ['transformation' => [
            'width' => 350,
            'height' => 350,
            // 'radius' => 'max',
            'gravity' => 'face',
            'crop' => 'thumb',
        ]]);


        return $this->respondSuccess('Imagen subida correctamente');
    }

    /**
     * Datos del usuario autenticado.
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *     path="/user/profile",
     *     tags={"user"},
     *     security={{"sanctum":{}}},
     *     summary="Retorna todos los datos del usuario autenticado.",
     *     @OA\Response(
     *         response=200,
     *         description="Ok.",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function showProfile()
    {
        if (Auth::user()->hasRole('Administrador')) {
            return $this->respondWithResource(new UserDetailResource(Auth::user()->load(['person'])));
        } else {
            return $this->respondWithResource(new UserDetailResource(Auth::user()->load(['person.cycle.gol'])));
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        Auth::user()->update(['password' => $request->password]);

        return $this->respondSuccess('Password actualizado correctamente');
    }
}
