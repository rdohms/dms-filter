<?php

namespace DMS\Filter\Mapping\Cache;

interface CacheInterface
{
    /**
     * Returns whether metadata for the given class exists in the cache
     *
     * @param string $class
     */
    function has($class);

    /**
     * Returns the metadata for the given class from the cache
     *
     * @param string $class Class Name
     *
     * @return ClassMetadata
     */
    function read($class);

    /**
     * Stores a class metadata in the cache
     *
     * @param ClassMetadata $metadata A Class Metadata
     */
    function write(ClassMetadata $metadata);
}