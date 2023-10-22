<?php

namespace App\Console\Commands\Consumers;

use App\Models\Ticket;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use App\Services\ConsumerService;

class CreatedTicketConsumer extends Command
{
    protected $signature = "consume:created-ticket";

    protected $description = "Created Ticket";

    public function handle(ConsumerService $consumerService)
    {
        $consumerService->consume('created-ticket', 'created-ticket-group', function(KafkaConsumerMessage $message) {
            $body = $message->getBody();
            $data = json_decode($body['data']);

            $ticket = Ticket::create([
                'ticket_id' => $data->id,
                'name' => $data->name,
                'price' => $data->price,
                'status' => $data->status,
                'version' => $data->version
            ]);

            Log::info($ticket->toJson());
        });
    }
}
