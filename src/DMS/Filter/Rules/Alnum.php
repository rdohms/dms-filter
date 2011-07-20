<?php

namespace DMS\Filter\Rules;

/**
 * Alnum Rule (Alpanumeric)
 * 
 * @package DMS
 * @subpackage Filter
 * 
 * @Annotation
 */
class Alnum extends Rule
{
    protected static $unicodeEnabled;
    
    public $allowWhitespace = true;
    
    /**
     * {@inheritDoc}
     */
    public function applyFilter($value)
    {
        //Check for Whitespace support
        $whitespaceChar = ($this->allowWhitespace)? " ":"";
        
        //Build pattern
        $pattern = ($this->checkUnicodeSupport())? 
                        '/[^\p{L}\p{N}' . $whitespaceChar . ']/u' : 
                        '/[^a-zA-Z0-9' . $whitespaceChar . ']/' ;
        
        return preg_replace($pattern, '', $value);
    }

    /**
     * Verifies that Regular Expression functions support unicode
     * @return boolean
     */
    public function checkUnicodeSupport()
    {
        if (null === self::$unicodeEnabled) {
            self::$unicodeEnabled = (@preg_match('/\pL/u', 'a')) ? true : false;
        }
        
        return self::$unicodeEnabled;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getDefaultOption()
    {
        return 'allowWhitespace';
    }

}