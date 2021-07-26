<?php
declare(strict_types=1);

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

/**
 * IntScalar Filter
 * Converts content into an IntScalar
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
