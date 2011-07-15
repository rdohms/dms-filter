<?php

namespace DMS\Filter\Mapping\Loader;

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