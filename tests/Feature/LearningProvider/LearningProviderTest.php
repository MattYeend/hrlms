<?php

use App\Models\BusinessType;
use App\Models\Department;
use App\Models\LearningProvider;
use App\Models\Role;
use App\Models\User;
use Database\Factories\BusinessTypeFactory;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

uses(RefreshDatabase::class);

function userWithRoleForLearningProviders(string $roleSlug): User {
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

// Guest access
test('guests cannot access any learning provider routes', function () {
    $admin = userWithRoleForLearningProviders('admin');

    $businessType = (new BusinessTypeFactory())->create([
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $learningProvider = LearningProvider::factory()->create([
        'business_type_id' => $businessType->id,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $routes = [
        'get' => [
            route('learningProviders.index'),
            route('learningProviders.create'),
            route('learningProviders.show', $learningProvider),
            route('learningProviders.edit', $learningProvider),
        ],
        'post' => [
            route('learningProviders.store'),
            route('learningProviders.restore', $learningProvider),
        ],
        'put' => [
            route('learningProviders.update', $learningProvider),
        ],
        'delete' => [
            route('learningProviders.destroy', $learningProvider),
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

test('authenticated users can view learning providers index', function (){
    $user = userWithRoleForLearningProviders('user');

    $this->actingAs($user)->get(route('learningProviders.index'))->assertOk();
});

test('authenticated user can view individual learning provider', function (){
    $user = userWithRoleForLearningProviders('user');
    
    $businessType = (new BusinessTypeFactory())->create([
        'created_by' => $user->id,
        'updated_by' => $user->id,
    ]);

    $learningProvider = LearningProvider::factory()->create([
        'business_type_id' => $businessType->id,
        'created_by' => $user->id,
        'updated_by' => $user->id,
    ]);

    $this->actingAs($user)->get(route('learningProviders.show', $learningProvider))->assertOk();
});

test('admins can create learning providers', function () {
    $admin = userWithRoleForLearningProviders('admin');
    $businessType = (new BusinessTypeFactory())->create([
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $data = LearningProvider::factory()->make([
        'business_type_id' => $businessType->id,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ])->toArray();

    $response = $this->actingAs($admin)
        ->post(route('learningProviders.store'), $data);

    $response->assertRedirect();

    $this->assertDatabaseHas('learning_providers', [
        'name' => $data['name'],
        'business_type_id' => $businessType->id,
    ]);
});

test('admins can update any learning provider', function () {
    $admin = userWithRoleForLearningProviders('admin');

    $businessType = (new BusinessTypeFactory())->create([
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $learningProvider = LearningProvider::factory()->create([
        'business_type_id' => $businessType->id,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $update = $learningProvider->toArray();
    $update['name'] = 'Admin Updated';
    $update['business_type_id'] = $businessType->id; 
    unset($update['id'], $update['created_at'], $update['updated_at']);

    $response = $this->actingAs($admin)
        ->put(route('learningProviders.update', $learningProvider), $update);

    $response->assertRedirect();

    $this->assertDatabaseHas('learning_providers', [
        'id' => $learningProvider->id,
        'name' => 'Admin Updated',
    ]);
});

test('admin, or super-admin can archive learning', function () {
    $admin = userWithRoleForLearningProviders('admin');
    $businessType = (new BusinessTypeFactory())->create([
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $learningProvider = LearningProvider::factory()->create([
        'business_type_id' => $businessType->id,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $this->actingAs($admin)
        ->delete(route('learningProviders.destroy', $learningProvider))
        ->assertRedirect();

    expect($learningProvider->fresh()->trashed())->toBeTrue(); // soft-deleted
});

test('non-authorized users cannot archive learning providers', function () {
    $user = userWithRoleForLearningProviders('user');
    $businessType = (new BusinessTypeFactory())->create([
        'created_by' => $user->id,
        'updated_by' => $user->id,
    ]);

    $learningProvider = LearningProvider::factory()->create([
        'business_type_id' => $businessType->id,
        'created_by' => $user->id,
        'updated_by' => $user->id,
    ]);

    $this->actingAs($user)
        ->delete(route('learningProviders.destroy', $learningProvider))
        ->assertStatus(403); // Expect 403 Forbidden instead of redirect
});

test('admins can restore a learning providers', function () {
    $admin = userWithRoleForLearningProviders('admin');
    $businessType = (new BusinessTypeFactory())->create([
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $learningProvider = LearningProvider::factory()->create([
        'business_type_id' => $businessType->id,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);
    $learningProvider->delete();

    $this->actingAs($admin)
        ->post(route('learningProviders.restore', $learningProvider->slug))
        ->assertRedirect();

    expect(LearningProvider::withTrashed()->find($learningProvider->id)->deleted_at)->toBeNull();
});

test('non-admins cannot restore a learning provider', function () {
    $user = userWithRoleForLearningProviders('user');
    $businessType = (new BusinessTypeFactory())->create([
        'created_by' => $user->id,
        'updated_by' => $user->id,
    ]);

    $learningProvider = LearningProvider::factory()->create([
        'business_type_id' => $businessType->id,
        'created_by' => $user->id,
        'updated_by' => $user->id,
    ]);
    $learningProvider->delete();

    $this->actingAs($user)
        ->post(route('learningProviders.restore', $learningProvider->slug))
        ->assertStatus(403); // Expect 403 Forbidden instead of redirect
});