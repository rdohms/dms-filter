<?php
declare(strict_types=1);

namespace DMS\Filter;

use DMS\Filter\Mapping\ClassMetadataFactoryInterface;
use DMS\Filter\Rules\Rule;

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
    public function filterEntity($object): void;

    /**
     * Filters a specific property in an object, replacing the current value
     *
     * @param mixed $object
     */
    public function filterProperty($object, string $property): void;

    /**
     * Runs a given value through one or more filter rules returning the
     * filtered value
     *
     * @param mixed       $value
     * @param Rule[]|Rule $filter
     *
     * @return mixed
     */
    public function filterValue($value, $filter);

    /**
     * Retrieves the metadata factory for class metdatas
     */
    public function getMetadataFactory(): ClassMetadataFactoryInterface;
}
