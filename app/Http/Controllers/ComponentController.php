<?php

namespace App\Http\Controllers;

use App\Models\Component;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Inventory Service API",
    version: "1.0.0",
    description: "API Documentation for Inventory Service"
)]
#[OA\SecurityScheme(
    securityScheme: "ApiKeyAuth",
    type: "apiKey",
    in: "header",
    name: "X-IAE-KEY"
)]
class ComponentController extends Controller
{
    #[OA\Get(
        path: "/api/v1/components",
        summary: "Get all components",
        tags: ["Components"],
        security: [["ApiKeyAuth" => []]]
    )]
    #[OA\Response(
        response: 200,
        description: "Success",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "status", type: "string", example: "success"),
                new OA\Property(property: "message", type: "string", example: "Data retrieved successfully"),
                new OA\Property(
                    property: "data",
                    type: "array",
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: "id", type: "integer", example: 1),
                            new OA\Property(property: "name", type: "string", example: "Processor Intel Core i7"),
                            new OA\Property(property: "part_number", type: "string", example: "CPU-I7-12700"),
                            new OA\Property(property: "stock", type: "integer", example: 15),
                            new OA\Property(property: "minimum_stock", type: "integer", example: 5),
                            new OA\Property(property: "unit", type: "string", example: "pcs"),
                            new OA\Property(property: "created_at", type: "string", format: "date-time"),
                            new OA\Property(property: "updated_at", type: "string", format: "date-time")
                        ]
                    )
                ),
                new OA\Property(
                    property: "meta",
                    type: "object",
                    properties: [
                        new OA\Property(property: "service_name", type: "string", example: "Inventory-Service"),
                        new OA\Property(property: "api_version", type: "string", example: "v1")
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 401,
        description: "Unauthorized - API Key is missing or invalid",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "status", type: "string", example: "error"),
                new OA\Property(property: "message", type: "string", example: "Unauthorized access, invalid or missing X-IAE-KEY"),
                new OA\Property(property: "errors", type: "string", nullable: true, example: null)
            ]
        )
    )]
    public function index()
    {
        $components = Component::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'data' => $components,
            'meta' => [
                'service_name' => 'Inventory-Service',
                'api_version' => 'v1'
            ]
        ], 200);
    }

    #[OA\Get(
        path: "/api/v1/components/{id}",
        summary: "Get component by ID",
        tags: ["Components"],
        security: [["ApiKeyAuth" => []]]
    )]
    #[OA\Parameter(
        name: "id",
        description: "Component ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Response(
        response: 200,
        description: "Success",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "status", type: "string", example: "success"),
                new OA\Property(property: "message", type: "string", example: "Data retrieved successfully"),
                new OA\Property(
                    property: "data",
                    type: "object",
                    properties: [
                        new OA\Property(property: "id", type: "integer", example: 1),
                        new OA\Property(property: "name", type: "string", example: "Processor Intel Core i7"),
                        new OA\Property(property: "part_number", type: "string", example: "CPU-I7-12700"),
                        new OA\Property(property: "stock", type: "integer", example: 15),
                        new OA\Property(property: "minimum_stock", type: "integer", example: 5),
                        new OA\Property(property: "unit", type: "string", example: "pcs"),
                        new OA\Property(property: "created_at", type: "string", format: "date-time"),
                        new OA\Property(property: "updated_at", type: "string", format: "date-time")
                    ]
                ),
                new OA\Property(
                    property: "meta",
                    type: "object",
                    properties: [
                        new OA\Property(property: "service_name", type: "string", example: "Inventory-Service"),
                        new OA\Property(property: "api_version", type: "string", example: "v1")
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 401,
        description: "Unauthorized - API Key is missing or invalid",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "status", type: "string", example: "error"),
                new OA\Property(property: "message", type: "string", example: "Unauthorized access, invalid or missing X-IAE-KEY"),
                new OA\Property(property: "errors", type: "string", nullable: true, example: null)
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: "Component not found",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "status", type: "string", example: "error"),
                new OA\Property(property: "message", type: "string", example: "Component not found"),
                new OA\Property(property: "errors", type: "string", nullable: true, example: null)
            ]
        )
    )]
    public function show($id)
    {
        $component = Component::find($id);

        if (!$component) {
            return response()->json([
                'status' => 'error',
                'message' => 'Component not found',
                'errors' => null
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'data' => $component,
            'meta' => [
                'service_name' => 'Inventory-Service',
                'api_version' => 'v1'
            ]
        ], 200);
    }

    #[OA\Post(
        path: "/api/v1/components/receive",
        summary: "Receive component stock",
        tags: ["Components"],
        security: [["ApiKeyAuth" => []]]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["part_number", "quantity"],
            properties: [
                new OA\Property(
                    property: "part_number",
                    type: "string",
                    example: "CPU-I7-12700"
                ),
                new OA\Property(
                    property: "quantity",
                    type: "integer",
                    example: 10
                )
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: "Stock updated successfully",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "status", type: "string", example: "success"),
                new OA\Property(property: "message", type: "string", example: "Stock updated successfully"),
                new OA\Property(
                    property: "data",
                    type: "object",
                    properties: [
                        new OA\Property(property: "id", type: "integer", example: 1),
                        new OA\Property(property: "name", type: "string", example: "Processor Intel Core i7"),
                        new OA\Property(property: "part_number", type: "string", example: "CPU-I7-12700"),
                        new OA\Property(property: "stock", type: "integer", example: 25),
                        new OA\Property(property: "minimum_stock", type: "integer", example: 5),
                        new OA\Property(property: "unit", type: "string", example: "pcs"),
                        new OA\Property(property: "created_at", type: "string", format: "date-time"),
                        new OA\Property(property: "updated_at", type: "string", format: "date-time")
                    ]
                ),
                new OA\Property(
                    property: "meta",
                    type: "object",
                    properties: [
                        new OA\Property(property: "service_name", type: "string", example: "Inventory-Service"),
                        new OA\Property(property: "api_version", type: "string", example: "v1")
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 401,
        description: "Unauthorized - API Key is missing or invalid",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "status", type: "string", example: "error"),
                new OA\Property(property: "message", type: "string", example: "Unauthorized access, invalid or missing X-IAE-KEY"),
                new OA\Property(property: "errors", type: "string", nullable: true, example: null)
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: "Component not found",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "status", type: "string", example: "error"),
                new OA\Property(property: "message", type: "string", example: "Component with that part_number not found"),
                new OA\Property(property: "errors", type: "string", nullable: true, example: null)
            ]
        )
    )]
    #[OA\Response(
        response: 422,
        description: "Validation Error",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "status", type: "string", example: "error"),
                new OA\Property(property: "message", type: "string", example: "The given data was invalid."),
                new OA\Property(
                    property: "errors",
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "part_number",
                            type: "array",
                            items: new OA\Items(type: "string", example: "The part number field is required.")
                        )
                    ]
                )
            ]
        )
    )]
    public function receive(Request $request)
    {
        $validated = $request->validate([
            'part_number' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $component = Component::where('part_number', $validated['part_number'])->first();

        if (!$component) {
            return response()->json([
                'status' => 'error',
                'message' => 'Component with that part_number not found',
                'errors' => null
            ], 404);
        }

        $component->stock += $validated['quantity'];
        $component->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Stock updated successfully',
            'data' => $component,
            'meta' => [
                'service_name' => 'Inventory-Service',
                'api_version' => 'v1'
            ]
        ], 201);
    }
}