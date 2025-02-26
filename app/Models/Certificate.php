<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    // Define the relationship with Student
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}