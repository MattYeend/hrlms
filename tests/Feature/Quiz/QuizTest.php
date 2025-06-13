<?php

use App\Models\Role;
use App\Models\Department;
use App\Models\User;
use App\Models\Quiz;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

function userWithRoleForQuizzes(string $roleSlug): User {
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

test('guests cannot view quizzes index page', function () {
    $this->get(route('quizzes.index'))->assertRedirect('/login');
});

test('regular users can view quizzes index page', function () {
    $user = userWithRoleForQuizzes('user');
    $this->actingAs($user);

    $response = $this->get(route('quizzes.index'));
    $response->assertOk();
});

test('admins can create quizzes', function () {
    $admin = userWithRoleForQuizzes('admin');
    $this->actingAs($admin);

    $response = $this->post(route('quizzes.store'), [
        'title' => 'Sample Quiz',
        'description' => 'Quiz description',
        'pass_percentage' => '43.4',
    ]);

    $quiz = Quiz::where('title', 'Sample Quiz')->first();

    $response->assertRedirect(route('quizzes.show', $quiz));
    $this->assertDatabaseHas('quizzes', ['title' => 'Sample Quiz']);
});

test('super-admins can create quizzes', function () {
    $superAdmin = userWithRoleForQuizzes('super-admin');
    $this->actingAs($superAdmin);

    $response = $this->post(route('quizzes.store'), [
        'title' => 'Sample Quiz',
        'description' => 'Quiz description',
        'pass_percentage' => '43.4',
    ]);

    $quiz = Quiz::where('title', 'Sample Quiz')->first();

    $response->assertRedirect(route('quizzes.show', $quiz));
    $this->assertDatabaseHas('quizzes', ['title' => 'Sample Quiz']);
});

test('non-authorized users cannot create quizzes', function () {
    $user = userWithRoleForQuizzes('user');
    $this->actingAs($user);

    $response = $this->post(route('quizzes.store'), [
        'title' => 'Unauthorized Quiz',
    ]);

    $response->assertForbidden();
});

test('admins can update quizzes if not started', function () {
    $admin = userWithRoleForQuizzes('admin');
    $this->actingAs($admin);

    $quiz = Quiz::factory()->create();

    $this->assertFalse($quiz->isStarted());

    $response = $this->put(route('quizzes.update', $quiz), [
        'title' => 'Updated Quiz Title',
    ]);

    $response->assertRedirect(route('quizzes.show', $quiz));
    $this->assertDatabaseHas('quizzes', ['id' => $quiz->id, 'title' => 'Updated Quiz Title']);
});

test('super admins can update quizzes if not started', function () {
    $superAdmin = userWithRoleForQuizzes('super-admin');
    $this->actingAs($superAdmin);

    $quiz = Quiz::factory()->create();

    $this->assertFalse($quiz->isStarted());

    $response = $this->put(route('quizzes.update', $quiz), [
        'title' => 'Updated Quiz Title',
    ]);

    $response->assertRedirect(route('quizzes.show', $quiz));
    $this->assertDatabaseHas('quizzes', ['id' => $quiz->id, 'title' => 'Updated Quiz Title']);
});

test('admins cannot update quizzes if already started', function () {
    $admin = userWithRoleForQuizzes('admin');
    $this->actingAs($admin);

    $quiz = Quiz::factory()->create();

    $user = User::factory()->create();
    $quiz->completedBy()->attach($user->id);

    $this->assertTrue($quiz->isStarted());

    $response = $this->put(route('quizzes.update', $quiz), [
        'title' => 'Attempt Update Started Quiz',
    ]);

    $response->assertForbidden();
});
