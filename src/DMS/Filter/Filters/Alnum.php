<?php
declare(strict_types=1);

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

/**
 * Alnum Filter (Alphanumeric)
 */
class Alnum extends RegExp
{
    /**
     * {@inheritDoc}
     *
     * @param \DMS\Filter\Rules\Alnum $rule
     */
    public function apply(Rule $rule, $value)
    {
        //Check for Whitespace support
        $whitespaceChar = $rule->allowWhitespace ? ' ' : '';

        $rule->unicodePattern = '/[^\p{L}\p{N}' . $whitespaceChar . ']/u';
        $rule->pattern        = '/[^a-zA-Z0-9' . $whitespaceChar . ']/';

        return parent::apply($rule, $value);
    }
}
