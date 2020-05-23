<?php
declare(strict_types=1);

namespace DMS\Filter\Rules;

use const ENT_COMPAT;

/**
 * Html Entities Filter
 *
 * @Annotation
 */
class HtmlEntities extends Rule
{
    /**
     * Flags
     */
    public int $flags = ENT_COMPAT;

    /**
     * Encoding to be used
     */
    public string $encoding = 'UTF-8';

    /**
     * Convert existing entities
     */
    public bool $doubleEncode = true;
}
