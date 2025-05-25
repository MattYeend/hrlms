<?php

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

uses(RefreshDatabase::class);

// Helper
function userWithRole(string $roleSlug): User {
    $role = Role::factory()->create(['slug' => $roleSlug]);
    $department = Department::factory()->create();

    $user = User::factory()->create([
        'role_id' => $role->id,
        'department_id' => $department->id,
    ]);

    $user->created_by = $user->id;
    $user->updated_by = $user->id;
    $user->save();

    return $user;
}

// Guest access
test('guests cannot access any department routes', function () {
    $department = Department::factory()->create();

    $routes = [
        'get' => [
            route('departments.index'),
            route('departments.create'),
            route('departments.show', $department),
            route('departments.edit', $department),
        ],
        'post' => [
            route('departments.store'),
            route('departments.restore', $department->id),
        ],
        'put' => [
            route('departments.update', $department),
        ],
        'delete' => [
            route('departments.destroy', $department),
        ],
    ];

    foreach ($routes['get'] as $url) {
        $this->get($url)->assertRedirect('/login');
    }

    foreach ($routes['post'] as $url) {
        $this->post($url, [])->assertRedirect('/login');
    }

    foreach ($routes['put'] as $url) {
        $this->put($url, [])->assertRedirect('/login');
    }

    foreach ($routes['delete'] as $url) {
        $this->delete($url)->assertRedirect('/login');
    }
});

// Viewing
test('authenticated users can view departments index', function () {
    $user = userWithRole('user');
    $this->actingAs($user)->get(route('departments.index'))->assertOk();
    $this->actingAs($user)->get(route('departments.index'))->assertOk();
});

test('authenticated users can view a department', function () {
    $user = userWithRole('user');
    $department = Department::factory()->create();

    $this->actingAs($user)->get(route('departments.show', $department))->assertOk();
});

// Create
test('admins can create a department', function () {
    $admin = userWithRole('admin');
    $data = Department::factory()->make()->toArray();
    $data['slug'] = Str::slug($data['name']);

    $this->actingAs($admin)
        ->post(route('departments.store'), $data)
        ->assertRedirect();

    expect(Department::where('slug', $data['slug'])->exists())->toBeTrue();
});

test('non-admins cannot create a department', function () {
    $user = userWithRole('user');
    $data = Department::factory()->make()->toArray();
    $data['slug'] = Str::slug($data['name']);

    $this->actingAs($user)
        ->post(route('departments.store'), $data)
        ->assertForbidden();
});

// Update
test('admins can update a department', function () {
    $admin = userWithRole('admin');
    $department = Department::factory()->create();

    $update = ['name' => 'Updated Name', 'slug' => 'updated-name'];

    $this->actingAs($admin)
        ->put(route('departments.update', $department), $update)
        ->assertRedirect();

    expect(Department::find($department->id)->slug)->toBe('updated-name');
});

test('non-admins cannot update a department', function () {
    $user = userWithRole('user');
    $department = Department::factory()->create();

    $this->actingAs($user)
        ->put(route('departments.update', $department), ['name' => 'X', 'slug' => 'x'])
        ->assertForbidden();
});

// Delete
test('admins can delete a department', function () {
    $admin = userWithRole('admin');
    $department = Department::factory()->create();

    $this->actingAs($admin)
        ->delete(route('departments.destroy', $department))
        ->assertRedirect();

    expect($department->fresh()->deleted_at)->not()->toBeNull();
});

test('non-admins cannot delete a department', function () {
    $user = userWithRole('user');
    $department = Department::factory()->create();

    $this->actingAs($user)
        ->delete(route('departments.destroy', $department))
        ->assertForbidden();
});

// Restore
test('admins can restore a deleted department', function () {
    $admin = userWithRole('admin');
    $department = Department::factory()->create();
    $department->delete();

    $this->actingAs($admin)
        ->post(route('departments.restore', $department->id))
        ->assertRedirect();

    expect(Department::find($department->id))->not()->toBeNull();
});

test('non-admins cannot restore a department', function () {
    $user = userWithRole('user');
    $department = Department::factory()->create();
    $department->delete();

    $this->actingAs($user)
        ->post(route('departments.restore', $department->id))
        ->assertForbidden();
});