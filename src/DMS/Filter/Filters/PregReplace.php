<?php
namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

/**
 * PregReplace Filter
 *
 * Replaces based on regular expression, will replace with empty if no
 * replacement is defined.
 *
 * @package DMS
 * @subpackage Filter
 */
class PregReplace extends BaseFilter
{
    /**
     * {@inheritDoc}
     */
    public function apply(Rule $rule, $value)
    {
        return preg_replace($rule->regexp, $rule->replacement, $value);
    }
}
