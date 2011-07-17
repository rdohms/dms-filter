<?php

namespace DMS\Filter\Rules;

/**
 * Trim Rule
 * 
 * @package DMS
 * @subpackage Filter
 * 
 */
class Trim extends Rule
{
    /**
     * Comma separated string of allowed tags
     * 
     * @var string
     */
    public $trimCharlist = null;
    
    /**
     * {@inheritDoc}
     */
    public function applyFilter($value)
    {
        return trim($value, $this->trimCharlist);
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption()
    {
        return 'trimCharlist';
    }
}