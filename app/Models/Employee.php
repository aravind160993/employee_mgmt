<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'token',
        'name',
        'profile',
        'mobile',
        'email',
        'blood_group',
        'date_of_birth',
        'address',
        'department_token',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_token', 'token');
    }
}
