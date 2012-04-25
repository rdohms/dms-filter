<?php

namespace DMS\Filter\Rules;

/**
 * Alpha Rule
 *
 * @package DMS
 * @subpackage Filter
 *
 * @Annotation
 */
class Alpha extends RegExp
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

        $this->unicodePattern = '/[^\p{L}' . $whitespaceChar . ']/u';
        $this->pattern        = '/[^a-zA-Z' . $whitespaceChar . ']/';

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