<?php

declare(strict_types=1);

namespace DMS\Filter\Rules;

use Attribute;

/**
 * PregReplace Rule
 * Replaces based on regular expression, will replace with empty if no
 * replacement is defined.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class PregReplace extends Rule
{
    /**
     * @param string|null $regexp Regular Expression to use
     * @param string $replacement Replacement
     */
    public function __construct(
        public string|null $regexp = null,
        public string $replacement = '',
    ) {
    }
}
