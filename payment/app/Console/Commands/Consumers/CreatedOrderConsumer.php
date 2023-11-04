<?php

namespace App\Console\Commands\Consumers;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use App\Services\ConsumerService;

class CreatedOrderConsumer extends Command
{
    protected $signature = "consume:created-order";

    protected $description = "Created Order";

    public function handle(ConsumerService $consumerService)
    {
        $consumerService->consume('created-order', 'created-order-group-payment', function(KafkaConsumerMessage $message) {
            $body = $message->getBody();
            $data = json_decode($body['data']);

            $order = Order::create([
                'order_id' => $data->id,
                'amount' => $data->amount,
                'status' => $data->status,
            ]);

            Log::info($order->toJson());
        });
    }
}
