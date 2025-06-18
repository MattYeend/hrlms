<?php

use App\Models\LearningMaterial;
use App\Models\LearningProvider;
use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use App\Models\BusinessType;
use Database\Factories\BusinessTypeFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

// Helper
function userWithRoleForLearningMaterials(string $roleSlug): User {
    $role = Role::factory()->create(['slug' => $roleSlug]);
    $admin = User::factory()->create();

    $user = User::factory()->unverified()->create([
        'role_id' => $role->id,
        'department_id' => null,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $department = Department::factory()->create(['dept_lead' => $user->id]);
    $user->update(['department_id' => $department->id]);

    return $user;
}

// Guest access
test('guests cannot access learning material routes', function () {
    $admin = userWithRoleForLearningMaterials('admin');
    $businessType = (new BusinessTypeFactory())->create([
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $material = LearningMaterial::factory()->create();

    $routes = [
        'get' => [
            route('learningMaterials.index'),
            route('learningMaterials.create'),
            route('learningMaterials.show', $material),
            route('learningMaterials.edit', $material),
        ],
        'post' => [
            route('learningMaterials.store'),
        ],
        'put' => [
            route('learningMaterials.update', $material),
        ],
        'delete' => [
            route('learningMaterials.destroy', $material),
        ],
    ];

    foreach ($routes['get'] as $url) {
        $this->get($url)->assertRedirect('/login');
    }

    foreach ($routes['post'] as $url) {
        $this->post($url)->assertRedirect('/login');
    }

    foreach ($routes['put'] as $url) {
        $this->put($url)->assertRedirect('/login');
    }

    foreach ($routes['delete'] as $url) {
        $this->delete($url)->assertRedirect('/login');
    }
});

test('users can view learning material index and show pages', function () {
    $admin = userWithRoleForLearningMaterials('admin');
    $businessType = (new BusinessTypeFactory())->create([
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $user = userWithRoleForLearningMaterials('user');
    $material = LearningMaterial::factory()->create();

    $this->actingAs($user)->get(route('learningMaterials.index'))->assertOk();
    $this->actingAs($user)->get(route('learningMaterials.show', $material))->assertOk();
});

test('users can interact with learning materials', function () {
    $admin = userWithRoleForLearningMaterials('admin');
    $businessType = (new BusinessTypeFactory())->create([
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $user = userWithRoleForLearningMaterials('user');
    $material = LearningMaterial::factory()->create();

    $this->actingAs($user)
        ->get(route('learningMaterials.show', $material))
        ->assertOk();
});

test('learning providers can create learning materials', function () {
    $provider = userWithRoleForLearningMaterials('learning-provider');
    $admin = userWithRoleForLearningMaterials('admin');
    $businessType = (new BusinessTypeFactory())->create([
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);
    $learningProvider = LearningProvider::factory()->create([
        'created_by' => $provider->id,
        'updated_by' => $provider->id,
    ]);

    $data = LearningMaterial::factory()->make([
        'learning_provider_id' => $learningProvider->id,
        'created_by' => $provider->id,
        'updated_by' => $provider->id,
    ])->toArray();

    $response = $this->actingAs($provider)
        ->post(route('learningMaterials.store'), $data);

    $response->assertRedirect();
    $this->assertDatabaseHas('learning_materials', ['title' => $data['title']]);
});

test('learning providers can update their own non-started materials', function () {
    $provider = userWithRoleForLearningMaterials('learning-provider');
    $admin = userWithRoleForLearningMaterials('admin');
    $businessType = (new BusinessTypeFactory())->create([
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);
    $learningProvider = LearningProvider::factory()->create([
        'created_by' => $provider->id,
        'updated_by' => $provider->id,
    ]);

    $material = LearningMaterial::factory()->create([
        'learning_provider_id' => $learningProvider->id,
        'created_by' => $provider->id,
        'updated_by' => $provider->id,
    ]);
    $provider->learningMaterials()->attach($material->id, ['status' => '1']);

    $update = ['title' => 'Updated Material'];
    $response = $this->actingAs($provider)
        ->put(route('learningMaterials.update', $material), $update);

    $response->assertRedirect();
    $this->assertDatabaseHas('learning_materials', ['id' => $material->id, 'title' => 'Updated Material']);
});

test('admin can create learning materials', function () {
    $admin = userWithRoleForLearningMaterials('admin');
    $businessType = (new BusinessTypeFactory())->create([
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);
    $provider = LearningProvider::factory()->create([
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $data = LearningMaterial::factory()->make([
        'learning_provider_id' => $provider->id,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ])->toArray();

    $this->actingAs($admin)
        ->post(route('learningMaterials.store'), $data)
        ->assertRedirect();

    $this->assertDatabaseHas('learning_materials', ['title' => $data['title']]);
});

test('admin can update learning materials if not started', function () {
    $admin = userWithRoleForLearningMaterials('admin');
    $businessType = (new BusinessTypeFactory())->create([
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);
    $material = LearningMaterial::factory()->create([
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);
    $admin->learningMaterials()->attach($material->id, ['status' => '1']);

    $update = ['title' => 'Admin Update'];
    $this->actingAs($admin)
        ->put(route('learningMaterials.update', $material), $update)
        ->assertRedirect();

    $this->assertDatabaseHas('learning_materials', ['id' => $material->id, 'title' => 'Admin Update']);
});
