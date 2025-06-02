<?php

use App\Models\User;
use App\Models\Role;
use App\Models\UserJob;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

function userWithRoleForJobs(string $roleName): User
{
    $role = Role::firstOrCreate(
        ['name' => $roleName],
        ['slug' => Str::slug($roleName)]
    );

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

// Authenticated user can view user jobs index

test('user with role can view user jobs index', function () {
    $user = userWithRoleForJobs('admin');

    $this->actingAs($user);

    $response = $this->get(route('jobs.index'));
    $response->assertOk();
});

// Creating a UserJob

test('user can create a new user job', function () {
    $user = userWithRoleForJobs('admin');

    $this->actingAs($user);

    $jobData = UserJob::factory()->make()->toArray();

    $response = $this->post(route('jobs.store'), $jobData);

    $response->assertRedirect();

    $redirectUrl = $response->headers->get('Location');
    $this->assertStringContainsString('/jobs/', $redirectUrl);
});

// Viewing a single UserJob

test('user can view a single user job', function () {
    $user = userWithRoleForJobs('admin');

    $job = UserJob::factory()->create();

    $this->actingAs($user);

    $response = $this->get(route('jobs.show', $job));
    $response->assertOk();
    $response->assertSee($job->job_title);
});

// Updating a UserJob

test('user can update a user job', function () {
    $user = userWithRoleForJobs('admin');
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

// Deleting a UserJob

test('user can delete a user job', function () {
    $user = userWithRoleForJobs('admin');
    $job = UserJob::factory()->create();

    $this->actingAs($user);

    $response = $this->delete(route('jobs.destroy', $job));

    $response->assertRedirect(route('jobs.index'));

    // Use assertSoftDeleted if soft deletes enabled
    $this->assertSoftDeleted('user_jobs', ['id' => $job->id]);
});