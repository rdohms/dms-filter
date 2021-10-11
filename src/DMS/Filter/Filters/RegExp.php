<?php
declare(strict_types=1);

namespace DMS\Filter\Filters;

use DMS\Filter\Rules\Rule;

use function is_string;
use function preg_match;
use function preg_replace;

/**
 * RegExp Filter
 *
 * Filter using preg_replace and unicode or non-unicode patterns
 */
class RegExp extends BaseFilter
{
    /**
     * Defines if Unicode is supported
     */
    protected static bool $unicodeEnabled;

    /**
     * {@inheritDoc}
     *
     * @param \DMS\Filter\Rules\RegExp $rule
     */
    public function apply(Rule $rule, $value)
    {
        //Build pattern
        $pattern = $this->checkUnicodeSupport() && $rule->unicodePattern !== null
            ? $rule->unicodePattern
            : $rule->pattern;

        return is_string($value) ? preg_replace($pattern, '', $value) : $value;
    }

    /**
     * Verifies that Regular Expression functions support unicode
     */
    public function checkUnicodeSupport(): bool
    {
        if (! isset(static::$unicodeEnabled)) {
            //phpcs:disable SlevomatCodingStandard.ControlStructures.UselessTernaryOperator.UselessTernaryOperator
            static::$unicodeEnabled = @preg_match('/\pL/u', 'a') ? true : false;
        }

        return static::$unicodeEnabled;
    }
}
