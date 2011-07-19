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
     * Comma separated string of allowed tags
     * 
     * @var string
     */
    public $allowed = null;
    
    /**
     * {@inheritDoc}
     */
    public function applyFilter($value)
    {
        return strip_tags($value, $this->allowed);
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption()
    {
        return 'allowed';
    }
}