<?php
declare(strict_types=1);

namespace Loxi5\Subscription\Mollie\Contracts;

use Mollie\Api\Resources\Payment;

interface UpdateMolliePayment
{
    public function execute(Payment $dirtyPayment): Payment;
}
