<?php
declare(strict_types=1);

namespace Loxi5\Subscription\Mollie;

use Mollie\Api\Resources\Customer;
use Loxi5\Subscription\Mollie\Contracts\GetMollieCustomer as Contract;

class GetMollieCustomer extends BaseMollieInteraction implements Contract
{
    public function execute(string $id): Customer
    {
        return $this->mollie->customers()->get($id);
    }
}
