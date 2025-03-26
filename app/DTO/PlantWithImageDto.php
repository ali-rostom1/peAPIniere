<?php 
namespace App\DTO;

class PlantWithImageDto extends PlantDto
{
    public function __construct(
        string $name,
        float $price,
        string $category,
        string $description,
        public readonly array $images,
        ?int $admin_id = null,
        ?string $slug = null,
        ?int $id = null,
    ){
        parent::__construct(
            name: $name,
            price: $price,
            category: $category,
            description: $description,
            admin_id: $admin_id,
            slug: $slug,
            id: $id
        );
    }

}