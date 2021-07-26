<?php
declare(strict_types=1);

namespace DMS\Filter\Rules;

/**
 * PregReplace Rule
 * Replaces based on regular expression, will replace with empty if no
 * replacement is defined.
 *
 * @Annotation
 */
class PregReplace extends Rule
{
    /**
     * Regular Expression to use
     */
    public ?string $regexp = null;

    /**
     * Replacement
     */
    public string $replacement = '';

    public function getDefaultOption(): ?string
    {
        return 'regexp';
    }
}
