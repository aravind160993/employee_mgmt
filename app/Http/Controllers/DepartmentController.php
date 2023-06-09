<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();

        $formattedDepartments = $departments->map(function ($department) {
            return $this->formatData($department);
        });

        return response()->json($formattedDepartments);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'alpha',
                Rule::unique('departments'),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $department = Department::create([
            'name' => $request->input('name'),
        ]);

        $formattedDepartments = $this->formatData($department);

        return response()->json($formattedDepartments, 201);
    }

    public function show($id)
    {
        $department = Department::findOrFail($id);

        $formattedDepartments = $this->formatData($department);

        return response()->json($formattedDepartments);
    }

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'alpha',
                Rule::unique('departments')->ignore($id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $department->update([
            'name' => $request->input('name'),
        ]);

        $formattedDepartments = $this->formatData($department);

        return response()->json($formattedDepartments);
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return response()->json(null, 204);
    }

    public function formatData($department)
    {
        return [
            'id' => $department->id,
            'name' => $department->name,
            'created_at' => $department->created_at->format('d M, Y'),
            // 'updated_at' => $department->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
