<?php

namespace DMS\Filter\Mapping;

/**
 * Required methods of a Metadata Factory class
 * 
 * @package DMS
 * @subpackage Filter
 */
interface ClassMetadataFactoryInterface
{
    /**
     * Retrieve metadata for the provided class
     * 
     * @param string $class
     * @return ClassMetadataInterface
     */
    public function getClassMetadata($class);
}