<?php

namespace DMS\Filter\Rules;

/**
 * RegExp Rule
 *
 * Filter using preg_replace and unicode or non-unicode patterns
 *
 * @package DMS
 * @subpackage Filter
 *
 * @Annotation
 */
class RegExp extends Rule
{
    /**
     * Defines if Unicode is supported
     *
     * @var boolean
     */
    protected static $unicodeEnabled;

    /**
     * Unicode version of Pattern
     *
     * @var string
     */
    public $unicodePattern;

    /**
     * Reg Exp Pattern
     *
     * @var string
     */
    public $pattern;

    /**
     * {@inheritDoc}
     */
    public function applyFilter($value)
    {
        //Build pattern
        $pattern = ($this->checkUnicodeSupport() && $this->unicodePattern !== null)
            ? $this->unicodePattern
            : $this->pattern;

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

}