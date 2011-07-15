<?php

namespace DMS\Filter\Mapping;

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