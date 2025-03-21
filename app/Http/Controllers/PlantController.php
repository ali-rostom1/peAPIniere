<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlantStoreRequest;
use App\Http\Requests\PlantUpdateRequest;
use App\Models\Plant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $plants = Plant::paginate(10);

            return response()->json([
                'status' => true,
                'message' => 'Plants retrieved successfully',
                'data' => $plants,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve plants',
                'error' => 'An internal server error occurred.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PlantStoreRequest $request
     * @return JsonResponse
     */
    public function store(PlantStoreRequest $request): JsonResponse
    {
        try {
            $plant = Plant::create($request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Plant created successfully',
                'data' => $plant,
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create plant',
                'error' => 'An internal server error occurred.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Plant $plant
     * @return JsonResponse
     */
    public function show(Plant $plant): JsonResponse
    {
        try {
            return response()->json([
                'status' => true,
                'message' => 'Plant retrieved successfully',
                'data' => $plant,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve plant',
                'error' => 'An internal server error occurred.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PlantUpdateRequest $request
     * @param Plant $plant
     * @return JsonResponse
     */
    public function update(PlantUpdateRequest $request, Plant $plant): JsonResponse
    {
        try {
            $plant->update($request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Plant updated successfully',
                'data' => $plant,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Failed to update plant',
                'error' => 'An internal server error occurred.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Plant $plant
     * @return JsonResponse
     */
    public function destroy(Plant $plant): JsonResponse
    {
        try {
            $plant->delete();

            return response()->json([
                'status' => true,
                'message' => 'Plant deleted successfully',
            ], Response::HTTP_OK);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Failed to delete plant',
                'error' => 'An internal server error occurred.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}