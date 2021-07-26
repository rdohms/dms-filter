<?php
declare(strict_types=1);

namespace DMS\Filter\Rules;

/**
 * StripTags Rule
 *
 * @Annotation
 */
class StripTags extends Rule
{
    /**
     * String of allowed tags. Ex: <b><i><a>
     */
    public ?string $allowed = null;

    public function getDefaultOption(): ?string
    {
        return 'allowed';
    }
}
