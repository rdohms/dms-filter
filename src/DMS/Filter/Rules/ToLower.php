<?php

declare(strict_types=1);

namespace DMS\Filter\Rules;

use Attribute;

/**
 * ToLower Rule
 *
 * @Annotation
 */
#[Attribute]
class ToLower extends Rule
{
    /**
     * Encoding to be used
     */
    public string|null $encoding = null;

    public function getDefaultOption(): string|null
    {
        return 'encoding';
    }
}
