<?php

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

/**
 * IntScalar Filter
 * Converts content into an IntScalar
 *
 * @package DMS
 * @subpackage Filter
 */
class IntScalar extends BaseFilter
{
    /**
     * {@inheritDoc}
     */
    public function apply(Rule $rule, $value)
    {
        return (int) ($value);
    }

}
