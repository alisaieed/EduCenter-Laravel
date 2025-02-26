<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    protected $fillable = ['name', 'description', 'instructors', 'head_instructor_id' ];
    // Define the relationship with Instructor
    public function headInstructor()
    {
        return $this->belongsTo(Instructor::class, 'head_instructor_id');
    }

    // Relationship to fetch all instructors in this department
    public function instructors()
    {
        return $this->belongsToMany(Instructor::class);
    }

    // Define the relationship with Course
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    
}
