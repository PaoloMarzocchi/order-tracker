@extends('layouts.app')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-xl font-semibold mb-4">{{ __('Edit customer ID: :id', ['id' => $customer->id]) }}</h1>

    <div class="bg-white shadow-sm rounded-lg p-6">
        <form method="POST" action="{{ route('admin.customers.update', $customer) }}">
            @csrf
            @method('PUT')

            @include('admin.customer.components._form')

            {{-- Actions --}}
            <div class="mt-4">
                <x-primary-button>{{ __('Update') }}</x-primary-button>
                <a href="{{ route('admin.customers.index') }}" class="ml-3 text-sm text-gray-600">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
