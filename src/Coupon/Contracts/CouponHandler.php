<?php

namespace Loxi5\Subscription\Coupon\Contracts;

use Loxi5\Subscription\Coupon\Coupon;
use Loxi5\Subscription\Coupon\RedeemedCoupon;
use Loxi5\Subscription\Exceptions\CouponException;
use Loxi5\Subscription\Order\OrderItemCollection;

interface CouponHandler
{
    /**
     * @param array $context
     * @return \Loxi5\Subscription\Coupon\Contracts\CouponHandler
     */
    public function withContext(array $context);

    /**
     * @param \Loxi5\Subscription\Coupon\Coupon $coupon
     * @param \Loxi5\Subscription\Coupon\Contracts\AcceptsCoupons $model
     * @return bool
     * @throws \Throwable|CouponException
     */
    public function validate(Coupon $coupon, AcceptsCoupons $model);

    /**
     * Apply the coupon to the OrderItemCollection
     *
     * @param \Loxi5\Subscription\Coupon\RedeemedCoupon $redeemedCoupon
     * @param \Loxi5\Subscription\Order\OrderItemCollection $items
     * @return \Loxi5\Subscription\Order\OrderItemCollection
     */
    public function handle(RedeemedCoupon $redeemedCoupon, OrderItemCollection $items);

    /**
     * @param \Loxi5\Subscription\Order\OrderItemCollection $items
     * @return \Loxi5\Subscription\Order\OrderItemCollection
     */
    public function getDiscountOrderItems(OrderItemCollection $items);
}
