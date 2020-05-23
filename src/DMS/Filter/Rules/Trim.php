<?php

namespace DMS\Filter\Rules;

/**
 * Trim Rule
 *
 * @package DMS
 * @subpackage Filter
 *
 * @Annotation
 */
class Trim extends Rule
{
    /**
     * Comma separated string of allowed tags
     *
     * @var string
     */
    public ?string $charlist = null;

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption(): ?string
    {
        return 'charlist';
    }
}
