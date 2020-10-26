<?php

namespace Loxi5\Subscription;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Loxi5\Subscription\Order\OrderInvoiceSubscriber;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        OrderInvoiceSubscriber::class,
    ];
}
