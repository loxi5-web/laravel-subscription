<?php
declare(strict_types=1);

namespace Loxi5\Subscription\Mollie\Contracts;

use Mollie\Api\Resources\Payment;

interface CreateMolliePayment
{
    public function execute(array $payload): Payment;
}
