<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="My API",
 *     version="1.0.0",
 *     description="This is the Swagger UI for my API"
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Local API Server"
 * )
 */
class SwaggerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/sample",
     *     operationId="getSampleData",
     *     tags={"Sample"},
     *     summary="Get sample data",
     *     description="Returns a simple JSON response",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Hello from Swagger!")
     *         )
     *     )
     * )
     */
    public function sample()
    {
        return response()->json([
            'message' => 'Hello from Swagger!',
        ]); 
    }
}
