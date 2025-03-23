<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    // Add the fields you want to mass-assign here
    protected $fillable = [
        'name',
        'email',
        'phone',
        'specialization',
        'departments',
    ];

    // Define the relationship with courses
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    // Define the relationship with the department
    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

}
