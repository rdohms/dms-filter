<?php

namespace DMS\Filter\Rules;

/**
 * Length Rule
 *
 * @package DMS
 * @subpackage Filter
 *
 * @Annotation
 */
class Length extends Rule
{
    /**
     * Number of characters to allowed
     *
     * @var integer
     */
    public $maximumLength;

    /**
     * {@inheritDoc}
     */
    public function applyFilter($value)
    {
        return substr($value, 0, $this->maximumLength);
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption()
    {
        return 'maximumLength';
    }
}
