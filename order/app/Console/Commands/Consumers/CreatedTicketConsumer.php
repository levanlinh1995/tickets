<?php

namespace App\Console\Commands\Consumers;

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
            $data = $body['data'];

            // todo




            Log::info($data);
        });
    }
}
