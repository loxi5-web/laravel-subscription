<?php

namespace Loxi5\Subscription\Events;

use Illuminate\Queue\SerializesModels;

class OrderInvoiceAvailable
{
    use SerializesModels;

    /**
     * The created order.
     *
     * @var \Loxi5\Subscription\Order\Order
     */
    public $order;

    /**
     * Creates a new OrderInvoiceAvailable event.
     *
     * @param $order
     */
    public function __construct($order)
    {
        $this->order = $order;
    }
}
