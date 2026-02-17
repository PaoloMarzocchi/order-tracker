@extends('layouts.app')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-xl font-semibold mb-4">{{ __('Create order') }}</h1>

    <div class="bg-white shadow-sm rounded-lg p-6">
        <form method="POST" action="{{ route('admin.orders.store') }}">
            @csrf

            @include('admin.orders.components._form')

            {{-- Actions --}}
            <div class="mt-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <a href="{{ route('admin.orders.index') }}" class="ml-3 text-sm text-gray-600">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
