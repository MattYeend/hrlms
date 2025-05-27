<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use App\Models\Company;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $role = Role::factory()->create();
    $admin = User::factory()->create();

    $user = User::factory()->create([
        'role_id' => $role->id,
        'department_id' => null,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $department = Department::factory()->create([
        'dept_lead' => $user->id
    ]);

    $user->update(['department_id' => $department->id]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('users can not authenticate with invalid password', function () {
    $role = Role::factory()->create();
    
    $admin = User::factory()->create();

    $user = User::factory()->create([
        'role_id' => $role->id,
        'department_id' => null,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $department = Department::factory()->create([
        'dept_lead' => $user->id
    ]);

    $user->update(['department_id' => $department->id]);

    $user = User::factory()->create([
        'role_id' => $role->id,
        'department_id' => $department->id,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $role = Role::factory()->create();
    
    $admin = User::factory()->create();

    $user = User::factory()->create([
        'role_id' => $role->id,
        'department_id' => null,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $department = Department::factory()->create([
        'dept_lead' => $user->id
    ]);

    $user->update(['department_id' => $department->id]);

    $user = User::factory()->create([
        'role_id' => $role->id,
        'department_id' => $department->id,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});