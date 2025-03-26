<?php
namespace App\DTO\Factories;

use App\DTO\ImageDto;
use App\Models\Image;

class ImageDtoFactory
{
    public static function fromArray(array $data): ImageDto
    {
        return new ImageDto(
            path: $data['path'],
            plant_id: $data['plant_id'],
            title: $data['title'],
            id: $data['id'] ?? null,            
        );
    }

    public static function fromModel(Image $image): ImageDto
    {
        return new ImageDto(
            path: $image->path,
            plant_id: $image->plant_id,
            title: $image->title,
            id: $image->id, 
        );
    }
}