<?php

use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use App\Models\Company;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->superAdminRole = Role::factory()->create(['id' => 1, 'name' => 'Super Admin']);
    $this->adminRole = Role::factory()->create(['id' => 2, 'name' => 'Admin']);
    $this->creator = User::factory()->create([
        'role_id' => $this->superAdminRole->id,
        'department_id' => null,
        'created_by' => null,
        'updated_by' => null,
    ]);
    $this->department = Department::factory()->create();
    $this->company = Company::factory()->create();
});

test('guests cannot access any company routes', function () {
    $this->get(route('companies.index'))->assertRedirect('/login');
    $this->get(route('companies.create'))->assertRedirect('/login');
    $this->post(route('companies.store'), [])->assertRedirect('/login');
    $this->get(route('companies.show', $this->company))->assertRedirect('/login');
    $this->get(route('companies.edit', $this->company))->assertRedirect('/login');
    $this->put(route('companies.update', $this->company), [])->assertRedirect('/login');
    $this->delete(route('companies.destroy', $this->company))->assertRedirect('/login');
});

test('non-superadmin users cannot access any company routes', function () {
    $user = User::factory()->create([
        'role_id' => $this->adminRole->id,
        'department_id' => $this->department->id,
        'created_by' => $this->creator->id,
        'updated_by' => $this->creator->id,
    ]);

    $this->actingAs($user);

    $this->get(route('companies.index'))->assertForbidden();
    $this->get(route('companies.create'))->assertForbidden();
    $this->post(route('companies.store'), [])->assertForbidden();
    $this->get(route('companies.show', $this->company))->assertForbidden();
    $this->get(route('companies.edit', $this->company))->assertForbidden();
    $this->put(route('companies.update', $this->company), [])->assertForbidden();
    $this->delete(route('companies.destroy', $this->company))->assertForbidden();
});

test('superadmins can view the companies index', function () {
    $superAdmin = User::factory()->create(['role_id' => $this->superAdminRole->id]);
    $this->actingAs($superAdmin);

    $response = $this->get(route('companies.index'));
    $response->assertOk();
    $response->assertSee($this->company->name);
});

test('superadmins can view the create company page', function () {
    $superAdmin = User::factory()->create(['role_id' => $this->superAdminRole->id]);
    $this->actingAs($superAdmin);

    $this->get(route('companies.create'))->assertOk();
});

test('superadmins can create a company', function () {
    $superAdmin = User::factory()->create(['role_id' => $this->superAdminRole->id]);
    $this->actingAs($superAdmin);

    $companyData = [
        'name' => 'Unique Company Name',
        'first_line' => '123 Main Street', 
        'second_line' => 'Suite 200',
        'town' => 'Smalltown',
        'city' => 'Big City', 
        'county' => 'Countyshire',
        'country' => 'Countryland',
        'postcode' => 'AB12 3CD',
        'phone' => '01234 567890',
        'email' => 'info@uniquecompany.com',
        'is_default' => false,
    ];

    $response = $this->post(route('companies.store'), $companyData);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas('companies', [
        'name' => 'Unique Company Name',
        'first_line' => '123 Main Street',
        'postcode' => 'AB12 3CD',
        'email' => 'info@uniquecompany.com',
        'is_default' => false,
    ]);
});

test('superadmins can view a specific company', function () {
    $superAdmin = User::factory()->create(['role_id' => $this->superAdminRole->id]);
    $this->actingAs($superAdmin);

    $response = $this->get(route('companies.show', $this->company));
    $response->assertOk();
    $response->assertSee($this->company->name);
});

test('superadmins can view the edit company page', function () {
    $superAdmin = User::factory()->create(['role_id' => $this->superAdminRole->id]);
    $this->actingAs($superAdmin);

    $this->get(route('companies.edit', $this->company))->assertOk();
});

test('superadmins can update a company', function () {
    $superAdmin = User::factory()->create(['role_id' => $this->superAdminRole->id]);
    $this->actingAs($superAdmin);

    $updatedData = [
        'name' => 'Updated Company Name',
        'first_line' => '456 New Road',
        'second_line' => null,
        'town' => 'Newtown',
        'city' => 'Newcity',
        'county' => 'Newcounty',
        'country' => 'Newcountry',
        'postcode' => 'ZY98 7YX',
        'phone' => '09876 543210',
        'email' => 'updated@company.com',
        'is_default' => true,
    ];

    $response = $this->put(route('companies.update', $this->company), $updatedData);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas('companies', [
        'id' => $this->company->id,
        'name' => 'Updated Company Name',
        'first_line' => '456 New Road',
        'postcode' => 'ZY98 7YX',
        'email' => 'updated@company.com',
        'is_default' => true,
    ]);
});

test('superadmins can delete a company', function () {
    $superAdmin = User::factory()->create(['role_id' => $this->superAdminRole->id]);
    $this->actingAs($superAdmin);

    $response = $this->delete(route('companies.destroy', $this->company));
    $response->assertRedirect();

    $this->assertSoftDeleted('companies', ['id' => $this->company->id]);
});