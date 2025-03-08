<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    // Define the fillable fields
    protected $fillable = ['name', 'email', 'dob', 'address', 'phone_number', 'total_course_cost', 'amount_paid' ]; // Add fields you want to be mass-assignable
    protected $appends = ['remaining_balance'];

        public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Total amount paid by student
    public function getTotalPaidAttribute()
    {
        return $this->payments()->sum('amount');
    }



    public function updateTotalCourseCost() {
        $this->total_course_cost = $this->courses->sum('cost');
        $this->save();
    }
    

    // public function getRemainingBalanceAttribute() {
    //     return $this->total_course_cost - $this->amount_paid;
    // }
    
    public function getRemainingBalanceAttribute()
    {
        $totalPaid = $this->payments()->sum('amount');  // Sum of all payments (including refunds)
        $totalFees = $this->courses()->sum('cost');      // Total course fees

        return $totalFees - $totalPaid;  // Remaining balance
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
}