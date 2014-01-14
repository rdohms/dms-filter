<?php
namespace DMS\Filter\Rules;

/**
 * Html Entities Filter
 *
 * @package DMS
 * @subpackage Filter
 *
 * @Annotation
 */
class HtmlEntities extends Rule
{
    /**
     * Flags
     *
     * @var int
     */
    public $flags = ENT_COMPAT;

    /**
     * Encoding to be used
     *
     * @var string
     */
    public $encoding = 'UTF-8';

    /**
     * Convert existing entities
     *
     * @var bool
     */
    public $doubleEncode = true;

}
