<?php
declare(strict_types=1);

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

use function is_string;
use function strip_tags;

/**
 * StripTags Filter
 */
class StripTags extends BaseFilter
{
    /**
     * {@inheritDoc}
     *
     * @param \DMS\Filter\Rules\StripTags $rule
     */
    public function apply(Rule $rule, $value)
    {
        return is_string($value) ? strip_tags($value, $rule->allowed) : $value;
    }
}
