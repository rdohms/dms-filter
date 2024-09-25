<?php

declare(strict_types=1);

namespace DMS\Filter\Rules;

use Attribute;

/**
 * FloatScalar Rule
 * Converts content into a FloatScalar
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class FloatScalar extends Rule
{
}
