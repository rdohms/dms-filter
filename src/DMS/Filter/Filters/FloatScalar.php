<?php

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

/**
 * FloatScalar Filter
 * Converts content into a FloatScalar
 *
 * @package DMS
 * @subpackage Filter
 */
class FloatScalar extends BaseFilter
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
