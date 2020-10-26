<?php

namespace Loxi5\Subscription\Events;

use Illuminate\Queue\SerializesModels;
use Loxi5\Subscription\Coupon\AppliedCoupon;
use Loxi5\Subscription\Coupon\RedeemedCoupon;

class CouponApplied
{
    use SerializesModels;

    /**
     * @var \Loxi5\Subscription\Coupon\RedeemedCoupon
     */
    public $redeemedCoupon;

    /**
     * @var \Loxi5\Subscription\Coupon\AppliedCoupon
     */
    public $appliedCoupon;

    public function __construct(RedeemedCoupon $redeemedCoupon, AppliedCoupon $appliedCoupon)
    {
        $this->redeemedCoupon = $redeemedCoupon;
        $this->appliedCoupon = $appliedCoupon;
    }
}
