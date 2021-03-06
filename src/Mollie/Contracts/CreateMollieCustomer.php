<?php
declare(strict_types=1);

namespace Loxi5\Subscription\Mollie\Contracts;

use Mollie\Api\Resources\Customer;

interface CreateMollieCustomer
{
    public function execute(array $payload): Customer;
}
