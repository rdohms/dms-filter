<?php

namespace DMS\Filter\Rules;

/**
 * Float Rule
 * Converts content into a Float
 * 
 * @package DMS
 * @subpackage Filter
 * 
 * @Annotation
 */
class Float extends Rule
{
    /**
     * {@inheritDoc}
     */
    public function applyFilter($value)
    {
        if (is_array($value) || is_object($value)) {
            return null;
        }
        
        return floatval($value);
    }

}