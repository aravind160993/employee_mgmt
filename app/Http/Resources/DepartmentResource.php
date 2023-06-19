<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'token' => $this->token,
            'name' => $this->name,
            'employees_count' => $this->employees_count,
            'created_at' => $this->created_at->format('d M, Y'),
            'updated_at' => $this->updated_at->format('d M, Y'),
        ];
    }
}
