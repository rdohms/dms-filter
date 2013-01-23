<?php

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

/**
 * Float Filter
 * Converts content into a Float
 *
 * @package DMS
 * @subpackage Filter
 */
class Float extends BaseFilter
{
    /**
     * {@inheritDoc}
     */
    public function apply(Rule $rule, $value)
    {
        if (is_array($value) || is_object($value)) {
            return null;
        }

        return floatval($value);
    }

}
