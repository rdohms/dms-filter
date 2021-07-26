<?php
declare(strict_types=1);

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

use function str_replace;

/**
 * StripNewlines Filter
 */
class StripNewlines extends BaseFilter
{
    /**
     * {@inheritDoc}
     */
    public function apply(Rule $rule, $value)
    {
        return str_replace(["\n", "\r"], '', $value);
    }
}
