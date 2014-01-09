<?php

namespace DMS\Filter\Rules;

/**
 * ToUpper Rule
 *
 * @package DMS
 * @subpackage Filter
 *
 * @Annotation
 */
class ToUpper extends Rule
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
