<?php

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

/**
 * StripTags Filter
 *
 * @package DMS
 * @subpackage Filter
 */
class StripTags extends BaseFilter
{
    /**
     * {@inheritDoc}
     *
     * @param \DMS\Filter\Rules\StripTags $rule
     * @param mixed $filter
     */
    public function apply(Rule $rule, $value)
    {
        return strip_tags($value, $rule->allowed);
    }
}
