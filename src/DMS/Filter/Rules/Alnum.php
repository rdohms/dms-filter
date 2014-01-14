<?php

namespace DMS\Filter\Rules;

/**
 * Alnum Rule (Alphanumeric)
 *
 * @package DMS
 * @subpackage Filter
 *
 * @Annotation
 */
class Alnum extends RegExp
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
