<?php

use App\Models\User;
use App\Models\Department;
use App\Models\Role;
use App\Models\Company;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('reset password link screen can be rendered', function () {
    $response = $this->get('/forgot-password');

    $response->assertStatus(200);
});

test('reset password link can be requested', function () {
    Notification::fake();

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

    $this->post('/forgot-password', ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class);
});

test('reset password screen can be rendered', function () {
    Notification::fake();

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

    $this->post('/forgot-password', ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
        $response = $this->get('/reset-password/'.$notification->token);

        $response->assertStatus(200);

        return true;
    });
});

test('password can be reset with valid token', function () {
    Notification::fake();

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

    $this->post('/forgot-password', ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
        $response = $this->post('/reset-password', [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('login'));

        return true;
    });
});