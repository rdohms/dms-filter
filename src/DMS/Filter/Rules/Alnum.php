<?php
declare(strict_types=1);

namespace DMS\Filter\Rules;

use Attribute;

/**
 * Alnum Rule (Alphanumeric)
 *
 * @Annotation
 */
#[Attribute]
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
