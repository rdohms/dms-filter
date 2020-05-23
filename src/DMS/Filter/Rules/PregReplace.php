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
    public ?string $regexp = null;

    /**
     * Replacement
     *
     * @var string
     */
    public string $replacement = "";

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption(): ?string
    {
        return 'regexp';
    }
}
