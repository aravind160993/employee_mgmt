<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Department;
use App\Models\Employee;

use Faker\Factory as Faker;
use Faker\Provider\Image as ImageProvider;

class FakeEmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        // Get random employee token
        $token = Str::random(10);
        while (Employee::where('token', $token)->exists()) $token = Str::random(10);

        // Get random department token
        $departmentToken = Department::pluck('token')->random();

        $faker = Faker::create();
        $faker->addProvider(new ImageProvider($faker));

        return [
            'token' => $token,
            'name' => $faker->name,
            'profile' => $faker->imageUrl(200, 200, 'people'),
            'mobile' => $faker->phoneNumber,
            'email' => $faker->unique()->safeEmail,
            'blood_group' => $faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'date_of_birth' => $faker->dateTimeBetween('-40 years', '-20 years')->format('Y-m-d'),
            'address' => $faker->address,
            'department_token' => $departmentToken,
        ];
    }
}
