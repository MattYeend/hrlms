<?php

use App\Models\Role;
use App\Models\Department;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $role = Role::factory()->create();
    $department = Department::factory()->create();
    $admin = User::factory()->create();

    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'first_line' => '123 Main St',
        'post_code' => '12345',
        'role_id' => $role->id,
        'department_id' => $department->id,
        'created_by' => $admin->id,
    ]);
    
    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});