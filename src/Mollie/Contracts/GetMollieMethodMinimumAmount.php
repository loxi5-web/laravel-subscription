<?php
declare(strict_types=1);

namespace Loxi5\Subscription\Mollie\Contracts;

use Money\Money;

interface GetMollieMethodMinimumAmount
{
    public function execute(string $method, string $currency): Money;
}
