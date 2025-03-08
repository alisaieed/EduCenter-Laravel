<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Student;

class PaymentController extends Controller {
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
        ]);
    
        
        $payment = new Payment();
        $payment->student_id = $request->student_id;
        $payment->amount = $request->amount;
        $payment->payment_date = $request->payment_date ?? now();
        $payment->save();
    
        // Update the student's paid amount
        $student = Student::find($request->student_id);
        $student->amount_paid = $student->payments()->sum('amount');
        $student->save();

                // Refresh the student instance to ensure the latest payments are loaded
        $student->refresh();

        // $remainingBalance = $student->getRemainingBalanceAttribute();
    
        return redirect()->back()->with('success', 'Payment recorded successfully!');
    }

    public function refund(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $student = Student::findOrFail($id);

        // Ensure the refund does not exceed total paid amount
        $totalPaid = $student->payments()->sum('amount');
        $totalRefunded = $student->payments()->where('amount', '<', 0)->sum('amount');

        $refundAmount = $request->input('amount');

        if (($totalRefunded + $refundAmount) > $totalPaid) {
            return redirect()->back()->with('error', 'Refund amount cannot exceed total payments.');
        }

        // Create the refund transaction
        Payment::create([
            'student_id' => $student->id,
            'amount' => -$refundAmount, // Negative to indicate refund
            'payment_date' => now(),
            'description' => 'Refund processed',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Refresh the student instance to ensure the latest payments are loaded
        $student->refresh();

        // $remainingBalance = $student->getRemainingBalanceAttribute();

        return redirect()->back()->with([
            'success' => 'Refund processed successfully.',
            // 'remaining_balance' => $remainingBalance
        ]);
    }

        

    
}
