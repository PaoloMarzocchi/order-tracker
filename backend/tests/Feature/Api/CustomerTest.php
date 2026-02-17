<?php

use Illuminate\Support\Facades\Hash;

function getToken()
{
    $user = \App\Models\User::factory()->create([
        'email' => fake()->unique()->safeEmail(),
        'password' => Hash::make('password'),
    ]);

    return $user->createToken('auth_token')->plainTextToken;
}

test('customer index API', function () {
    $token = getToken();
    $response = $this->withToken($token)->getJson('/api/customers');
    //dd($response);

    $response->assertStatus(200);
});

test('customer show API', function () {
    $token = getToken();

    $customer = \App\Models\Customer::factory()->create();
    //dd($customer);
    $response = $this->withToken($token)->getJson('/api/customers/' . $customer->id);
    //dd($response);

    $response->assertStatus(200);
});

test('customer create API', function () {
    $token = getToken();

    $customerData = [
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'phone' => fake()->phoneNumber(),
        'address' => fake()->address(),
    ];

    $response = $this->withToken($token)->postJson('/api/customers', $customerData);
    //dd($response);

    $response->assertStatus(201);
});


test('customer update API', function () {
    $token = getToken();

    $customer = \App\Models\Customer::factory()->create();
    $updateData = [
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'phone' => fake()->phoneNumber(),
        'address' => fake()->address(),
    ];

    $response = $this->withToken($token)->putJson('/api/customers/' . $customer->id, $updateData);
    //dd($response);

    $response->assertStatus(200);
});

test('customer delete API', function () {
    $token = getToken();

    $customer = \App\Models\Customer::factory()->create();

    $response = $this->withToken($token)->deleteJson('/api/customers/' . $customer->id);
    //dd($response);

    $response->assertStatus(200);
});
