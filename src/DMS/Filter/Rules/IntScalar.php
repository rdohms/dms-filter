<?php

declare(strict_types=1);

namespace DMS\Filter\Rules;

use Attribute;

/**
 * IntScalar Rule
 * Converts content into an IntScalar
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IntScalar extends Rule
{
}
