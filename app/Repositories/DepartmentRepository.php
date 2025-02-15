<?php

namespace App\Repositories;

use App\Models\Department;

class DepartmentRepository
{
    public function __construct()
    {
        //
    }
    
    public function getAll() {
        return Department::with('lead')->get();
    }

    public function find($id) {
        return Department::findOrFail($id);
    }

    public function create(array $data) {
        return Department::create($data);
    }

    public function update(Department $department, array $data) {
        $department->update($data);
        return $department;
    }

    public function delete(Department $department) {
        return $department->delete();
    }
}
