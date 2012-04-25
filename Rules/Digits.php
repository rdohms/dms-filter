<?php

namespace DMS\Filter\Rules;

/**
 * Digits Rule
 *
 * @package DMS
 * @subpackage Filter
 *
 * @Annotation
 */
class Digits extends RegExp
{

    /**
     * Allow Whitespace or not
     *
     * @var bool
     */
    public $allowWhitespace = true;

    /**
     * {@inheritDoc}
     */
    public function applyFilter($value)
    {
        //Check for Whitespace support
        $whitespaceChar = ($this->allowWhitespace)? " ":"";

        $this->unicodePattern = '/[^\p{N}' . $whitespaceChar . ']/';
        $this->pattern        = '/[^0-9' . $whitespaceChar . ']/';

        return parent::applyFilter($value);
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption()
    {
        return 'allowWhitespace';
    }

}