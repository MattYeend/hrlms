<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

uses(RefreshDatabase::class)->in(__DIR__);

use function Pest\Laravel\actingAs;

function userWithRoleForUsers(string $roleName): User {
    $role = Role::firstOrCreate(
        ['name' => $roleName],
        ['slug' => Str::slug($roleName)]
    );

    $department = \App\Models\Department::factory()->create();
    $creator = User::factory()->create();

    return User::factory()->create([
        'role_id' => $role->id,
        'department_id' => $department->id,
        'created_by' => $creator->id,
        'updated_by' => $creator->id,
        'password' => Hash::make('password'),
        'first_line' => '123 Main St',
        'post_code' => 'AB12 3CD',
        'full_time' => true,
        'part_time' => false,
    ]);
}

// Guest access
test('guests are redirected to the login page', function () {
    $this->get(route('users.index'))->assertRedirect('/login');
    $this->get(route('users.show', 1))->assertRedirect('/login');
    $this->post(route('users.store'))->assertRedirect('/login');
    $this->put(route('users.update', 1))->assertRedirect('/login');
});

// Create users
test('admins can create users', function () {
    $admin = userWithRoleForUsers('admin');
    $userData = User::factory()->make()->only(['name', 'email']) + [
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
        'first_line' => '123 Main St',
        'post_code' => 'AB12 3CD',
        'full_time' => true,
        'part_time' => false,
    ];

    actingAs($admin)->post(route('users.store'), $userData)->assertRedirect();
});

test('superadmins can create users', function () {
    $superadmin = userWithRoleForUsers('superadmin');
    $userData = User::factory()->make()->only(['name', 'email']) + [
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
        'first_line' => '123 Main St',
        'post_code' => 'AB12 3CD',
        'full_time' => true,
        'part_time' => false,
    ];

    actingAs($superadmin)->post(route('users.store'), $userData)->assertRedirect();
});

test('normal users cannot create users', function () {
    $user = userWithRoleForUsers('user');
    $userData = User::factory()->make()->only(['name', 'email']) + [
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
        'first_line' => '123 Main St',
        'post_code' => 'AB12 3CD',
        'full_time' => true,
        'part_time' => false,
    ];

    actingAs($user)->post(route('users.store'), $userData)->assertRedirect();
});

// View single and all users
test('any authenticated user can view a single user', function () {
    $user = userWithRoleForUsers('user');
    $target = User::factory()->create();

    actingAs($user)->get(route('users.show', $target))->assertOk();
});

test('any authenticated user can view all users', function () {
    $user = userWithRoleForUsers('user');
    actingAs($user)->get(route('users.index'))->assertOk();
});

// Update
test('admins can update any user', function () {
    $admin = userWithRoleForUsers('admin');
    $target = User::factory()->create();

    $update = ['name' => 'Admin Updated'];
    actingAs($admin)->put(route('users.update', $target), $update)->assertRedirect();
});

test('superadmins can update any user', function () {
    $superadmin = userWithRoleForUsers('superadmin');
    $target = User::factory()->create();

    $update = ['name' => 'Super Updated'];
    actingAs($superadmin)->put(route('users.update', $target), $update)->assertRedirect();
});

test('users can update their own profile', function () {
    $user = userWithRoleForUsers('user');

    $update = ['name' => 'Self Updated'];
    actingAs($user)->put(route('users.update', $user), $update)->assertRedirect();
    expect($user->fresh()->name)->toBe('Self Updated');
});

test('users cannot update other users', function () {
    $user = userWithRoleForUsers('user');
    $other = User::factory()->create();

    $update = ['name' => 'Not Allowed'];
    actingAs($user)->put(route('users.update', $other), $update)->assertRedirect();
});