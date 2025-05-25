<?php

use App\Models\Role;
use App\Models\Department;
use App\Models\User;
use App\Models\Company;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests cannot view roles index or show pages', function () {
    $role = Role::factory()->create();

    $this->get(route('roles.index'))->assertRedirect('/login');
    $this->get(route('roles.show', $role))->assertRedirect('/login');
});

test('unauthorized users cannot view roles', function () {
    $role = Role::factory()->create(); // create a non-admin role
    $department = Department::factory()->create();
    $creator = User::factory()->create();

    $user = User::factory()->create([
        'role_id' => $role->id,
        'department_id' => $department->id,
        'created_by' => $creator->id,
        'updated_by' => $creator->id,
    ]);

    $this->actingAs($user);

    $roleToView = Role::factory()->create();

    $this->get(route('roles.index'))->assertForbidden();
    $this->get(route('roles.show', $roleToView))->assertForbidden();
});

test('admin or super-admin users can view all roles', function () {
    $adminRole = Role::factory()->create(['slug' => 'admin']);
    $department = Department::factory()->create();
    $creator = User::factory()->create();

    $admin = User::factory()->create([
        'role_id' => $adminRole->id,
        'department_id' => $department->id,
        'created_by' => $creator->id,
        'updated_by' => $creator->id,
    ]);

    $this->actingAs($admin);

    $roles = Role::factory()->count(3)->create();

    $response = $this->get(route('roles.index'));
    $response->assertOk();
    foreach ($roles as $role) {
        $response->assertSee($role->name);
    }
});

test('admin or super-admin users can view a specific role', function () {
    $superAdminRole = Role::factory()->create(['slug' => 'super-admin']);
    $department = Department::factory()->create();
    $creator = User::factory()->create();

    $superAdmin = User::factory()->create([
        'role_id' => $superAdminRole->id,
        'department_id' => $department->id,
        'created_by' => $creator->id,
        'updated_by' => $creator->id,
    ]);

    $this->actingAs($superAdmin);

    $role = Role::factory()->create([
        'name' => 'Test Role',
        'slug' => 'test-role',
    ]);

    $response = $this->get(route('roles.show', $role));
    $response->assertOk();
    $response->assertSee('Test Role');
});