<?php

declare(strict_types=1);

namespace DMS\Filter\Rules;

use Attribute;

/**
 * Alpha Rule
 *
 * @Annotation
 */
#[Attribute]
class Alpha extends RegExp
{
    /**
     * Allow Whitespace or not
     */
    public bool $allowWhitespace = true;

    public function getDefaultOption(): string|null
    {
        return 'allowWhitespace';
    }
}
