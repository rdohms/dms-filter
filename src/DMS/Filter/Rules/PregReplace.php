<?php

declare(strict_types=1);

namespace DMS\Filter\Rules;

use Attribute;

/**
 * PregReplace Rule
 * Replaces based on regular expression, will replace with empty if no
 * replacement is defined.
 *
 * @Annotation
 */
#[Attribute]
class PregReplace extends Rule
{
    /**
     * Regular Expression to use
     */
    public string|null $regexp = null;

    /**
     * Replacement
     */
    public string $replacement = '';

    public function getDefaultOption(): string|null
    {
        return 'regexp';
    }
}
