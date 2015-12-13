<?php

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

/**
 * BooleanScalar Filter
 *
 * @package DMS
 * @subpackage Filter
 */
class BooleanScalar extends BaseFilter
{
    /**
     * {@inheritDoc}
     */
    public function apply(Rule $rule, $value)
    {
        return (boolean) $value;
    }

}
