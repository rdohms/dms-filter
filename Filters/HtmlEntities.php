<?php
namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

/**
 * Html Entities Filter
 *
 * @package DMS
 * @subpackage Filter
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
