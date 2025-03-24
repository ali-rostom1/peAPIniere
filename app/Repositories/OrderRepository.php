<?php
namespace App\Repositories;

use App\Models\Order;
use App\Models\User;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class OrderRepository implements OrderRepositoryInterface
{
    public function all() : LengthAwarePaginator
    {
        return Order::with('user','plant')->paginate(10);
    }
    public function find(string $slug)
    {
        return Order::with('user','plant')->where('slug',$slug)->first();
    }
    public function create(array $data)
    {
        try{
            $order = Order::create([
                'client_id' => Auth::id(),
                'plant_id' => $data['plant_id'], 
            ]);
            return $order;
        }catch(\Exception $e){
            
            throw $e;
        }

    }
    public function update(string $slug, array $data)
    {
        $order = Order::where('slug',$slug)->first();
        
        if(!$order){
            return null;
        }
        try{
            $order->update([
                "status" => $data['status'],
            ]);
            return $order;
        }catch(\Exception $e){
            throw $e;
        }

    }
    public function delete(string $slug)
    {
        $order = Order::where('slug',$slug)->first();
        if($order){
            $order->delete();
            return true;
        }else{
            return false;
        }
    }
    public function getOrdersForUser(User $user) : LengthAwarePaginator
    {
        return Order::with('user','plant')->where('client_id',$user->id)->paginate(10);
    }
    public function cancelOrder(string $orderId): ?Order
    {
        $order = Order::find($orderId);

        if(!$order){
            return null;
        }
        try{
            $order->update([
                'status' => "cancelled",
            ]);
            return $order;
        }catch(\Exception $e){
            throw $e;
        }
    }
    public function markAsPreparing(string $orderId): ?Order
    {
        $order = Order::find($orderId);

        if(!$order){
            return null;
        }
        try{
            $order->update([
                'status' => "Preparing",
            ]);
            return $order;
        }catch(\Exception $e){
            throw $e;
        }
    }
    public function markAsDelivered(string $orderId): ?Order
    {
        $order = Order::find($orderId);

        if(!$order){
            return null;
        }
        try{
            $order->update([
                'status' => "Delivered",
            ]);
            return $order;
        }catch(\Exception $e){
            throw $e;
        }
    }



}