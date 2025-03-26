<?php
namespace App\Repositories\Interfaces;

use App\DTO\PlantWithImageDto;
use Illuminate\Pagination\LengthAwarePaginator;

    interface PlantRepositoryInterface
    {
        public function all() : LengthAwarePaginator;
        public function find(string $slug) : ?PlantWithImageDto;
        public function create(PlantWithImageDto $data) : PlantWithImageDto;
        public function update(string $slug, PlantWithImageDto $data) : ?PlantWithImageDto;
        public function delete(string $slug) : bool;
    }