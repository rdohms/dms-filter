<?php
declare(strict_types=1);

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

use function is_string;
use function preg_replace;

/**
 * PregReplace Filter
 *
 * Replaces based on regular expression, will replace with empty if no
 * replacement is defined.
 */
class PregReplace extends BaseFilter
{
    /**
     * {@inheritDoc}
     */
    public function apply(Rule $rule, $value)
    {
        return is_string($value) ? preg_replace($rule->regexp, $rule->replacement, $value) : $value;
    }
}
