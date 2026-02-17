@extends('layouts.app')

@section('content')
<div class="p-6">
    {{-- Top section --}}
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">{{ __('Orders') }}</h1>
        <div class="flex items-center gap-8">
            <a href="{{ route('admin.orders.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md">{{ __('New order') }}</a>
            
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <div>{{ __('Filters') }}</div>
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                {{-- Filters for order status --}}
                <x-slot name="content">
                    <x-dropdown-link class='border-b-2' :href="route('admin.orders.index', ['status' => null])">
                        <strong>{{ __('All Orders') }}</strong>
                    </x-dropdown-link>
                    @foreach(\App\Enums\OrderStatus::cases() as $status)
                    <x-dropdown-link :href="route('admin.orders.index', ['status' => $status->value])">
                        {{ $status->label() }}
                    </x-dropdown-link>
                    @endforeach
                </x-slot>
            </x-dropdown>
        </div>
        </div>

    {{-- Customers table --}}
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            
            {{-- Table header --}}
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Order #') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Customer') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Total') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                </tr>
            </thead>

            {{-- Table body --}}
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($orders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->order_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap {{ !is_null($order->customer->deleted_at) ? 'text-red-500' : '' }}">{{ $order->customer->name ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($order->total_amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php $status = $order->status; @endphp
                            <span class="text-sm text-{{ $status->color() }}-500">{{ $status->label() }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->order_date->format('Y-m-d') ?? '-' }}</td>
                        
                        {{-- Actions --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:underline mr-3">{{ __('View') }}</a>
                            @can('update', $order)
                            <a href="{{ route('admin.orders.edit', $order) }}" class="text-green-600 hover:underline mr-3">{{ __('Edit') }}</a>
                            @endcan
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this order?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">{{ __('No orders found.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
