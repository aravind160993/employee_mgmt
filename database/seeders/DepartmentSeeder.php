<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Department;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    protected $output;

    public function run(): void
    {
        $departmentNames = ['Management','Operation','Design'];

        foreach ($departmentNames as $name) {
            $token = Str::random(10);
            while (Department::where('token', $token)->exists()) {
                $token = Str::random(10);
            }

            $existingDepartment = Department::where('name', $name)->orWhere('token', $token)->first();

            if (!$existingDepartment) {
                Department::create([
                    'name' => $name,
                    'token' => $token,
                ]);
            } else {
                $this->command->warn('Department with name "' . $name . '" or token "' . $token . '" already exists. Skipping...');
            }
        }
    }
}