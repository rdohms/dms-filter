<?php
declare(strict_types=1);

namespace DMS\Filter\Mapping\Loader;

use DMS\Filter\Mapping\ClassMetadataInterface;

/**
 * Interface for a Loader
 */
interface LoaderInterface
{
    /**
     * Load a Class Metadata.
     *
     * @param ClassMetadataInterface $metadata A metadata
     */
    public function loadClassMetadata(ClassMetadataInterface $metadata): bool;
}
