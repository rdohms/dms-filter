<?php

declare(strict_types=1);

namespace DMS\Filter\Rules;

use Attribute;

/**
 * StripNewlines Rule
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class StripNewlines extends Rule
{
}
