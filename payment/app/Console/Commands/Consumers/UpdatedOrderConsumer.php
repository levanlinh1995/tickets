<?php

namespace App\Console\Commands\Consumers;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use App\Services\ConsumerService;

class UpdatedOrderConsumer extends Command
{
    protected $signature = "consume:updated-order";

    protected $description = "Updated Order";

    public function handle(ConsumerService $consumerService)
    {
        $consumerService->consume('updated-order', 'updated-order-group', function(KafkaConsumerMessage $message) {
            $body = $message->getBody();
            $data = json_decode($body['data']);

            $order = Order::where('order_id', $data->id)->first();
            if (!$order) {
                Log::info('Bad Request');
                return;
            }

            $order->status = $data->status;
            $order->save();

            Log::info($order->toJson());
        });
    }
}
