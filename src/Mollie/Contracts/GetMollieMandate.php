<?php
declare(strict_types=1);

namespace Loxi5\Subscription\Mollie\Contracts;

use Mollie\Api\Resources\Mandate;

interface GetMollieMandate
{
    public function execute(string $customerId, string $mandateId): Mandate;
}
