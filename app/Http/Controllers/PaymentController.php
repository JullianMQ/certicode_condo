<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // List all payments
    public function index()
    {
        return response()->json(Payment::all(), 200);
    }

    // Show single payment
    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return response()->json($payment, 200);
    }

    // Store new payment
    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_id'     => 'required|string|unique:payments,payment_id',
            'user_id'        => 'required|string',
            'unit_id'        => 'required|string',
            'payment_type'   => 'required|string',
            'amount_php'     => 'required|numeric',
            'due_date'       => 'required|date',
            'status'         => 'required|in:Pending,Paid,Overdue',
            'paid_at'        => 'nullable|date',
            'receipt_number' => 'nullable|string',
        ]);

        $payment = Payment::create($validated);
        return response()->json($payment, 201);
    }

    // Update payment
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $validated = $request->validate([
            'user_id'        => 'string',
            'unit_id'        => 'string',
            'payment_type'   => 'string',
            'amount_php'     => 'numeric',
            'due_date'       => 'date',
            'status'         => 'in:Pending,Paid,Overdue',
            'paid_at'        => 'nullable|date',
            'receipt_number' => 'nullable|string',
        ]);

        $payment->update($validated);
        return response()->json($payment, 200);
    }

    // Delete payment
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return response()->json(['message' => 'Payment deleted'], 200);
    }
}
