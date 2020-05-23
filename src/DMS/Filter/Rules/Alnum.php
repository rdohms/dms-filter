<?php

namespace DMS\Filter\Rules;

/**
 * Alnum Rule (Alphanumeric)
 *
 * @package DMS
 * @subpackage Filter
 *
 * @Annotation
 */
class Alnum extends RegExp
{

    /**
     * Allow Whitespace or not
     *
     * @var bool
     */
    public bool $allowWhitespace = true;

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption(): ?string
    {
        return 'allowWhitespace';
    }
}
