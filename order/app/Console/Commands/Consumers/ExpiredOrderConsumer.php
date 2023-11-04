<?php

namespace App\Console\Commands\Consumers;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use App\Services\ConsumerService;
use App\Services\ProducerService;

class ExpiredOrderConsumer extends Command
{   
    private $producerService;

    protected $signature = "consume:expired-order";

    protected $description = "expired order";

    public function handle(ConsumerService $consumerService, ProducerService $producerService)
    {
        $this->producerService = $producerService;

        $consumerService->consume('expired-order', 'expired-order-group', function(KafkaConsumerMessage $message) {
            $body = $message->getBody();
            $data = json_decode($body['data']);

            $orderId = (int) $data;

            $order = Order::find($orderId);
            if (!$order) {
                Log::info('Bad request.');
                return;
            }

            if ($order->status === OrderStatusEnum::PROCESSING->value) {
                $order->status = OrderStatusEnum::CANCELED->value;

                $this->producerService->pub('updated-order', $order->toJson());
                $this->producerService->pub('completed-order', $order->toJson());

                Log::info($order->toJson());
            }
        });
    }
}
