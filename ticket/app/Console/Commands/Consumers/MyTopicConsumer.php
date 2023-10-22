<?php

namespace App\Console\Commands\Consumers;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use App\Services\ConsumerService;

class MyTopicConsumer extends Command
{
    protected $signature = "consume:my-topic";

    protected $description = "Consume Kafka messages from 'my-topic'.";

    public function handle(ConsumerService $consumerService)
    {

        $consumerService->consume('linh1', 'linh-group1', function(KafkaConsumerMessage $message) {
            $body = $message->getBody();
            $data = $body['data'];

            Log::info($data);
        });
    }
}
