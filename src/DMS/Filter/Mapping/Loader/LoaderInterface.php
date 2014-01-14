<?php

namespace DMS\Filter\Mapping\Loader;

use DMS\Filter\Mapping\ClassMetadataInterface;

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
     * @param ClassMetadataInterface $metadata A metadata
     *
     * @return Boolean
     */
    public function loadClassMetadata(ClassMetadataInterface $metadata);
}
