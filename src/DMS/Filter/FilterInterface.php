<?php

namespace DMS\Filter;

/**
 * Filters the values of a given object
 */
interface FilterInterface
{
    /**
     * Iterates over the properties of the object applying filters and
     * replacing values
     * 
     * @param mixed $object
     */
    public function filter($object);
    
    /**
     * Filters a specific property in an object, replacing the current value
     * 
     * @param mixed $object
     * @param string $property
     */
    public function filterProperty($object, $property);

    /**
     * Runs a given value through a filter rule returning the filtered value
     * 
     * @param mixed $value
     * @param Rules\Rule $filter
     * 
     * @return mixed
     */
    public function filterValue($value, Rules\Rule $filter);
    
    /**
     * Retrieves the metadata factory for class metdatas
     * 
     * @return Mapping\ClassMetadataFactoryInterface
     */
    public function getMetadataFactory();
    
}