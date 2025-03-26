<?php 
namespace App\DTO\Factories;


use App\DTO\PlantWithImageDto;
use App\Models\Plant;

class PlantWithImageDtoFactory{
    public static function fromModel(Plant $plant) : PlantWithImageDto
    {
        $images = $plant->images->map(
            fn ($image) => ImageDtoFactory::fromModel($image)
        )->toArray();
        return new PlantWithImageDto(
            id: $plant->id,
            name: $plant->name,
            price: $plant->price,
            category: $plant->category,
            description: $plant->description,
            admin_id: $plant->admin_id,
            images: $images,
            slug: $plant->slug,
        );
    }
    public static function fromArray(array $data) : PlantWithImageDto
    {
        $images = $data['images'] ?? [];

        return new PlantWithImageDto(
            id: $data['id'] ?? null,
            name: $data['name'],
            price: $data['price'],
            category: $data['category'],
            description: $data['description'],
            admin_id: $data['admin_id'] ?? null,
            images: $images,
            slug: $data['slug'] ?? null,
        );
    }
}