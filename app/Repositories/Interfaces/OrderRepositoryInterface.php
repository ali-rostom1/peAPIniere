<?php 
namespace App\Repositories\Interfaces;

use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    public function all() : LengthAwarePaginator;
    public function find(string $slug);
    public function create(array $data);
    public function update(string $slug, array $data);
    public function delete(string $slug);

    public function getOrdersForUser(User $user): LengthAwarePaginator;

    public function cancelOrder(string $orderId): ?Order;
    public function markAsPreparing(string $orderId): ?Order;
    public function markAsDelivered(string $orderId): ?Order;


}
