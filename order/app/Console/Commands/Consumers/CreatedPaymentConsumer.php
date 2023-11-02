<?php

namespace App\Console\Commands\Consumers;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use App\Services\ConsumerService;
use App\Enums\OrderStatusEnum;
use App\Services\ProducerService;

class CreatedPaymentConsumer extends Command
{
    protected $signature = "consume:created-payment";

    protected $description = "Created Payment";

    protected $producerService;

    public function handle(ConsumerService $consumerService, ProducerService $producerService)
    {
        $this->producerService = $producerService;

        $consumerService->consume('created-payment', 'created-payment-group', function(KafkaConsumerMessage $message) {
            $body = $message->getBody();
            $data = json_decode($body['data']);

            $order = Order::find($data->order_id);
            if (!$order) {
                Log::info('Bad request.');
                return;
            }

            $order->status = OrderStatusEnum::COMPLETED->value;

            $this->producerService->pub('updated-order', $order->toJson());
            $this->producerService->pub('completed-order', $order->toJson());

            Log::info($order->toJson());
        });
    }
}
