<?php

namespace Loxi5\Subscription\Coupon\Contracts;

use Loxi5\Subscription\Coupon\Coupon;
use Loxi5\Subscription\Exceptions\CouponNotFoundException;

interface CouponRepository
{
    /**
     * @param string $coupon
     * @return Coupon|null
     */
    public function find(string $coupon);

    /**
     * @param string $coupon
     * @return Coupon
     *
     * @throws CouponNotFoundException
     */
    public function findOrFail(string $coupon);
}
