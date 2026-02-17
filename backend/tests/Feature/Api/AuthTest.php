<?php

use Illuminate\Support\Facades\Hash;

test('login API', function () {
    $user = \App\Models\User::factory()->create([
        'email' => fake()->unique()->safeEmail(),
        'password' => Hash::make('password'),
    ]);
    $response = $this->post('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200);
});
