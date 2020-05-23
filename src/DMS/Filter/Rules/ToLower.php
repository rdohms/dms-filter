<?php
declare(strict_types=1);

namespace DMS\Filter\Rules;

/**
 * ToLower Rule
 *
 * @Annotation
 */
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
