<?php

namespace Loxi5\Subscription\Order;

abstract class BaseOrderItemPreprocessor
{
    /**
     * @param \Loxi5\Subscription\Order\OrderItemCollection $items
     * @return \Loxi5\Subscription\Order\OrderItemCollection
     */
    abstract public function handle(OrderItemCollection $items);
}
