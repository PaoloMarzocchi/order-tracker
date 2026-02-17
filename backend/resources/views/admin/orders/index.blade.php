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

    @include('admin.orders.components._orders_table', ['orders' => $orders])
</div>
@endsection
