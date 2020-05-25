<?php
declare(strict_types=1);

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

use function is_array;
use function is_object;

/**
 * FloatScalar Filter
 * Converts content into a FloatScalar
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

        return (float) $value;
    }
}
