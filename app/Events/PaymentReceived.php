<?php

namespace App\Events;

use App\Entities\Payment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class PaymentReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * Payment eloquent model.
     *
     * @var Payment
     */
    public $payment;

    /**
     * Create a new event instance.
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }
}
