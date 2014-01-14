<?php

namespace DMS\Filter\Rules;

/**
 * Digits Rule
 *
 * @package DMS
 * @subpackage Filter
 *
 * @Annotation
 */
class Digits extends RegExp
{

    /**
     * Allow Whitespace or not
     *
     * @var bool
     */
    public $allowWhitespace = true;

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption()
    {
        return 'allowWhitespace';
    }

}
