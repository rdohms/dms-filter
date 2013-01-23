<?php

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

/**
 * StripNewlines Filter
 *
 * @package DMS
 * @subpackage Filter
 */
class StripNewlines extends BaseFilter
{
    /**
     * {@inheritDoc}
     */
    public function apply(Rule $rule, $value)
    {
        return str_replace(array("\n", "\r"), '', $value);
    }

}
