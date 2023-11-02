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
            ->withConfigOptions(array_merge($configOptions, ['allow.auto.create.topics' => true]))
            ->withBodyKey('data', $message);

        $producer->send();
    }
}
