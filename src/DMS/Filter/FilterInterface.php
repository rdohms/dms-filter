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
     */
    public function filterEntity(mixed $object): void;

    /**
     * Filters a specific property in an object, replacing the current value
     */
    public function filterProperty(mixed $object, string $property): void;

    /**
     * Runs a given value through one or more filter rules returning the
     * filtered value
     *
     * @param Rule[]|Rule $filter
     */
    public function filterValue(mixed $value, array|Rule $filter): mixed;

    /**
     * Retrieves the metadata factory for class metdatas
     */
    public function getMetadataFactory(): ClassMetadataFactoryInterface;
}
