<?php
declare(strict_types=1);

namespace DMS\Filter\Rules;

/**
 * ToUpper Rule
 *
 * @Annotation
 */
class ToUpper extends Rule
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
