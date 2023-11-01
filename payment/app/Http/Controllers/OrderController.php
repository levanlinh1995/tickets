<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaymentRequest;
use App\Models\Order;
use App\Models\Payment;

class OrderController extends Controller
{
    public function index()
    {
        return response([
            'status' => 200,
            'data' => Order::all()
        ], 200);
    }
}
