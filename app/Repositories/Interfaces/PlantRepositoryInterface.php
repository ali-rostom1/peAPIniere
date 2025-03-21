<?php
    namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

    interface PlantRepositoryInterface
    {
        public function all() : LengthAwarePaginator;
        public function find(string $slug);
        public function create(array $data,array $uploadedImages);
        public function update(string $slug, array $data,array $uploadedImages);
        public function delete(string $slug);
    }