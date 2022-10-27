<?php

namespace App\Http\Controllers;

use App\Utils\ApiResponseTrait;

/**
 * @OA\Info(
 *     description="Documentacion del api de GolApp",
 *     version="1.0.0",
 *     title="GolApp",
 *     @OA\Contact(
 *         email="testing@upeu.edu.pe"
 *     )
 * )
 * @OA\PathItem(path="/api")
 * @OA\Tag(
 *     name="auth",
 *     description="Modulo de autenticación",
 * )
  * @OA\Tag(
 *     name="user",
 *     description="Modulo de gestion de Usuarios",
 * )
 * @OA\Tag(
 *     name="person",
 *     description="Gestion de estudiantes, tutores...",
 * )
 * )
 * @OA\Server(
 *     description="GolApp API endpoints",
 *     url=L5_SWAGGER_CONST_HOST
 * )
 *  @OAS\SecurityScheme(
 *      securityScheme="sanctum",
 *      type="http",
 *      scheme="bearer"
 * )
 */
class ApiController extends Controller
{
    use ApiResponseTrait;
}
