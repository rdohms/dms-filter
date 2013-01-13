<?php

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

/**
 * Alpha Filter
 *
 * @package DMS
 * @subpackage Filter
 *
 * @Annotation
 */
class Alpha extends RegExp
{
    /**
     * {@inheritDoc}
     *
     * @param \DMS\Filter\Rules\Alpha $rule
     */
    public function apply(Rule $rule, $value)
    {
        //Check for Whitespace support
        $whitespaceChar = ($rule->allowWhitespace)? " ":"";

        $rule->unicodePattern = '/[^\p{L}' . $whitespaceChar . ']/u';
        $rule->pattern        = '/[^a-zA-Z' . $whitespaceChar . ']/';

        return parent::apply($rule, $value);
    }
}
