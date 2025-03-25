<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user login correct credentials', function () {
    $user = User::factory()->create(['password' => bcrypt('password123')]);

    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'password123'
    ]);

    $response->assertOk()->assertJsonStructure([
        'status',
        'message',
        'user' => [
            'id',
            'name',
            'email',
            'email_verified_at',
            'created_at',
            'updated_at'    
        ],
        'authorisation' => [
            'access_token',
            'token_type',
            'expires_in',
        ]
    ]);
});

test('user login wrong password', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'wrong-password'
    ]);

    $response->assertUnauthorized();
});
