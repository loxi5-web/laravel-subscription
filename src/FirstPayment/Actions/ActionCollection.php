<?php

namespace Loxi5\Subscription\FirstPayment\Actions;

use Illuminate\Support\Collection;
use Loxi5\Subscription\Cashier;
use Loxi5\Subscription\Exceptions\CurrencyMismatchException;
use Loxi5\Subscription\Order\OrderItemCollection;

class ActionCollection extends Collection
{
    public function __construct($items = [])
    {
        parent::__construct($items);
        $this->validate();
    }

    protected function validate()
    {
        if($this->isNotEmpty()) {
            $firstAmount = $this->first()->getTotal();
            $this->each(function (BaseAction $item) use ($firstAmount) {
                if(! $item->getTotal()->isSameCurrency($firstAmount))
                    throw new CurrencyMismatchException('All actions must be in the same currency');
            });
        }
    }

    /**
     * @return \Money\Money
     */
    public function total()
    {
        $total = money(0, $this->getCurrency());

        $this->each(function(BaseAction $item) use (&$total) {
            $total = $total->add($item->getTotal());
        });

        return $total;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        if($this->isNotEmpty()) {
            return $this->first()->getTotal()->getCurrency()->getCode();
        }

        return strtoupper(Cashier::usesCurrency());
    }

    /**
     * @return array
     */
    public function toMolliePayload()
    {
        $payload = [];
        foreach ($this->items as $item) {
            /** @var \Loxi5\Subscription\FirstPayment\Actions\BaseAction $item */
            $itemPayload = $item->getPayload();

            if(!empty($itemPayload)) {
                $payload[] = $itemPayload;
            }
        }

        return $payload;
    }

    /**
     * @return \Loxi5\Subscription\Order\OrderItemCollection
     */
    public function processedOrderItems()
    {
        $orderItems = new OrderItemCollection;

        /** @var \Loxi5\Subscription\FirstPayment\Actions\BaseAction $action */
        foreach ($this->items as $action) {
            $orderItems = $orderItems->concat($action->makeProcessedOrderItems());
        }

        return $orderItems;
    }
}
