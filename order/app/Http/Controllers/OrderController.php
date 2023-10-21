<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\CreateOrderRequest;
use App\Models\Order;
use App\Models\Ticket;
use App\Enums\OrderStatusEnum;

class OrderController extends Controller
{
    public function create(CreateOrderRequest $request)
    {
        $data = $request->all();

        $ticket = Ticket::find($data['ticket_id']);
        if (!$ticket) {
            return response([
                'status' => 400,
                'message' => 'Bad request'
            ], 400);
        }

        $order = Order::create([
            'ticket_id' => $data['ticket_id'],
            'amount' => $data['amount'],
            'status' => OrderStatusEnum::PROCESSING->value,
        ]);

        return response([
            'status' => 201,
            'message' => 'created successfully.',
            'data' => $order
        ], 201);
    }
}
