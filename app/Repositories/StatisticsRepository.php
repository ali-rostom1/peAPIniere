<?php 

namespace App\Repositories;

use App\Repositories\Interfaces\StatisticsRepositoryInterface;
use Illuminate\Support\Facades\DB;

class StatisticsRepository implements StatisticsRepositoryInterface
{
    public function getDeliveredOrdersCount(){
        return DB::table('orders')->where('status',"Delivered")->count();
    }
    public function getPlantsCount(){
        return DB::table('plants')->count();
    }
    public function getTop3OrderedPlants(){
        return DB::table("plants")
                ->join("orders","plants.id","=","orders.plant_id")
                ->whereNot("orders.status","cancelled")
                ->select('plants.id','plants.name',DB::raw('COUNT(orders.id) as order_count'))
                ->groupBy("plants.id")
                ->orderBy("order_count","desc")
                ->limit(3)
                ->get();
    }
    public function getTop3PlantCategories(){
        return DB::table('plants')
                    ->select('plants.id','plants.name',DB::raw('COUNT(*) as total'))
                    ->groupBy("category")
                    ->orderBy('total','desc')
                    ->limit(3)
                    ->get();
    }
}