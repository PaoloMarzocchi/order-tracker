@extends('layouts.app')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-xl font-semibold mb-4">{{ __('Edit order ID: :id', ['id' => $order->id]) }}</h1>

    <div class="bg-white shadow-sm rounded-lg p-6">
        <form method="POST" action="{{ route('admin.orders.update', $order) }}">
            @csrf
            @method('PUT')

            @include('admin.orders.components._form')

            {{-- Actions --}}
            <div class="mt-4">
                @can('update', $order)
                    <x-primary-button>{{ __('Update') }}</x-primary-button>
                @endcan
                <a href="{{ route('admin.orders.index') }}" class="ml-3 text-sm text-gray-600">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
