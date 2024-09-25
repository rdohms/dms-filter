<?php

declare(strict_types=1);

namespace DMS\Filter\Rules;

use Attribute;

/**
 * RegExp Rule
 *
 * Filter using preg_replace and unicode or non-unicode patterns
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class RegExp extends Rule
{
    /**
     * Unicode version of Pattern
     */
    public string $unicodePattern;

    /**
     * Reg Exp Pattern
     */
    public string $pattern;
}
