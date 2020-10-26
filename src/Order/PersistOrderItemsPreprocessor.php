<?php

namespace Loxi5\Subscription\Order;

class PersistOrderItemsPreprocessor extends BaseOrderItemPreprocessor
{
    /**
     * @param \Loxi5\Subscription\Order\OrderItemCollection $items
     * @return \Loxi5\Subscription\Order\OrderItemCollection
     */
    public function handle(OrderItemCollection $items)
    {
        return $items->save();
    }
}
