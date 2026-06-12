<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * Thrown when an agency attempts to create a property
 * but has reached (or exceeded) their plan listing limit.
 */
class ListingsLimitExceededException extends RuntimeException
{
    public function __construct(string $message = '')
    {
        parent::__construct($message ?: __('properties.limit_reached'));
    }
}
