<?php

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

/**
 * RegExp Filter
 *
 * Filter using preg_replace and unicode or non-unicode patterns
 *
 * @package DMS
 * @subpackage Filter
 */
class RegExp extends BaseFilter
{
    /**
     * Defines if Unicode is supported
     *
     * @var boolean
     */
    protected static $unicodeEnabled;

    /**
     * {@inheritDoc}
     *
     * @param \DMS\Filter\Rules\RegExp $rule
     */
    public function apply(Rule $rule, $value)
    {
        //Build pattern
        $pattern = ($this->checkUnicodeSupport() && $rule->unicodePattern !== null)
            ? $rule->unicodePattern
            : $rule->pattern;

        return preg_replace($pattern, '', $value);
    }

    /**
     * Verifies that Regular Expression functions support unicode
     * @return boolean
     */
    public function checkUnicodeSupport()
    {
        if (null === self::$unicodeEnabled) {
            self::$unicodeEnabled = (@preg_match('/\pL/u', 'a')) ? true : false;
        }

        return self::$unicodeEnabled;
    }

}
