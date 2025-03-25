<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\StatisticsRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    protected $statisticsRepository;
    public function __construct(StatisticsRepositoryInterface $statisticsRepository)
    {
        $this->statisticsRepository = $statisticsRepository;
    }
    public function getDeliveredOrdersCount()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if($user->cannot('view statistics')){
            return response()->json([
                'status' => false,
                'message' => 'You dont have permissions to view statistics',
            ],403);
        }
        try {
            $stat = $this->statisticsRepository->getDeliveredOrdersCount();

            return response()->json([
                'status' => true,
                'message' => 'Orders delivered count retrieved successfully',
                'data' => $stat,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve statistic',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function getPlantsCount()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if($user->cannot('view statistics')){
            return response()->json([
                'status' => false,
                'message' => 'You dont have permissions to view statistics',
            ],403);
        }
        try {
            $stat = $this->statisticsRepository->getPlantsCount();

            return response()->json([
                'status' => true,
                'message' => 'Plants count retrieved successfully',
                'data' => $stat,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve statistic',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function getTop3OrderedPlants()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        

        if($user->cannot('view statistics')){
            return response()->json([
                'status' => false,
                'message' => 'You dont have permissions to view statistics',
            ],403);
        }
        try {
            $stat = $this->statisticsRepository->getTop3OrderedPlants();

            return response()->json([
                'status' => true,
                'message' => 'TOP 3 ordered plants retrieved successfully',
                'data' => $stat,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve statistic',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function getTop3PlantCategories()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        

        if($user->cannot('view statistics')){
            return response()->json([
                'status' => false,
                'message' => 'You dont have permissions to view statistics',
            ],403);
        }
        try {
            $stat = $this->statisticsRepository->getTop3PlantCategories();

            return response()->json([
                'status' => true,
                'message' => 'TOP 3 plant categories retrieved successfully',
                'data' => $stat,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve statistic',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}   
