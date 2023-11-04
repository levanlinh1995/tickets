<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\CreateOrderRequest;
use App\Models\Order;
use App\Models\Ticket;
use App\Enums\OrderStatusEnum;
use App\Services\ProducerService;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function create(CreateOrderRequest $request, ProducerService $producerService)
    {
        $data = $request->all();

        $ticket = Ticket::where('ticket_id', $data['ticket_id'])->first();
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
            'expired_at' => Carbon::now()->addMinutes(1)
        ]);

        $producerService->pub('created-order', $order->toJson());

        return response([
            'status' => 201,
            'message' => 'created successfully.',
            'data' => $order
        ], 201);
    }
}
