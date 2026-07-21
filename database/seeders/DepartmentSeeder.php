<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create([
            'name' => 'Computer Science',
            'code' => 'CS',
            'description' => 'Computer Science Department',
        ]);
        Department::create([
            'name' => 'Information Technology',
            'code' => 'IT',
            'description' => 'Information Technology Department',
        ]);
        Department::create([
            'name' => 'Software Engineering',
            'code' => 'SE',
            'description' => 'Software Engineering Department',
        ]);
        Department::create([
            'name' => 'Computer Engineering',
            'code' => 'CE',
            'description' => 'Computer Engineering Department',
        ]);
        Department::create([
            'name' => 'Information Systems',
            'code' => 'IS',
            'description' => 'Information Systems Department',
        ]);
    }
}
