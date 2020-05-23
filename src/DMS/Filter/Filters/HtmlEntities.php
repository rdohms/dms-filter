<?php
declare(strict_types=1);

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

use function htmlentities;

/**
 * Html Entities Filter
 */
class HtmlEntities extends BaseFilter
{
    /**
     * {@inheritDoc}
     *
     * @param \DMS\Filter\Rules\HtmlEntities $rule
     */
    public function apply(Rule $rule, $value)
    {
        return htmlentities($value, $rule->flags, $rule->encoding, $rule->doubleEncode);
    }
}
