<?php

namespace DMS\Filter\Rules;

/**
 * RegExp Rule
 *
 * Filter using preg_replace and unicode or non-unicode patterns
 *
 * @package DMS
 * @subpackage Filter
 *
 * @Annotation
 */
class RegExp extends Rule
{
    /**
     * Unicode version of Pattern
     *
     * @var string
     */
    public $unicodePattern;

    /**
     * Reg Exp Pattern
     *
     * @var string
     */
    public $pattern;

}
