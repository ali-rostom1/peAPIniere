<?php 
namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    public function all() : LengthAwarePaginator;
    public function find(string $slug);
    public function create(array $data);
    public function update(string $slug, array $data);
    public function delete(string $slug);
}
