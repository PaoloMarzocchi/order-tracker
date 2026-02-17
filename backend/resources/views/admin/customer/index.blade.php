@extends('layouts.app')

@section('content')
<div class="p-6">
    {{-- Top section --}}
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">{{ __('Customers') }}</h1>
        <a href="{{ route('admin.customers.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md">{{ __('New customer') }}</a>
    </div>

    {{-- Customers table --}}
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">

            {{-- Table header --}}
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
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

                            {{-- Filters for soft deleted customers --}}
                            <x-slot name="content">
                                <x-dropdown-link :href="route('admin.customers.index', ['show_deleted' => true])">
                                    {{ __('Show Deleted') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.customers.index', ['show_deleted' => false])">
                                    {{ __('Hide Deleted') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </th>
                </tr>
            </thead>

            {{-- Table body --}}
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($customers as $customer)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $customer->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $customer->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $customer->phone ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('admin.customers.show', $customer) }}" class="text-indigo-600 hover:underline mr-3">{{ __('View') }}</a>
                        <a href="{{ route('admin.customers.edit', $customer) }}" class="text-green-600 hover:underline mr-3">{{ __('Edit') }}</a>
                        <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this customer?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">{{ __('Delete') }}</button>
                        </form>
                    </td>

                    {{-- Customer status --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($customer->trashed())
                            <span class="text-sm text-red-500">{{ __('Deleted') }}</span>
                        @else
                            <span class="text-sm text-green-500">{{ __('Active') }}</span>
                        @endif
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">{{ __('No customers found.') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
