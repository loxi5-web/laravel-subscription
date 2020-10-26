<?php
declare(strict_types=1);

namespace Loxi5\Subscription\Mollie;

use Mollie\Api\Resources\Payment;
use Loxi5\Subscription\Mollie\Contracts\GetMolliePayment as Contract;


class GetMolliePayment extends BaseMollieInteraction implements Contract
{
    public function execute(string $id): Payment
    {
        return $this->mollie->payments()->get($id);
    }
}
