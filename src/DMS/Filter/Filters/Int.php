<?php

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

/**
 * Int Filter
 * Converts content into an Int
 *
 * @package DMS
 * @subpackage Filter
 */
class Int extends BaseFilter
{
    /**
     * {@inheritDoc}
     */
    public function apply(Rule $rule, $value)
    {
        return (int) ($value);
    }

}
