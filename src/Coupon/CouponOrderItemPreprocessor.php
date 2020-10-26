<?php

namespace Loxi5\Subscription\Coupon;

use Loxi5\Subscription\Order\BaseOrderItemPreprocessor;
use Loxi5\Subscription\Order\OrderItem;
use Loxi5\Subscription\Order\OrderItemCollection;

class CouponOrderItemPreprocessor extends BaseOrderItemPreprocessor
{
    /**
     * @param \Loxi5\Subscription\Order\OrderItemCollection $items
     * @return \Loxi5\Subscription\Order\OrderItemCollection
     */
    public function handle(OrderItemCollection $items)
    {
        $result = new OrderItemCollection;

        $items->each(function (OrderItem $item) use (&$result) {
            if($item->orderableIsSet()) {
                $coupons = $this->getActiveCoupons($item->orderable_type, $item->orderable_id);
                $result = $result->concat($coupons->applyTo($item));
            } else {
                $result->push($item);
            }
        });

        return $result;
    }

    /**
     * @param $modelType
     * @param $modelId
     * @return mixed
     */
    protected function getActiveCoupons($modelType, $modelId)
    {
        return RedeemedCoupon::whereModel($modelType, $modelId)->active()->get();
    }
}
