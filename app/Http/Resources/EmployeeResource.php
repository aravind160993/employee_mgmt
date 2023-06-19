<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'token' => $this->token,
            'name' => $this->name,
            'profile' => $this->profile,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'blood_group' => $this->blood_group,
            'date_of_birth' => $this->date_of_birth,
            'address' => $this->address,
            'department_token' => $this->department_token,
            'department_name' => $this->department->name,
            // 'department' => $this->department,
            'created_at' => $this->created_at->format('d M, Y'),
            'updated_at' => $this->updated_at->format('d M, Y'),
        ];
    }
}
