<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use App\Enums\TicketStatusEnum;
use App\Services\ProducerService;

class TicketController extends Controller
{
    public function create(CreateTicketRequest $request, ProducerService $producerService)
    {
        $data = $request->all();

        $ticket = Ticket::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'status' => TicketStatusEnum::ACTIVE->value,
            'version' => 1,
        ]);
        
        $producerService->pub('created-ticket', $ticket->toJson());

        return response([
            'status' => 201,
            'message' => 'created successfully.',
            'data'=> $ticket,
        ], 201);
    }

    public function update(Ticket $ticket, UpdateTicketRequest $request,  ProducerService $producerService)
    {
        $data = $request->all();

        $ticket->update([
            'name' => $data['name'],
            'price' => $data['price'],
            'version' => $ticket->version + 1,
        ]);

        $producerService->pub('updated-ticket', $ticket->toJson());

        return response([
            'status' => 200,
            'message' => 'updated successfully.',
            'data'=> $ticket,
        ], 200);
    }

    public function delete(Ticket $ticket)
    {
        $ticket->delete();

        return response([
            'status' => 200,
            'message' => 'deleted successfully.',
        ], 200);
    }
}
