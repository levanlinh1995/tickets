<?php

namespace App\Console\Commands\Consumers;

use App\Enums\TicketStatusEnum;
use App\Models\Ticket;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use App\Services\ConsumerService;
use App\Services\ProducerService;

class CompletedOrderConsumer extends Command
{
    protected $signature = "consume:completed-order";

    protected $description = "Completed Order";

    protected $producerService;

    public function handle(ConsumerService $consumerService, ProducerService $producerService)
    {
        $this->producerService = $producerService;

        $consumerService->consume('completed-order', 'completed-order-group', function(KafkaConsumerMessage $message) {
            $body = $message->getBody();
            $data = json_decode($body['data']);

            $ticket = Ticket::find($data->ticket_id);
            if (!$ticket) {
                Log::info('Bad request.');
                return;
            }

            $ticket->status = TicketStatusEnum::ACTIVE->value;
            $ticket->save();

            $this->producerService->pub('updated-ticket', $ticket->toJson());

            Log::info($ticket->toJson());
        });
    }
}
