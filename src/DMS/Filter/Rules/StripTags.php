<?php

namespace DMS\Filter\Rules;

/**
 * StripTags Rule
 *
 * @package DMS
 * @subpackage Filter
 *
 * @Annotation
 */
class StripTags extends Rule
{
    /**
     * String of allowed tags. Ex: <b><i><a>
     *
     * @var string
     */
    public ?string $allowed = null;

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption(): ?string
    {
        return 'allowed';
    }
}
