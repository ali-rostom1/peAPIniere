<?php

use App\Models\Plant;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});
test('plant generates slug automatically', function () {
    $user = User::factory()->create();
    $plant = Plant::factory()->create([
        'name' => 'Test Plant',
        'admin_id' => $user->id
    ]);
    expect($plant->slug)->toBe('test-plant');
});

test('can fetch plant by slug', function () {
    /** @var App\Models\User $user **/
    $user = User::factory()->create();
    $user->assignRole('client');
    $plant = Plant::factory()->create([
        'name' => 'Snake Plant',
        'admin_id' => $user->id 
    ]);
    $token = Auth::login($user);

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token
    ])->getJson("/api/v1/plants/{$plant->slug}");

    $response->assertOk()
        ->assertJsonFragment([
            'slug' => 'snake-plant'
        ]);
});