<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use App\Enums\TicketStatusEnum;

class TicketController extends Controller
{
    public function testNat()
    {
        $opts = new \NatsStreaming\ConnectionOptions([
            'natsOptions' => new \Nats\ConnectionOptions([
                'user' => 'nats',
                'pass' => 'nats',
                'token' => '12345678',
            ])
        ]);

        $opts->setClientID("test");
        $opts->setClusterID("test-cluster");
        
        $c = new \NatsStreaming\Connection($opts);

        $c->connect();

        // Publish
        $r = $c->publish('special.subject', 'some serialized payload...');

        // optionally wait for the ack
        $gotAck = $r->wait();
        if (!$gotAck) {
            
        }

        $c->close();
    }

    public function create(CreateTicketRequest $request)
    {
        $data = $request->all();

        $ticket = Ticket::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'status' => TicketStatusEnum::ACTIVE->value
        ]);

        return response([
            'status' => 201,
            'message' => 'created successfully.',
            'data'=> $ticket,
        ], 201);
    }

    public function update(Ticket $ticket, UpdateTicketRequest $request)
    {
        $data = $request->all();

        $ticket->update([
            'name' => $data['name'],
            'price' => $data['price'],
        ]);

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
