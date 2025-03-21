<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlantStoreRequest;
use App\Http\Requests\PlantUpdateRequest;
use App\Models\Plant;
use App\Repositories\Interfaces\PlantRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PlantController extends Controller
{
    protected $plantRepository;
    public function __construct(PlantRepositoryInterface $plantRepository)
    {
        $this->plantRepository = $plantRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if($user->cannot(['view plants','manage plants'])){
            return response()->json([
                'status' => false,
                'message' => 'You dont have permissions to view all plants',
            ],403);
        }
        try {
            $plants = $this->plantRepository->all();

            return response()->json([
                'status' => true,
                'message' => 'Plants retrieved successfully',
                'data' => $plants,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve plants',
                'error' => $e->getMessage(),
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
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if($user->cannot('manage plants')){
            return response()->json([
                'status' => false,
                'message' => 'You dont have permissions to save plant',
            ],403);
        }
        try {
            $data = $request->validated();

            $uploadedImages = $request->hasFile('images') ? $request->file('images') : [];

            $plant = $this->plantRepository->create($data, $uploadedImages);

            return response()->json([
                'status' => true,
                'message' => 'Plant created successfully',
                'data' => $plant,
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create plant',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function show(string $slug): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if($user->cannot('view plants')){
            return response()->json([
                'status' => false,
                'message' => 'You dont have permissions to view plants ',
            ],403);
        }
        try {
            $plant = $this->plantRepository->find($slug);

            if (!$plant) {
                return response()->json([
                    'status' => false,
                    'message' => 'Plant not found',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'status' => true,
                'message' => 'Plant retrieved successfully',
                'data' => $plant,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve plant',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PlantUpdateRequest $request
     * @param string $slug
     * @return JsonResponse
     */
    public function update(PlantUpdateRequest $request, string $slug): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if($user->cannot('manage plants')){
            return response()->json([
                'status' => false,
                'message' => 'You dont have permissions to update plants',
            ],403);
        }
        try {
            $data = $request->validated();

            $uploadedImages = $request->hasFile('images') ? $request->file('images') : [];

            $plant = $this->plantRepository->update($slug, $data, $uploadedImages);

            if (!$plant) {
                return response()->json([
                    'status' => false,
                    'message' => 'Plant not found',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'status' => true,
                'message' => 'Plant updated successfully',
                'data' => $plant,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update plant',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function destroy(string $slug): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if($user->cannot('manage plants')){
            return response()->json([
                'status' => false,
                'message' => 'You dont have permissions to delete plants',
            ],403);
        }
        try {
            $deleted = $this->plantRepository->delete($slug);

            if (!$deleted) {
                return response()->json([
                    'status' => false,
                    'message' => 'Plant not found',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'status' => true,
                'message' => 'Plant deleted successfully',
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete plant',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}