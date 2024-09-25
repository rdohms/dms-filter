<?php

declare(strict_types=1);

namespace DMS\Filter\Rules;

use Attribute;

/**
 * BooleanScalar Rule
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class BooleanScalar extends Rule
{
}
