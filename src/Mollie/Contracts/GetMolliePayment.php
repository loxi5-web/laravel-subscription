<?php
declare(strict_types=1);

namespace Loxi5\Subscription\Mollie\Contracts;

use Mollie\Api\Resources\Payment;

interface GetMolliePayment
{
    public function execute(string $id): Payment;
}
