{{-- Orders table --}}
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