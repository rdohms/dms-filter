<?php

namespace DMS\Filter\Mapping;

interface ClassMetadataInterface
{
    /**
     * Retrieve a list of the object's properties that have filters attached
     * to them
     * 
     * @return array
     */
    public function getFilteredProperties();
    
    /**
     * Retrieve s list of filtering rules attached to a property
     * 
     * @param string $property
     * @return array
     */
    public function getPropertyRules($property);
}