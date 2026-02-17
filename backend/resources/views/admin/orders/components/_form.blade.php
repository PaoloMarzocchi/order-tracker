{{-- Form component to create and edit orders --}}
<div class="space-y-4">
    <div>
        <x-input-label for="customer_id" :value="__('Customer')" />
        <select id="customer_id" name="customer_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <option value="">{{ __('Select customer') }}</option>
            @foreach($customers as $id => $customer_name)
                <option value="{{ $id }}" {{ old('customer_id', $order->customer_id ?? '') == $id ? 'selected' : '' }}>{{ $customer_name }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('customer_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="order_number" :value="__('Order number')" />
        <x-text-input id="order_number" name="order_number" type="text" class="mt-1 block w-full" value="{{ old('order_number', $order->order_number ?? '') }}" />
        <x-input-error :messages="$errors->get('order_number')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="order_date" :value="__('Order Date')" />
        <x-text-input id="order_date" name="order_date" type="date" class="mt-1 block w-full" value="{{ old('order_date', isset($order->order_date) ? $order->order_date->format('Y-m-d') : '') }}" />
        <x-input-error :messages="$errors->get('order_date')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="total_amount" :value="__('Total Amount')" />
        <x-text-input id="total_amount" name="total_amount" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('total_amount', $order->total_amount ?? '') }}" />
        <x-input-error :messages="$errors->get('total_amount')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="status" :value="__('Status')" />
        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @foreach(\App\Enums\OrderStatus::cases() as $status)
                <option value="{{ $status->value }}" {{ old('status', $order->status ?? '') === $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>
</div>
