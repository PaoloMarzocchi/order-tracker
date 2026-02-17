<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Customer;
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
        return view('admin.orders.index', compact('orders', 'filterStatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all()->pluck('name', 'id')->toArray();
        return view('admin.orders.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->validated());
        return redirect()->route('admin.orders.show', $order)->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $customers = Customer::all()->pluck('name', 'id')->toArray();
        return view('admin.orders.edit', compact('order', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        try {
            $order->update($request->validated());
            return redirect()->route('admin.orders.show', $order)->with('success', 'Order updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        try {
            $order->update(['status' => OrderStatus::Cancelled->value]);
            return redirect()->route('admin.orders.index')->with('success', 'Order cancelled successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Failed to cancel order: ' . $e->getMessage()]);
        }
    }
}
