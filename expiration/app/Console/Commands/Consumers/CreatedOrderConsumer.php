<?php

namespace App\Console\Commands\Consumers;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use App\Services\ConsumerService;
use App\Jobs\ExpiredOrderJob;

class CreatedOrderConsumer extends Command
{
    protected $signature = "consume:created-order";

    protected $description = "Created Order";

    public function handle(ConsumerService $consumerService)
    {
        $consumerService->consume('created-order', 'created-order-group-expiration', function(KafkaConsumerMessage $message) {
            $body = $message->getBody();
            $data = json_decode($body['data']);

            $orderId = $data->id;

            ExpiredOrderJob::dispatch($orderId)->delay(60);

            Log::info('job executed: orderId = ' . $orderId);
        });
    }
}
