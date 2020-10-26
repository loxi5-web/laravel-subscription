<?php

namespace Loxi5\Subscription\FirstPayment\Actions;

use Illuminate\Database\Eloquent\Model;
use Loxi5\Subscription\Coupon\Coupon;
use Loxi5\Subscription\Order\OrderItemCollection;

class ApplySubscriptionCouponToPayment extends BaseNullAction
{
    /**
     * @var \Loxi5\Subscription\Coupon\Coupon
     */
    protected $coupon;

    /**
     * The coupon's (discount) OrderItems
     * @var \Loxi5\Subscription\Order\OrderItemCollection
     */
    protected $orderItems;

    /**
     * ApplySubscriptionCouponToPayment constructor.
     *
     * @param \Illuminate\Database\Eloquent\Model $owner
     * @param \Loxi5\Subscription\Coupon\Coupon $coupon
     * @param \Loxi5\Subscription\Order\OrderItemCollection $orderItems
     */
    public function __construct(Model $owner, Coupon $coupon, OrderItemCollection $orderItems)
    {
        $this->owner = $owner;
        $this->coupon = $coupon;
        $this->orderItems = $this->coupon->handler()->getDiscountOrderItems($orderItems);
    }

    /**
     * @return \Money\Money
     */
    public function getSubtotal()
    {
        return $this->toMoney($this->orderItems->sum('subtotal'));
    }

    /**
     * @return \Money\Money
     */
    public function getTax()
    {
        return $this->toMoney($this->orderItems->sum('tax'));
    }

    /**
     * @param int $value
     * @return \Money\Money
     */
    protected function toMoney($value = 0)
    {
        return money($value, $this->getCurrency());
    }
}
