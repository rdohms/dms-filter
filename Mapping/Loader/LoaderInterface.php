<?php

namespace DMS\Filter\Mapping\Loader;

use DMS\Filter\Mapping;

/**
 * Interface for a Loader
 * 
 * @package DMS
 * @subpackage Filter
 */
interface LoaderInterface
{
    /**
     * Load a Class Metadata.
     *
     * @param ClassMetadata $metadata A metadata
     *
     * @return Boolean
     */
    function loadClassMetadata(Mapping\ClassMetadataInterface $metadata);
}