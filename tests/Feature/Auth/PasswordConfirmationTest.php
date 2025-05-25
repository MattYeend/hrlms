<?php

use App\Models\User;
use App\Models\Department;
use App\Models\Role;
use App\Models\Company;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('confirm password screen can be rendered', function () {
    $role = Role::factory()->create();
    
    $department = Department::factory()->create();
    
    $admin = User::factory()->create();

    $user = User::factory()->create([
        'role_id' => $role->id,
        'department_id' => $department->id,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $response = $this->actingAs($user)->get('/confirm-password');

    $response->assertStatus(200);
});

test('password can be confirmed', function () {
    $role = Role::factory()->create();
    
    $department = Department::factory()->create();
    
    $admin = User::factory()->create();

    $user = User::factory()->create([
        'role_id' => $role->id,
        'department_id' => $department->id,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $response = $this->actingAs($user)->post('/confirm-password', [
        'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

test('password is not confirmed with invalid password', function () {
    $role = Role::factory()->create();
    
    $department = Department::factory()->create();
    
    $admin = User::factory()->create();

    $user = User::factory()->create([
        'role_id' => $role->id,
        'department_id' => $department->id,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $response = $this->actingAs($user)->post('/confirm-password', [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();
});