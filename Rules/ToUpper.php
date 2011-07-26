<?php

namespace DMS\Filter\Rules;

use DMS\Filter\Exception\FilterException;

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
    public function applyFilter($value)
    {
        if ($this->useEncoding()) {
            return mb_strtoupper((string) $value, $this->encoding);
        }

        return strtoupper((string) $value);
    }

    /**
     * Verify is encoding is set and if we have the proper
     * function to use it
     * 
     * @return boolean
     */
    public function useEncoding()
    {
        if ($this->encoding === null) {
            return false;
        }
        
        if (!function_exists('mb_strtoupper')) {
            throw new FilterException(
                'mbstring is required to use ToLower with an encoding.');
        }

        $this->encoding = (string) $this->encoding;
        $encodings = array_map('strtolower', mb_list_encodings());
        
        if (!in_array(strtolower($this->encoding), $encodings)) {
            throw new FilterException(
                "mbstring does not support the '".$this->encoding."' encoding"
            );
        }

        return true;
    }
    
}