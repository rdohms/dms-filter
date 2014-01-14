<?php

namespace DMS\Filter\Rules;

/**
 * Alpha Rule
 *
 * @package DMS
 * @subpackage Filter
 *
 * @Annotation
 */
class Alpha extends RegExp
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
