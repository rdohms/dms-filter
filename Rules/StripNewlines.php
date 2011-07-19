<?php

namespace DMS\Filter\Rules;

/**
 * StripNewlines Rule
 * 
 * @package DMS
 * @subpackage Filter
 * 
 * @Annotation
 */
class StripNewlines extends Rule
{
    /**
     * {@inheritDoc}
     */
    public function applyFilter($value)
    {
        return str_replace(array("\n", "\r"), '', $value);
    }

}