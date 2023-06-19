<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Employee;
use Database\Factories\FakeEmployeeFactory;

class FakeEmployeeSeeder extends Seeder
{
    public function run(): void
    {
        FakeEmployeeFactory::new()->count(50)->create();
    }
}
