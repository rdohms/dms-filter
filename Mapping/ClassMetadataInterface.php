<?php

namespace DMS\Filter\Mapping;

use DMS\Filter\Rules\Rule;
use ReflectionClass;

/**
 * Method required by a ClassMetadata class
 *
 * @package DMS
 * @subpackage Filter
 */
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

    /**
     * Merges rules from another metadata object into this one
     *
     * @param ClassMetadata $metadata
     */
    public function mergeRules($metadata);

    /**
     * Get name of class represented in this Metadata object
     *
     * @return string
     */
    public function getClassName();

    /**
     * Returns a ReflectionClass instance for this class.
     *
     * @return ReflectionClass
     */
    public function getReflectionClass();

    /**
     * Adds a new rule to a property
     *
     * @param string $property
     * @param Rule $rule
     */
    public function addPropertyRule($property, $rule);
}
