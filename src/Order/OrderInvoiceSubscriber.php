<?php

namespace Loxi5\Subscription\Order;

use Illuminate\Support\Facades\Event;
use Loxi5\Subscription\Events\FirstPaymentPaid;
use Loxi5\Subscription\Events\OrderInvoiceAvailable;
use Loxi5\Subscription\Events\OrderPaymentPaid;

class OrderInvoiceSubscriber
{
    /**
     * @param FirstPaymentPaid $event
     */
    public function handleFirstPaymentPaid($event)
    {
        Event::dispatch(new OrderInvoiceAvailable($event->order));
    }

    /**
     * @param OrderPaymentPaid $event
     */
    public function handleOrderPaymentPaid($event)
    {
        Event::dispatch(new OrderInvoiceAvailable($event->order));
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            OrderPaymentPaid::class,
            self::class . '@handleOrderPaymentPaid'
        );

        $events->listen(
            FirstPaymentPaid::class,
            self::class . '@handleFirstPaymentPaid'
        );
    }
}
