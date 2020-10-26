<?php

namespace Loxi5\Subscription\Order\Contracts;

use Loxi5\Subscription\Order\OrderItem;

interface PreprocessesOrderItems
{
    /**
     * Called right before processing the order item into an order.
     *
     * @param OrderItem $item
     * @return \Loxi5\Subscription\Order\OrderItemCollection
     */
    public static function preprocessOrderItem(OrderItem $item);
}
