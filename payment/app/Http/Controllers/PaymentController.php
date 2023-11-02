<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaymentRequest;
use App\Models\Order;
use App\Models\Payment;
use App\Services\ProducerService;

class PaymentController extends Controller
{
    public function create(CreatePaymentRequest $request, ProducerService $producerService)
    {
        $data = $request->all();
        $order = Order::where('order_id', $data['order_id'])->first();

        if (!$order) {
            return response([
                'status' => 400,
                'message' => 'Bad request'
            ], 400);
        }

        // \Stripe\Stripe::setApiKey(config('stripe.stripe_key'));
    
        // \Stripe\Charge::create ([
        //         "amount" => $order->amount,
        //         "currency" => "usd",
        //         "source" => $data['stripe_token'],
        //         "description" => "Test payment" 
        // ]);

        $payment = Payment::create([
            'order_id' => $data['order_id'],
            'stripe_id' => '354333445345'
        ]);

        $producerService->pub('created-payment', $payment->toJson());

        return response([
            'status' => 201,
            'message' => 'created successfully.',
            'data' => $payment
        ], 201);
    }
}
