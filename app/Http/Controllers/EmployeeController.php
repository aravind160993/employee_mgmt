<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('department')->get();

        return EmployeeResource::collection($employees);
    }

    public function store(EmployeeRequest $request)
    {
        $token = Str::random(10);
        while (Employee::where('token', $token)->exists()) $token = Str::random(10);

        $employee = Employee::create([
            'token' => $token,
            'name' => $request->input('name'),
            'profile' => $request->input('profile'),
            'mobile' => $request->input('mobile'),
            'email' => $request->input('email'),
            'blood_group' => $request->input('blood_group'),
            'date_of_birth' => $request->input('date_of_birth'),
            'address' => $request->input('address'),
            'department_token' => $request->input('department_token'),
        ]);

        return new EmployeeResource($employee);
    }

    public function show($token)
    {
        $employee = Employee::with('department')->where('token', $token)->first();

        if ($employee) {
            return new EmployeeResource($employee);
        } else {
            return response()->json(['message' => 'Employee not found'], 404);
        }
    }

    public function update(EmployeeRequest $request, $token)
    {
        $employee = Employee::where('token', $token)->first();

        if ($employee) {
            $employee->update([
                'name' => $request->input('name'),
                'profile' => $request->input('profile'),
                'mobile' => $request->input('mobile'),
                'email' => $request->input('email'),
                'blood_group' => $request->input('blood_group'),
                'date_of_birth' => $request->input('date_of_birth'),
                'address' => $request->input('address'),
                'department_token' => $request->input('department_token'),
            ]);

            return new EmployeeResource($employee);
        } else {
            return response()->json(['message' => 'Employee not found'], 404);
        }
    }

    public function destroy($token)
    {
        $employee = Employee::where('token', $token)->first();

        if ($employee) {
            $employee->delete();

            return response()->json(null, 204);
        } else {
            return response()->json(['message' => 'Employee not found'], 404);
        }
    }
}
