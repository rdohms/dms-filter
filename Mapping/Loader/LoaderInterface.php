<?php

namespace DMS\Filter\Mapping\Loader;

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
    function loadClassMetadata(ClassMetadata $metadata);
}