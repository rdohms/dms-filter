<?php
namespace DMS\Filter\Rules;

/**
 * PregReplace Rule
 * Replaces based on regular expression, will replace with empty if no
 * replacement is defined.
 *
 * @package DMS
 * @subpackage Filter
 *
 * @Annotation
 */
class PregReplace extends Rule
{
    /**
     * Regular Expression to use
     *
     * @var string
     */
    public $regexp = null;

    /**
     * Replacement
     *
     * @var string
     */
    public $replacement = "";

    /**
     * {@inheritDoc}
     */
    public function applyFilter($value)
    {
        return preg_replace($this->regexp, $this->replacement, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption()
    {
        return 'regexp';
    }
}
