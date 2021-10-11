<?php
declare(strict_types=1);

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

use function is_string;
use function trim;

/**
 * Trim Filter
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
        if (! is_string($value)) {
            return $value;
        }

        //trim() only operates in default mode
        //if no second argument is passed, it
        //cannot be passed as null
        if ($rule->charlist === null) {
            return trim($value);
        }

        return trim($value, $rule->charlist);
    }
}
