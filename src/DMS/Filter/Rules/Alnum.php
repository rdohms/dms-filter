<?php
declare(strict_types=1);

namespace DMS\Filter\Rules;

/**
 * Alnum Rule (Alphanumeric)
 *
 * @Annotation
 */
class Alnum extends RegExp
{
    /**
     * Allow Whitespace or not
     */
    public bool $allowWhitespace = true;

    public function getDefaultOption(): ?string
    {
        return 'allowWhitespace';
    }
}
