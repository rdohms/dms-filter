<?php

namespace DMS\Filter\Rules;

/**
 * Boolean Rule
 * 
 * @package DMS
 * @subpackage Filter
 * 
 * @Annotation
 */
class Boolean extends Rule
{
    /**
     * {@inheritDoc}
     */
    public function applyFilter($value)
    {
        return (boolean) $value;
    }

}