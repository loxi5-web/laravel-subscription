<?php
declare(strict_types=1);

namespace Loxi5\Subscription\Mollie;

use Mollie\Api\Resources\Customer;
use Loxi5\Subscription\Mollie\Contracts\CreateMollieCustomer as Contract;

class CreateMollieCustomer extends BaseMollieInteraction implements Contract
{
    public function execute(array $payload): Customer
    {
        return $this->mollie->customers()->create($payload);
    }
}
