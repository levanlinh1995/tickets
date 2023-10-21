<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaymentRequest;
use App\Models\Order;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function create(CreatePaymentRequest $request)
    {
        $data = $request->all();

        $order = Order::where('order_id', $data['order_id'])->first();

        if (!$order) {
            return response([
                'status' => 400,
                'message' => 'Bad request'
            ], 400);
        }

        $payment = Payment::create([
            'order_id' => $data['order_id'],
            'stripe_id' => $data['stripe_id']
        ]);

        return response([
            'status' => 201,
            'message' => 'created successfully.',
            'data' => $payment
        ], 201);
    }
}
