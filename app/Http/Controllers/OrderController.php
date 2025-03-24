<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStatusRequest;
use App\Http\Requests\OrderStoreRequest;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if(!$user->can('view all orders')){
            return response()->json([
                'status' => false,
                'message' => 'You dont have permissions to view all orders',
            ],403);
        }
        try {
            $orders = $this->orderRepository->all();

            return response()->json([
                'status' => true,
                'message' => 'Orders retrieved successfully',
                'data' => $orders,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve orders',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PlantStoreRequest $request
     * @return JsonResponse
     */
    public function store(OrderStoreRequest $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if($user->cannot('order plant')){
            return response()->json([
                'status' => false,
                'message' => 'You dont have permissions to order a plant',
            ],403);
        }
        try {
            $data = $request->validated();

            $order = $this->orderRepository->create($data);

            return response()->json([
                'status' => true,
                'message' => 'Order placed successfully',
                'data' => $order,
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to place order',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function show(string $slug): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if(!$user->canAny(['view all orders','view own orders'])){
            return response()->json([
                'status' => false,
                'message' => 'You dont have permissions to view orders ',
            ],403);
        }
        try {
            $order = $this->orderRepository->find($slug);

            if (!$order) {
                return response()->json([
                    'status' => false,
                    'message' => 'order not found',
                ], Response::HTTP_NOT_FOUND);
            }
            if($user->can("view own orders") && $order->user->id != Auth::id()){
                return response()->json([
                    'status' => false,
                    'message' => 'You dont have permissions to view orders other than your own ',
                ],403);
            }

            return response()->json([
                'status' => true,
                'message' => 'Plant retrieved successfully',
                'data' => $order,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve plant',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PlantUpdateRequest $request
     * @param string $slug
     * @return JsonResponse
     */
    public function update(Request $request, string $slug): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if($user->cannot('modify order status')){
            return response()->json([
                'status' => false,
                'message' => 'You dont have permissions to update orders',
            ],403);
        }
        try {
            $data = $request->all();
            
            $order = $this->orderRepository->update($slug, $data);

            if (!$order) {
                return response()->json([
                    'status' => false,
                    'message' => 'Order not found',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'status' => true,
                'message' => 'Order updated successfully',
                'data' => $order,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update order',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function destroy(string $slug): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if(!$user->hasRole('admin')){
            return response()->json([
                'status' => false,
                'message' => 'You dont have permissions to delete orders',
            ],403);
        }
        try {
            $deleted = $this->orderRepository->delete($slug);

            if (!$deleted) {
                return response()->json([
                    'status' => false,
                    'message' => 'Order not found',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'status' => true,
                'message' => 'Order deleted successfully',
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete order',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function getMyorders()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if(!$user->can('view own orders')){
            return response()->json([
                'status' => false,
                'message' => 'You dont have permissions to view own orders',
            ],403);
        }
        try {
            $orders = $this->orderRepository->getOrdersForUser($user);

            return response()->json([
                'status' => true,
                'message' => 'Orders retrieved successfully',
                'data' => $orders,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve orders',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } 
    }
    public function cancelMyOrder(OrderStatusRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if(!$user->can('cancel own command')){
            return response()->json([
                'status' => false,
                'message' => 'You dont have permissions to cancel own orders',
            ],403);
        }

        try {
            $order = $this->orderRepository->cancelOrder($request->input('id'));

            return response()->json([
                'status' => true,
                'message' => 'Canceled order successfully',
                'data' => $order,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to cancel order',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } 
    }
    public function cancelAllOrders(OrderStatusRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if(!$user->can('cancel all commands')){
            return response()->json([
                'status' => false,
                'message' => 'You dont have permissions to cancel all orders',
            ],403);
        }

        try {
            $order = $this->orderRepository->cancelOrder($request->input('id'));

            return response()->json([
                'status' => true,
                'message' => 'Canceled order successfully',
                'data' => $order,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to cancel order',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } 
    }
    public function markAsPrepared(OrderStatusRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if(!$user->can('modify order status')){
            return response()->json([
                'status' => false,
                'message' => 'You dont have permissions to modify orders',
            ],403);
        }

        try {
            $order = $this->orderRepository->markAsPreparing($request->input('id'));

            return response()->json([
                'status' => true,
                'message' => 'Marked order as preparing successfully',
                'data' => $order,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to mark order as preparing',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } 
    }
    public function markAsDelivered(OrderStatusRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if(!$user->can('modify order status')){
            return response()->json([
                'status' => false,
                'message' => 'You dont have permissions to modify orders',
            ],403);
        }

        try {
            $order = $this->orderRepository->markAsDelivered($request->input('id'));

            return response()->json([
                'status' => true,
                'message' => 'Marked order as delivered successfully',
                'data' => $order,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to mark order as delivered',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } 
    }

}
