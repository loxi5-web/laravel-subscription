<?php

namespace Loxi5\Subscription\SubscriptionBuilder;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Loxi5\Subscription\FirstPayment\Actions\ActionCollection;
use Loxi5\Subscription\FirstPayment\Actions\AddGenericOrderItem;
use Loxi5\Subscription\FirstPayment\Actions\ApplySubscriptionCouponToPayment;
use Loxi5\Subscription\FirstPayment\Actions\StartSubscription;
use Loxi5\Subscription\FirstPayment\FirstPaymentBuilder;
use Loxi5\Subscription\Plan\Contracts\PlanRepository;
use Loxi5\Subscription\Plan\Plan;
use Loxi5\Subscription\SubscriptionBuilder\Contracts\SubscriptionBuilder as Contract;

/**
 * Creates and configures a Mollie first payment to create a new mandate via Mollie's checkout
 * and start a new subscription. If the subscription has a leading trial period, the payment amount is reduced to
 * an amount defined on the subscription plan.
 */
class FirstPaymentSubscriptionBuilder implements Contract
{
    /**
     * @var \Loxi5\Subscription\FirstPayment\FirstPaymentBuilder
     */
    protected $firstPaymentBuilder;

    /**
     * @var \Loxi5\Subscription\FirstPayment\Actions\StartSubscription
     */
    protected $startSubscription;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $owner;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Plan
     */
    protected $plan;

    /**
     * Whether this payment results in a subscription trial
     *
     * @var bool
     */
    protected $isTrial = false;

    /**
     * Create a new subscription builder instance.
     *
     * @param mixed $owner
     * @param string $name
     * @param string $plan
     * @param array $paymentOptions
     * @throws \Loxi5\Subscription\Exceptions\PlanNotFoundException
     */
    public function __construct(Model $owner, string $name, string $plan, $paymentOptions = [])
    {
        $this->owner = $owner;
        $this->name = $name;

        $this->plan = app(PlanRepository::class)::findOrFail($plan);

        $this->initializeFirstPaymentBuilder($owner, $paymentOptions);

        $this->startSubscription = new StartSubscription($owner, $name, $plan);
    }

    /**
     * Create a new subscription. Returns a redirect to Mollie's checkout screen.
     *
     * @return \Loxi5\Subscription\SubscriptionBuilder\RedirectToCheckoutResponse
     * @throws \Loxi5\Subscription\Exceptions\CouponException|\Throwable
     */
    public function create()
    {
        $this->validateCoupon();

        $actions = new ActionCollection([$this->startSubscription]);
        $coupon = $this->startSubscription->coupon();

        if($this->isTrial) {
            $taxPercentage = $this->owner->taxPercentage() * 0.01;
            $total = $this->plan->firstPaymentAmount();

            if($total->isZero()) {
                $vat = $total->subtract($total); // zero VAT
            } else {
                $vat = $total->divide(1 + $taxPercentage)->multiply($taxPercentage);
            }
            $subtotal = $total->subtract($vat);

            $actions[] = new AddGenericOrderItem(
                $this->owner,
                $subtotal,
                $this->plan->firstPaymentDescription()
            );
        } elseif ($coupon) {
            $actions[] = new ApplySubscriptionCouponToPayment($this->owner, $coupon, $actions->processedOrderItems());
        }

        $this->firstPaymentBuilder->inOrderTo($actions->toArray())->create();

        return $this->redirectToCheckout();
    }

    /**
     * Specify the number of days of the trial.
     *
     * @param  int $trialDays
     * @return $this
     * @throws \Loxi5\Subscription\Exceptions\PlanNotFoundException
     * @throws \Throwable
     */
    public function trialDays(int $trialDays)
    {
        return $this->trialUntil(Carbon::now()->addDays($trialDays));
    }

    /**
     * Specify the ending date of the trial.
     *
     * @param  Carbon $trialUntil
     * @return $this
     * @throws \Loxi5\Subscription\Exceptions\PlanNotFoundException
     * @throws \Throwable
     */
    public function trialUntil(Carbon $trialUntil)
    {
        $this->startSubscription->trialUntil($trialUntil);
        $this->isTrial = true;

        return $this;
    }

    /**
     * Force the trial to end immediately.
     *
     * @return \Loxi5\Subscription\SubscriptionBuilder\Contracts\SubscriptionBuilder|void
     */
    public function skipTrial()
    {
        $this->isTrial = false;
        $this->startSubscription->skipTrial();

        return $this;
    }

    /**
     * Specify the quantity of the subscription.
     *
     * @param  int $quantity
     * @return $this
     * @throws \Throwable|\LogicException
     */
    public function quantity(int $quantity)
    {
        throw_if($quantity < 1, new \LogicException('Subscription quantity must be at least 1.'));
        $this->startSubscription->quantity($quantity);

        return $this;
    }

    /**
     * Specify a discount coupon.
     *
     * @param string $coupon
     * @return $this
     * @throws \Loxi5\Subscription\Exceptions\CouponNotFoundException
     */
    public function withCoupon(string $coupon)
    {
        $this->startSubscription->withCoupon($coupon);

        return $this;
    }

    /**
     * Override the default next payment date. This is superseded by the trial end date.
     *
     * @param \Carbon\Carbon $nextPaymentAt
     * @return $this
     */
    public function nextPaymentAt(Carbon $nextPaymentAt)
    {
        $this->startSubscription->nextPaymentAt($nextPaymentAt);

        return $this;
    }

    /**
     * @return \Loxi5\Subscription\FirstPayment\FirstPaymentBuilder
     */
    public function getMandatePaymentBuilder()
    {
        return $this->firstPaymentBuilder;
    }

    /**
     * @return \Loxi5\Subscription\SubscriptionBuilder\RedirectToCheckoutResponse
     */
    protected function redirectToCheckout()
    {
        return RedirectToCheckoutResponse::forFirstPaymentSubscriptionBuilder($this);
    }

    /**
     * @throws \Loxi5\Subscription\Exceptions\CouponException|\Throwable
     */
    protected function validateCoupon()
    {
        $coupon = $this->startSubscription->coupon();

        if ($coupon) {
            $coupon->validateFor(
                $this->startSubscription->builder()->makeSubscription()
            );
        }
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $owner
     * @param array $paymentOptions
     * @return \Loxi5\Subscription\FirstPayment\FirstPaymentBuilder
     */
    protected function initializeFirstPaymentBuilder(Model $owner, $paymentOptions = [])
    {
        $this->firstPaymentBuilder = new FirstPaymentBuilder($owner, $paymentOptions);
        $this->firstPaymentBuilder->setFirstPaymentMethod($this->plan->firstPaymentMethod());
        $this->firstPaymentBuilder->setRedirectUrl($this->plan->firstPaymentRedirectUrl());
        $this->firstPaymentBuilder->setWebhookUrl($this->plan->firstPaymentWebhookUrl());
        $this->firstPaymentBuilder->setDescription($this->plan->firstPaymentDescription());

        return $this->firstPaymentBuilder;
    }
}
