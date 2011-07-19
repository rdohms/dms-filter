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
    public function applyFilter($value)
    {
        //trim() only operates in default mode
        //if no second argument is passed, it
        //cannot be passed as null
        if ($this->charlist === null) {
            return trim($value);
        }
        
        return trim($value, $this->charlist);
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption()
    {
        return 'charlist';
    }
}