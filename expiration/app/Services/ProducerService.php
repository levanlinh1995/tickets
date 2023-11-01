<?php
namespace App\Services;

use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

class ProducerService
{
    public function pub(string $topic, string $message, array $configOptions = [])
    {
        $producer = Kafka::publishOn($topic)
            ->withDebugEnabled() // To enable debug mode
            ->withConfigOptions($configOptions)
            ->withBodyKey('data', $message);

        $producer->send();
    }
}
