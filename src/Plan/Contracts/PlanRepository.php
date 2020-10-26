<?php

declare(strict_types=1);

namespace Loxi5\Subscription\Plan\Contracts;

interface PlanRepository
{
    /**
     * @param string $name
     * @return null|\Loxi5\Subscription\Plan\Contracts\Plan
     */
    public static function find(string $name);

    /**
     * @param string $name
     * @return \Loxi5\Subscription\Plan\Contracts\Plan
     */
    public static function findOrFail(string $name);
}
