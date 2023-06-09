<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'name',
        'profile',
        'mobile',
        'email',
        'blood_group',
        'date_of_birth',
        'address',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
