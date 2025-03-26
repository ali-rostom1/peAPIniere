<?php 
namespace App\DTO;

class PlantDto
{
    public function __construct(
        public readonly string $name,
        public readonly float $price,
        public readonly string $category,
        public readonly string $description,
        public readonly ?int $admin_id,
        public readonly ?string $slug = null,
        public readonly ?int $id = null,

    ) {}

}