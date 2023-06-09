<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('department')->get();

        $formattedEmployees = $employees->map(function ($employee) {
            return $this->formatData($employee);
        });

        return response()->json($formattedEmployees);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'department_id' => 'required|exists:departments,id',
            'name' => 'required',
            'mobile' => [
                'required',
                'numeric',
                'digits:10',
                Rule::unique('employees'),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('employees'),
            ],
            'date_of_birth' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $employee = Employee::create([
            'department_id' => $request->input('department_id'),
            'name' => $request->input('name'),
            'profile' => $request->input('profile'),
            'mobile' => $request->input('mobile'),
            'email' => $request->input('email'),
            'blood_group' => $request->input('blood_group'),
            'date_of_birth' => $request->input('date_of_birth'),
            'address' => $request->input('address'),
        ]);

        $formattedEmployee = $this->formatData($employee);

        return response()->json($formattedEmployee, 201);
    }

    public function show($id)
    {
        $employee = Employee::with('department')->findOrFail($id);

        $formattedEmployee = $this->formatData($employee);

        return response()->json($formattedEmployee);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        $formattedEmployee = $this->formatData($employee);

        return response()->json($formattedEmployee);
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return response()->json(null, 204);
    }

    public function formatData($employee)
    {
        return [
            'id' => $employee->id,
            'department_id' => $employee->department_id,
            'department_name' => $employee->department->name,
            'name' => $employee->name,
            'profile' => $employee->profile,
            'mobile' => $employee->mobile,
            'email' => $employee->email,
            'blood_group' => $employee->blood_group,
            'date_of_birth' => $employee->date_of_birth,
            'address' => $employee->address,
            'department_id' => $employee->department_id,
            'created_at' => $employee->created_at->format('d M, Y'),
            // 'updated_at' => $department->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
