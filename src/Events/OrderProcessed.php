<?php

namespace Loxi5\Subscription\Events;

use Illuminate\Queue\SerializesModels;
use Loxi5\Subscription\Order\Order;

class OrderProcessed
{
    use SerializesModels;

    /**
     * The processed order.
     *
     * @var Order
     */
    public $order;

    /**
     * OrderProcessed constructor.
     *
     * @param \Loxi5\Subscription\Order\Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
