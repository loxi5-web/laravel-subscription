<?php

namespace Loxi5\Subscription\Coupon;

use Illuminate\Database\Eloquent\Collection;
use Loxi5\Subscription\Order\OrderItem;
use Loxi5\Subscription\Order\OrderItemCollection;

class RedeemedCouponCollection extends Collection
{
    public function applyTo(OrderItem $item)
    {
        return $this->reduce(
            function(OrderItemCollection $carry, RedeemedCoupon $coupon) {
                return $coupon->applyTo($carry);
            },
            $item->toCollection()
        );
    }
}
