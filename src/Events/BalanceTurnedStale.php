<?php

namespace Loxi5\Subscription\Events;

use Illuminate\Queue\SerializesModels;
use Loxi5\Subscription\Credit\Credit;

class BalanceTurnedStale
{
    use SerializesModels;

    /**
     * @var \Loxi5\Subscription\Credit\Credit
     */
    public $credit;

    public function __construct(Credit $credit)
    {
        $this->credit = $credit;
    }
}
