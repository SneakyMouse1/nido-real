<?php

namespace App\Enums;

enum PlanSlug: string
{
    case Starter = 'starter';
    case Pro = 'pro';
    case Unlimited = 'unlimited';

    /**
     * Get the listings limit for this plan.
     */
    public function listingsLimit(): int
    {
        return match ($this) {
            self::Starter   => 10,
            self::Pro       => 50,
            self::Unlimited => 999999,
        };
    }
}
