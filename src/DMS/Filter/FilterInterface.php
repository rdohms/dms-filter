<?php

namespace DMS\Filter;

/**
 * Filters the values of a given object
 *
 * @package DMS
 * @subpackage Filter
 */
interface FilterInterface
{
    /**
     * Iterates over the properties of the object applying filters and
     * replacing values
     *
     * @param mixed $object
     */
    public function filterEntity($object);

    /**
     * Filters a specific property in an object, replacing the current value
     *
     * @param mixed $object
     * @param string $property
     */
    public function filterProperty($object, $property);

    /**
     * Runs a given value through one or more filter rules returning the
     * filtered value
     *
     * @param mixed $value
     * @param array|Rules\Rule $filter
     *
     * @return mixed
     */
    public function filterValue($value, $filter);

    /**
     * Retrieves the metadata factory for class metdatas
     *
     * @return Mapping\ClassMetadataFactoryInterface
     */
    public function getMetadataFactory();

}
