<?php

namespace Loxi5\Subscription\Http\Controllers;

use Loxi5\Subscription\Mollie\Contracts\GetMolliePayment;
use Mollie\Api\Exceptions\ApiException;

abstract class BaseWebhookController
{
    /**
     * @var \Loxi5\Subscription\Mollie\Contracts\GetMolliePayment
     */
    protected $getMolliePayment;

    public function __construct(GetMolliePayment $getMolliePayment)
    {
        $this->getMolliePayment = $getMolliePayment;
    }

    /**
     * Fetch a payment from Mollie using its ID.
     * Returns null if the payment cannot be retrieved.
     *
     * @param $id
     * @return \Mollie\Api\Resources\Payment|null
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function getPaymentById($id)
    {
        try {
            return $this->getMolliePayment->execute($id);
        } catch (ApiException $e) {
            if(! config('app.debug')) {
                // Prevent leaking information
                return null;
            }
            throw $e;
        }
    }
}
