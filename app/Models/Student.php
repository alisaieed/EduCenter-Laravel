<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    // Define the fillable fields
    protected $fillable = ['name', 'email', 'dob', 'address', 'phone_number']; // Add fields you want to be mass-assignable
    
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
}