<?php

use App\Models\Role;
use App\Models\Department;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $response = $this->get('/dashboard');
    $response->assertRedirect('/login');
});

test('authenticated users can visit the dashboard', function () {
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

    $user = User::factory()->create([
        'role_id' => $role->id,
        'department_id' => $department->id,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);
    $this->actingAs($user);

    $response = $this->get('/dashboard');
    $response->assertStatus(200);
});