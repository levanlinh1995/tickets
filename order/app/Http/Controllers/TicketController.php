<?php

namespace App\Http\Controllers;
use App\Http\Requests\Ticket\CreateTicketRequest;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function create(CreateTicketRequest $request)
    {
        $data = $request->all();

        $ticket = Ticket::create([
            'name' => $data['name'],
            'price' => $data['price'],
        ]);

        return response([
            'status' => 201,
            'message' => 'created successfully.',
            'data' => $ticket
        ], 201);
    }
}
