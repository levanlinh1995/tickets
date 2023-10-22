<?php

namespace App\Console\Commands\Consumers;

use App\Models\Ticket;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use App\Services\ConsumerService;

class UpdatedTicketConsumer extends Command
{
    protected $signature = "consume:updated-ticket";

    protected $description = "Updated Ticket";

    public function handle(ConsumerService $consumerService)
    {
        $consumerService->consume('updated-ticket', 'updated-ticket-group', function(KafkaConsumerMessage $message) {
            $body = $message->getBody();
            $data = json_decode($body['data']);

            $ticketId = $data->id;

            $ticket = Ticket::find($ticketId);

            if (!$ticket) {
                Log::error('Bad request: Ticket id not found ' . $ticketId);
            } else {
                if ($data->version - 1 === $ticket->version) {
                    $ticket = $ticket->update([
                        'name' => $data->name,
                        'price' => $data->price,
                        'status' => $data->status,
                        'version' => $data->version
                    ]);
        
                    Log::info($ticket->toJson());
                } else {
                    Log::error('Please wait in the order of queue');
                }
            }
        });
    }
}
