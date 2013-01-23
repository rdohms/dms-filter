<?php

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

/**
 * Trim Filter
 *
 * @package DMS
 * @subpackage Filter
 */
class Trim extends BaseFilter
{
    /**
     * {@inheritDoc}
     *
     * @param \DMS\Filter\Rules\Trim $rule
     */
    public function apply(Rule $rule, $value)
    {
        //trim() only operates in default mode
        //if no second argument is passed, it
        //cannot be passed as null
        if ($rule->charlist === null) {
            return trim($value);
        }

        return trim($value, $rule->charlist);
    }
}
