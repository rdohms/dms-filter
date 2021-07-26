<?php
declare(strict_types=1);

namespace DMS\Filter\Rules;

/**
 * Trim Rule
 *
 * @Annotation
 */
class Trim extends Rule
{
    /**
     * Comma separated string of allowed tags
     */
    public ?string $charlist = null;

    public function getDefaultOption(): ?string
    {
        return 'charlist';
    }
}
