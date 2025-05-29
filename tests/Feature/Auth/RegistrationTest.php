<?php

use App\Models\Role;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Str;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $role = Role::factory()->create();
    $admin = User::factory()->create();

    $user = User::factory()->unverified()->create([
        'role_id' => $role->id,
        'department_id' => null,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $department = Department::factory()->create([
        'dept_lead' => $user->id
    ]);

    $user->update(['department_id' => $department->id]);

    $response = $this->followingRedirects()->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'slug' => Str::slug('Test User'),
        'first_line' => '123 Main St',
        'post_code' => '12345',
        'role_id' => $role->id,
        'department_id' => $department->id,
    ]);

    $response->assertStatus(200);
    $this->assertAuthenticated();
    $response->assertSee('Dashboard'); 
});
