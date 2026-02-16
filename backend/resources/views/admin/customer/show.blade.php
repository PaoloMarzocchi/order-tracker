@extends('layouts.app')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-xl font-semibold mb-4">{{ __('Customer ID: :id', ['id' => $customer->id]) }}</h1>

    {{-- Customer Details --}}
    <div class="bg-white shadow-sm rounded-lg p-6 space-y-4">
        <div>
            <h2 class="text-sm text-gray-500">{{ __('Name') }}</h2>
            <p class="text-lg">{{ $customer->name }}</p>
        </div>

        <div>
            <h2 class="text-sm text-gray-500">{{ __('Email') }}</h2>
            <p class="text-lg">{{ $customer->email }}</p>
        </div>

        <div>
            <h2 class="text-sm text-gray-500">{{ __('Address') }}</h2>
            <p class="text-lg">{{ $customer->address ?? '-' }}</p>
        </div>

        <div>
            <h2 class="text-sm text-gray-500">{{ __('Phone') }}</h2>
            <p class="text-lg">{{ $customer->phone ?? '-' }}</p>
        </div>

        {{-- Actions --}}
        <div class="pt-4">
            <a href="{{ route('admin.customers.edit', $customer) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md">{{ __('Edit') }}</a>
            <a href="{{ route('admin.customers.index') }}" class="ml-3 text-sm text-gray-600">{{ __('Back') }}</a>
        </div>
    </div>
</div>
@endsection
