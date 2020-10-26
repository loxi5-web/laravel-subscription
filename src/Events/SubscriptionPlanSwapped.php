<?php

namespace Loxi5\Subscription\Events;

use Illuminate\Queue\SerializesModels;
use Loxi5\Subscription\Subscription;

class SubscriptionPlanSwapped
{
    use SerializesModels;

    /**
     * @var \Loxi5\Subscription\Subscription
     */
    public $subscription;

    /**
     * The previous subscription plan before swapping if exists.
     *
     * @var mixed
     */
    public $previousPlan;

    public function __construct(Subscription $subscription, $previousPlan = null)
    {
        $this->subscription = $subscription;

        $this->previousPlan = $previousPlan;
    }
}
