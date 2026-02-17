@extends('layouts.app')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-xl font-semibold mb-4">{{ __('Order ID: :id', ['id' => $order->id]) }}</h1>

    {{-- Orders details --}}
    <div class="bg-white shadow-sm rounded-lg p-6 space-y-4">
        <div>
            <h2 class="text-sm text-gray-500">{{ __('Order #') }}</h2>
            <p class="text-lg">{{ $order->order_number }}</p>
        </div>

        <div>
            <h2 class="text-sm text-gray-500">{{ __('Customer') }}</h2>
            <p class="text-lg">{{ $order->customer->name ?? '-' }}</p>
        </div>

        <div>
            <h2 class="text-sm text-gray-500">{{ __('Total Amount') }}</h2>
            <p class="text-lg">{{ number_format($order->total_amount, 2) }}</p>
        </div>

        <div>
            <h2 class="text-sm text-gray-500">{{ __('Status') }}</h2>
            @php $status = $order->status; @endphp
            <p class="text-lg">{{ $status->label() }}</p>
        </div>

        <div>
            <h2 class="text-sm text-gray-500">{{ __('Order Date') }}</h2>
            <p class="text-lg">{{ $order->order_date->format('Y-m-d') ?? '-' }}</p>
        </div>

        {{-- Actions --}}
        <div class="pt-4">
            @can('update', $order)
                <a href="{{ route('admin.orders.edit', $order) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md">{{ __('Edit') }}</a>
            @endcan
            <a href="{{ route('admin.orders.index') }}" class="ml-3 text-sm text-gray-600">{{ __('Back') }}</a>
        </div>
    </div>
</div>
@endsection
