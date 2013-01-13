<?php

namespace DMS\Filter\Rules;

/**
 * StripTags Rule
 *
 * @package DMS
 * @subpackage Filter
 *
 * @Annotation
 */
class StripTags extends Rule
{
    /**
     * String of allowed tags. Ex: <b><i><a>
     *
     * @var string
     */
    public $allowed = null;

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption()
    {
        return 'allowed';
    }
}
