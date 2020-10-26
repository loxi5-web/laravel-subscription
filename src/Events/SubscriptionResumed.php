<?php

namespace Loxi5\Subscription\Events;

use Illuminate\Queue\SerializesModels;
use Loxi5\Subscription\Subscription;

class SubscriptionResumed
{
    use SerializesModels;

    /**
     * @var \Loxi5\Subscription\Subscription
     */
    public $subscription;

    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }
}
