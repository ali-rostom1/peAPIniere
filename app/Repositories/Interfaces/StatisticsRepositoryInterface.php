<?php 
namespace App\Repositories\Interfaces;

interface StatisticsRepositoryInterface
{
    public function getDeliveredOrdersCount();
    public function getPlantsCount();
    public function getTop3OrderedPlants();
    public function getTop3PlantCategories();
}