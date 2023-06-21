<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
// use DataTables;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('department')->get();

        return EmployeeResource::collection($employees);
    }

    public function getEmployeesData(Request $request)
    {
        $query = Employee::query();

        // Apply filtering based on request input
        if ($request->filled('dept_token')) {
            $query->where('department_token', $request->input('dept_token'));
        }

        // Apply pagination based on request input
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 12);
        $offset = ($page - 1) * $limit;

        $total = $query->count();
        $employees = $query->offset($offset)->limit($limit)->get();

        return EmployeeResource::collection($employees)
            ->additional(['meta' => [
                'total' => $total,
                'page' => $page,
                'limit' => $limit,
            ]]);
    }

    // public function getEmployeesData()
    // {
    //     $employees = Employee::query();

    //     return DataTables::of($employees)->toJson();
    // }

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
