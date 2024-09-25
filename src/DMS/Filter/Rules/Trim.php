<?php

declare(strict_types=1);

namespace DMS\Filter\Rules;

use Attribute;

/**
 * Trim Rule
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Trim extends Rule
{
    /**
     * Comma separated string of allowed tags
     */
    public function __construct(
        public string|null $charlist = null
    ) {
    }
}
