<?php

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

/**
 * Boolean Filter
 *
 * @package DMS
 * @subpackage Filter
 *
 * @Annotation
 */
class Boolean extends BaseFilter
{
    /**
     * {@inheritDoc}
     */
    public function apply(Rule $rule, $value)
    {
        return (boolean) $value;
    }

}
