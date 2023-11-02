<?php
namespace App\Services;

use Junges\Kafka\Facades\Kafka;

class ConsumerService 
{
    public function consume(string $topic, string $groupId, callable $handler)
    {
        $consumer = Kafka::createConsumer()
            ->subscribe($topic)
            ->withConsumerGroupId($groupId)
            ->withOptions([
                'allow.auto.create.topics' => true
            ])
            ->withAutoCommit()
            ->withHandler($handler)
            ->build();

        $consumer->consume();
    }
}
