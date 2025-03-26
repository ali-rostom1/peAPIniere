<?php
namespace App\DTO;

class ImageDto
{
    public function __construct(
        public readonly string $path,
        public readonly int $plant_id,
        public readonly string $title,
        public readonly ?int $id = null,
    ) {}
}