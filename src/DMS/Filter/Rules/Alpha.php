<?php
declare(strict_types=1);

namespace DMS\Filter\Rules;

/**
 * Alpha Rule
 *
 * @Annotation
 */
class Alpha extends RegExp
{
    /**
     * Allow Whitespace or not
     */
    public bool $allowWhitespace = true;

    public function getDefaultOption(): ?string
    {
        return 'allowWhitespace';
    }
}
