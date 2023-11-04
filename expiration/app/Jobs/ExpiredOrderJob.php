<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\ProducerService;
use Illuminate\Support\Facades\Log;

class ExpiredOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct(private int $orderId)
    {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ProducerService $producerService)
    {
        $producerService->pub('expired-order', $this->orderId);
        Log::info('test: ' . $this->orderId);
    }
}
