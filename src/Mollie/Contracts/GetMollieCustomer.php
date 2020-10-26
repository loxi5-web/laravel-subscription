<?php
declare(strict_types=1);

namespace Loxi5\Subscription\Mollie\Contracts;

use Mollie\Api\Resources\Customer;

interface GetMollieCustomer
{
    public function execute(string $id): Customer;
}
