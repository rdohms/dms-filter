<?php

declare(strict_types=1);

namespace DMS\Filter\Rules;

use Attribute;

/**
 * Alpha Rule
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Alpha extends RegExp
{
    /**
     * Allow Whitespace or not
     */
    public function __construct(
        public bool $allowWhitespace = true
    ) {
    }
}
