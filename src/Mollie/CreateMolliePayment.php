<?php
declare(strict_types=1);

namespace Loxi5\Subscription\Mollie;

use Mollie\Api\Resources\Payment;
use Loxi5\Subscription\Mollie\Contracts\CreateMolliePayment as Contract;

class CreateMolliePayment extends BaseMollieInteraction implements Contract
{
    public function execute(array $payload): Payment
    {
        return $this->mollie->payments()->create($payload);
    }
}
