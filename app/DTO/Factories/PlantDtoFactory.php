<?php 
namespace App\DTO\Factories;

use App\DTO\PlantDto;
use App\Models\Plant;

class PlantDtoFactory{
    public static function fromArray(array $data) : PlantDto
    {
        return new PlantDto(
            name: $data['name'],
            price: $data['price'],
            category: $data['category'],
            description: $data['description'],
            admin_id: $data['admin_id'],
            slug: $data['slug'] ?? null,
        );
    }
    public static function fromModel(Plant $plant) : PlantDto
    {
        return new PlantDto(
            id: $plant->id,
            name: $plant->name,
            price: $plant->price,
            category: $plant->category,
            description: $plant->description,
            admin_id: $plant->admin_id,
            slug: $plant->slug,
        );
    }
}