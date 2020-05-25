<?php
declare(strict_types=1);

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

/**
 * BooleanScalar Filter
 */
class BooleanScalar extends BaseFilter
{
    /**
     * {@inheritDoc}
     */
    public function apply(Rule $rule, $value)
    {
        return (bool) $value;
    }
}
