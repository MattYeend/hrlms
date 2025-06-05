<?php

use App\Models\User;
use App\Models\Role;
use App\Models\UserJob;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

function seedRoles()
{
    Role::updateOrCreate(
        ['id' => Role::SUPER_ADMIN],
        ['slug' => 'superadmin', 'name' => 'Super Admin']
    );

    Role::updateOrCreate(
        ['id' => Role::ADMIN],
        ['slug' => 'admin', 'name' => 'Admin']
    );

    Role::updateOrCreate(
        ['id' => Role::USER],
        ['slug' => 'user', 'name' => 'User']
    );
}

beforeEach(function () {
    seedRoles();
});

function userWithRoleForJobs(string $roleName): User
{
    $slug = Str::slug($roleName);

    $role = Role::where('slug', $slug)->first();

    if (!$role) {
        throw new Exception("Role with slug {$slug} not found. Make sure seedRoles() is called.");
    }

    $creator = User::factory()->create();

    $user = User::factory()->unverified()->create([
        'slug' => Str::slug('Test User'),
        'role_id' => $role->id,
        'department_id' => null,
        'created_by' => $creator->id,
        'updated_by' => $creator->id,
    ]);

    $department = Department::factory()->create([
        'dept_lead' => $user->id,
    ]);

    $user->update(['department_id' => $department->id]);

    return $user->fresh();
}

// Guest access
test('guests cannot access user jobs index and are redirected to login', function () {
    $response = $this->get(route('jobs.index'));
    $response->assertRedirect(route('login'));
});

// Authenticated users (non-superadmin) can view user jobs index and show but not create or edit
test('non-superadmin user can view user jobs index and single job', function () {
    $user = userWithRoleForJobs('user'); 

    // Debug role slug and superadmin check
    $this->assertEquals('user', $user->role->slug);
    $this->assertFalse($user->isSuperAdmin());

    $job = UserJob::factory()->create();

    $this->actingAs($user);

    $responseIndex = $this->get(route('jobs.index'));
    $responseIndex->assertOk();

    $responseShow = $this->get(route('jobs.show', $job));
    $responseShow->assertOk();

    $responseCreate = $this->get(route('jobs.create'));
    $responseCreate->assertStatus(403);

    $responseStore = $this->post(route('jobs.store'), UserJob::factory()->make()->toArray());
    $responseStore->assertStatus(403);

    $responseEdit = $this->get(route('jobs.edit', $job));
    $responseEdit->assertStatus(403);

    $responseUpdate = $this->put(route('jobs.update', $job), [
        'job_title' => 'Should not update',
        'slug' => Str::slug('Should not update'),
        'short_code' => $job->short_code,
        'description' => $job->description,
        'department_id' => $job->department_id,
        'created_by' => $job->created_by,
        'updated_by' => $user->id,
    ]);
    $responseUpdate->assertStatus(403);
});

// Superadmin can create and edit jobs
test('superadmin can create a new user job', function () {
    $user = userWithRoleForJobs('superadmin');

    $this->actingAs($user);

    $jobData = UserJob::factory()->make()->toArray();

    $response = $this->post(route('jobs.store'), $jobData);

    $response->assertRedirect();

    $redirectUrl = $response->headers->get('Location');
    $this->assertStringContainsString('/jobs/', $redirectUrl);
});

test('superadmin can update a user job', function () {
    $user = userWithRoleForJobs('superadmin');
    $job = UserJob::factory()->create();

    $this->actingAs($user);

    $newTitle = 'Updated Job Title';
    $response = $this->put(route('jobs.update', $job), [
        'job_title' => $newTitle,
        'slug' => Str::slug($newTitle),
        'short_code' => $job->short_code,
        'description' => $job->description,
        'department_id' => $job->department_id,
        'created_by' => $job->created_by,
        'updated_by' => $user->id,
    ]);

    $job->refresh();
    $response->assertRedirect(route('jobs.show', $job));
    $this->assertDatabaseHas('user_jobs', [
        'id' => $job->id,
        'job_title' => $newTitle,
    ]);
});