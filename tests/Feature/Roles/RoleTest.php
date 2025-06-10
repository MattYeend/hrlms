<?php

use App\Models\Role;
use App\Models\Department;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

function userWithRoleForRoles(string $roleSlug): User {
    $role = Role::factory()->create(['slug' => $roleSlug]);
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
    $user->save();

    return $user;
}

test('guests cannot view roles index or show pages', function () {
    $role = Role::factory()->create();

    $this->get(route('roles.index'))->assertRedirect('/login');
    $this->get(route('roles.show', $role))->assertRedirect('/login');
});

test('unauthorized users cannot view roles', function () {
    $user = userWithRoleForRoles('user');
    $this->actingAs($user);

    $roleToView = Role::factory()->create();

    $this->get(route('roles.index'))->assertForbidden();
    $this->get(route('roles.show', $roleToView))->assertForbidden();
});

test('admin or super-admin users can view all roles', function () {
    $admin = userWithRoleForRoles('admin');

    $this->actingAs($admin);

    $roles = Role::factory()->count(3)->create();

    $response = $this->get(route('roles.index'));
    $response->assertOk();
    foreach ($roles as $role) {
        $response->assertSee($role->name);
    }
});

test('admin or super-admin users can view a specific role', function () {
    $superAdmin = userWithRoleForRoles('super-admin');

    $this->actingAs($superAdmin);

    $role = Role::factory()->create([
        'name' => 'Test Role',
        'slug' => 'test-role',
    ]);

    $response = $this->get(route('roles.show', $role));
    $response->assertOk();
    $response->assertSee('Test Role');
});