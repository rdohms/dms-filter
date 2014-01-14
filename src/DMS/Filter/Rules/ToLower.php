<?php

namespace DMS\Filter\Rules;

/**
 * ToLower Rule
 *
 * @package DMS
 * @subpackage Filter
 *
 * @Annotation
 */
class ToLower extends Rule
{
    /**
     * Encoding to be used
     *
     * @var string
     */
    public $encoding = null;

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption()
    {
        return 'encoding';
    }
}
