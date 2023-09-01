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
    public ?string $encoding = null;

    public function getDefaultOption(): ?string
    {
        return 'encoding';
    }
}
