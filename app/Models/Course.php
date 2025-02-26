<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'department_id', 'start_date', 'end_date', 'certificate_id'];

    // Relationship with instructors
    public function instructors()
    {
        return $this->belongsToMany(Instructor::class);
    }

    // Relationship with department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Relationship with students
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    // Relationship with certificate
    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }
}
