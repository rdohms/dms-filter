<?php

declare(strict_types=1);

namespace DMS\Filter\Rules;

use Attribute;

/**
 * StripTags Rule
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class StripTags extends Rule
{
    /**
     * String of allowed tags. Ex: <b><i><a>
     */
    public function __construct(
        public string|null $allowed = null
    ) {
    }
}
