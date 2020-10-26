<?php
declare(strict_types=1);

namespace Loxi5\Subscription\Mollie;

use Mollie\Api\Resources\Payment;
use Loxi5\Subscription\Mollie\Contracts\UpdateMolliePayment as Contract;

class UpdateMolliePayment extends BaseMollieInteraction implements Contract
{
    public function execute(Payment $dirtyPayment): Payment
    {
        return $dirtyPayment->update();
    }
}
