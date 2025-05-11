<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'title' => 'Mr',
        'name' => 'Test User',
        'email' => 'test@example.com',
        'first_line' => '123 Example St',
        'second_line' => 'Apt 456',
        'town' => 'Sampletown',
        'city' => 'Testville',
        'county' => 'Exampleshire',
        'country' => 'Testland',
        'post_code' => 'TE57 1NG',
        'full_time' => true,
        'part_time' => false,
        'role_id' => 1,
        'department_id' => 1,
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();

    $response->assertRedirect(route('dashboard', absolute: false));

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
        'name' => 'Test User',
        'role_id' => 1,
        'department_id' => 1,
    ]);
});