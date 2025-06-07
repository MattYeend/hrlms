<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Blog;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

beforeEach(function () {
    seedRoles();
});

function userWithRoleForBlogs(string $roleName): User
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

test('guests cannot access any blog routes', function () {
    $admin = userWithRoleForBlogs('admin');
    $blog = Blog::factory()->create([
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $routes = [
        'get' => [
            route('blogs.index'),
            route('blogs.create'),
            route('blogs.show', $blog),
            route('blogs.edit', $blog),
        ],
        'post' => [
            route('blogs.store'),
            route('blogs.restore', $blog),
            route('blogs.approve', $blog),
            route('blogs.deny', $blog),
        ],
        'put' => [
            route('blogs.update', $blog),
        ],
        'delete' => [
            route('blogs.destroy', $blog),
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

test('authenticated users can view blog index', function (){
    $user = userWithRoleForBlogs('user');

    $this->actingAs($user)->get(route('blogs.index'))->assertOk();
});

test('authenticated user can view individual blog', function (){
    $user = userWithRoleForBlogs('user');
    $blog = Blog::factory()->create([
        'created_by' => $user->id,
        'updated_by' => $user->id,
    ]);
    $this->actingAs($user)->get(route('blogs.show', $blog))->assertOk();
});

test('any authenticated user can create a blog', function () {
    $user = userWithRoleForBlogs('user');
    $data = Blog::factory()->make()->toArray();
    $data['slug'] = Str::slug($data['title']);

    $this->actingAs($user)
        ->post(route('blogs.store'), $data)
        ->assertRedirect();

    expect(Blog::where('slug', $data['slug'])->exists())->toBeTrue();
});

test('users can update their blog if not approved', function () {
    $admin = userWithRoleForBlogs('admin');
    $department = Department::factory()->create(['dept_lead' => null]);

    $user = User::factory()->create([
        'role_id' => $admin->role->id,
        'department_id' => $department->id,
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);
    $department->update(['dept_lead' => $user->id]);

    $blog = Blog::factory()->create([
        'created_by' => $user->id,
        'updated_by' => $user->id,
        'approved' => false,
    ]);

    $this->actingAs($user) 
        ->put(route('blogs.update', $blog), ['title' => 'Updated', 'content' => 'Changed'])
        ->assertRedirect();

    expect($blog->fresh()->title)->toBe('Updated');
});

test('users cannot update blog if it is approved', function () {
    $user = userWithRoleForBlogs('user');
    $blog = Blog::factory()->create([
        'created_by' => $user->id,
        'updated_by' => $user->id,
        'approved' => true,
    ]);

    $this->actingAs($user)
        ->put(route('blogs.update', $blog), ['title' => 'Blocked'])
        ->assertForbidden();
});

test('only admins or super admins can approve blogs', function () {
    $admin = userWithRoleForBlogs('admin');
    $blog = Blog::factory()->create([
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $this->actingAs($admin)
        ->post(route('blogs.approve', $blog))
        ->assertRedirect();

    expect($blog->fresh()->approved)->toBeTruthy();
});

test('non-admins cannot approve blogs', function () {
    $user = userWithRoleForBlogs('user');
    $blog = Blog::factory()->create([
        'created_by' => $user->id,
        'updated_by' => $user->id,
    ]);

    $this->actingAs($user)
        ->post(route('blogs.approve', $blog))
        ->assertForbidden();
});

test('only admins or super admins can deny blogs', function () {
    $admin = userWithRoleForBlogs('superadmin');
    $blog = Blog::factory()->create([
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);

    $this->actingAs($admin)
        ->post(route('blogs.deny', $blog))
        ->assertRedirect();

    expect($blog->fresh()->denied)->toBeTruthy();
});

test('admin, or super-admin can archive blogs', function () {
    $user = userWithRoleForBlogs('admin');
    $blog = Blog::factory()->create([
        'created_by' => $user->id,
        'updated_by' => $user->id,
    ]);

    $this->actingAs($user)
        ->delete(route('blogs.destroy', $blog))
        ->assertRedirect();

    expect($blog->fresh()->trashed())->toBeTrue(); // soft-deleted
});

test('non-authorized users cannot archive blogs', function () {
    $user = userWithRoleForBlogs('user');
    $blog = Blog::factory()->create([
        'created_by' => $user->id,
        'updated_by' => $user->id,
    ]);

    $this->actingAs($user)
        ->delete(route('blogs.destroy', $blog))
        ->assertRedirect();
});

test('admins can restore a blog', function () {
    $admin = userWithRoleForBlogs('admin');
    $blog = Blog::factory()->create([
        'created_by' => $admin->id,
        'updated_by' => $admin->id,
    ]);
    $blog->delete();

    $this->actingAs($admin)
        ->post(route('blogs.restore', $blog->slug))
        ->assertRedirect();

    expect(Blog::withTrashed()->find($blog->id)->deleted_at)->toBeNull();
});

test('non-admins cannot restore a blog', function () {
    $user = userWithRoleForBlogs('user');
    $blog = Blog::factory()->create([
        'created_by' => $user->id,
        'updated_by' => $user->id,
    ]);
    $blog->delete();

    $this->actingAs($user)
        ->post(route('blogs.restore', $blog->slug))
        ->assertRedirect();
});