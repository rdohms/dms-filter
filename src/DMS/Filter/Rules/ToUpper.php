<?php

declare(strict_types=1);

namespace DMS\Filter\Rules;

use Attribute;

/**
 * ToUpper Rule
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class ToUpper extends Rule
{
    /**
     * Encoding to be used
     */
    public function __construct(
        public string|null $encoding = null
    ) {
    }
}
