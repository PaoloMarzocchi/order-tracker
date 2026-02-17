<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filterStatus = $request->get('status');
        $orders = Order::with([
            'customer' => function ($query) {
                $query->withTrashed();
            }
        ])->when($filterStatus, function ($query, $filterStatus) {
            if (!is_null($filterStatus)) return $query->where('status', $filterStatus);
        })->paginate(10);

        return response()->json($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->validated());
        return response()->json($order, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return response()->json($order->load('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        try {
            $order->update($request->validated());
            return response()->json($order);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update order: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        try {
            $order->update(['status' => OrderStatus::Cancelled->value]);
            return response()->json(['message' => 'Order cancelled successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to cancel order: ' . $e->getMessage()], 500);
        }
    }
}
