<?php

namespace App\Repositories;

use App\Models\JobTitle;

class JobTitleRepository
{
    public function __construct()
    {
        //
    }

    public function getAll() {
        return JobTitle::all();
    }

    public function find($id) {
        return JobTitle::findOrFail($id);
    }

    public function create(array $data) {
        return JobTitle::create($data);
    }

    public function update(JobTitle $jobTitle, array $data) {
        $jobTitle->update($data);
        return $jobTitle;
    }

    public function delete(JobTitle $jobTitle) {
        return $jobTitle->delete();
    }
}
