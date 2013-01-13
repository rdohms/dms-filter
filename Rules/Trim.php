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
    public $charlist = null;

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption()
    {
        return 'charlist';
    }
}
