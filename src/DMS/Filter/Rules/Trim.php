<?php

declare(strict_types=1);

namespace DMS\Filter\Rules;

use Attribute;

/**
 * Trim Rule
 *
 * @Annotation
 */
#[Attribute]
class Trim extends Rule
{
    /**
     * Comma separated string of allowed tags
     */
    public string|null $charlist = null;

    public function getDefaultOption(): string|null
    {
        return 'charlist';
    }
}
