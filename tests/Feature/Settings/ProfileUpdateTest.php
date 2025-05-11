<?php

use App\Models\User;
use App\Models\Department;
use App\Models\Role;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('profile page is displayed', function () {
    $role = Role::factory()->create();
    
    $company = Company::factory()->create();
    $department = Department::factory()->create([
        'company_id' => $company->id,
    ]);
    
    $admin = User::factory()->create();

    $user = User::factory()->create([
        'role_id' => $role->id,
        'department_id' => $department->id,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/settings/profile');

    $response->assertOk();
});

test('profile information can be updated', function () {
    $role = Role::factory()->create();
    
    $company = Company::factory()->create();
    $department = Department::factory()->create([
        'company_id' => $company->id,
    ]);
    
    $admin = User::factory()->create();

    $user = User::factory()->create([
        'role_id' => $role->id,
        'department_id' => $department->id,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
        'email_verified_at' => now(),
        'first_line' => '123 Main St',
        'post_code' => '12345',
    ]);

    $response = $this
        ->actingAs($user)
        ->patch('/settings/profile', [
            'name' => 'Updated User',
            'email' => 'updated@example.com',
            'first_line' => '456 New Address',
            'post_code' => '67890',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/settings/profile');

    $user->refresh();

    expect($user->name)->toBe('Updated User');
    expect($user->email)->toBe('updated@example.com');
    expect($user->email_verified_at)->toBeNull(); // Email changed, should unverify
});

test('email verification status is unchanged when email is unchanged', function () {
    $role = Role::factory()->create();
    
    $company = Company::factory()->create();
    $department = Department::factory()->create([
        'company_id' => $company->id,
    ]);
    
    $admin = User::factory()->create();

    $user = User::factory()->create([
        'role_id' => $role->id,
        'department_id' => $department->id,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
        'email_verified_at' => now(),
        'first_line' => '123 Main St',
        'post_code' => '12345',
    ]);

    $response = $this
        ->actingAs($user)
        ->patch('/settings/profile', [
            'name' => 'Still Verified',
            'email' => $user->email,
            'first_line' => '456 New Address',
            'post_code' => '67890',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/settings/profile');

    expect($user->refresh()->email_verified_at)->not->toBeNull();
});

test('user can delete their account', function () {
    $role = Role::factory()->create();
    
    $company = Company::factory()->create();
    $department = Department::factory()->create([
        'company_id' => $company->id,
    ]);
    
    $admin = User::factory()->create();

    $user = User::factory()->create([
        'role_id' => $role->id,
        'department_id' => $department->id,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
        'password' => bcrypt('password'),
    ]);

    $response = $this
        ->actingAs($user)
        ->delete('/settings/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    expect($user->fresh())->toBeNull();
});

test('correct password must be provided to delete account', function () {
    $role = Role::factory()->create();
    
    $company = Company::factory()->create();
    $department = Department::factory()->create([
        'company_id' => $company->id,
    ]);
    
    $admin = User::factory()->create();

    $user = User::factory()->create([
        'role_id' => $role->id,
        'department_id' => $department->id,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
        'password' => bcrypt('password'),
    ]);

    $response = $this
        ->actingAs($user)
        ->from('/settings/profile')
        ->delete('/settings/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrors('password')
        ->assertRedirect('/settings/profile');

    expect($user->fresh())->not->toBeNull();
});