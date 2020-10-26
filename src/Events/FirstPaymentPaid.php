<?php

namespace Loxi5\Subscription\Events;

use Illuminate\Queue\SerializesModels;
use Loxi5\Subscription\Order\Order;

class FirstPaymentPaid
{
    use SerializesModels;

    /**
     * @var \Mollie\Api\Resources\Payment
     */
    public $payment;

    /**
     * The order created for this first payment.
     *
     * @var Order
     */
    public $order;

    public function __construct($payment, $order)
    {
        $this->payment = $payment;
        $this->order = $order;
    }
}
