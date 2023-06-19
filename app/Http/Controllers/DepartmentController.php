<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Http\Requests\DepartmentRequest;
use App\Http\Resources\DepartmentResource;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('employees')->get();
        // $departments = Department::all();

        return DepartmentResource::collection($departments);
    }

    public function store(DepartmentRequest $request)
    {
        $token = Str::random(10);
        while (Department::where('token', $token)->exists()) $token = Str::random(10);

        $department = Department::create([
            'token' => $token,
            'name' => $request->input('name'),
        ]);
        $department->employees_count = 0;

        return new DepartmentResource($department);
    }

    public function show($token)
    {
        $department = Department::withCount('employees')->where('token', $token)->first();

        if ($department) {
            return new DepartmentResource($department);
        } else {
            return response()->json(['message' => 'Department not found'], 404);
        }
    }

    public function update(DepartmentRequest $request, $token)
    {
        $department = Department::withCount('employees')->where('token', $token)->first();

        if ($department) {
            $department->update([
                'name' => $request->input('name'),
            ]);

            return new DepartmentResource($department);
        } else {
            return response()->json(['message' => 'Department not found'], 404);
        }
    }

    public function destroy($token)
    {
        $department = Department::where('token', $token)->first();

        if ($department) {
            $department->delete();

            return response()->json(null, 204);
        } else {
            return response()->json(['message' => 'Department not found'], 404);
        }
    }
}
