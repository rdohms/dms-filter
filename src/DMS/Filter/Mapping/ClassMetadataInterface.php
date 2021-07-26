<?php
declare(strict_types=1);

namespace DMS\Filter\Mapping;

use DMS\Filter\Rules\Rule;
use ReflectionClass;

/**
 * Method required by a ClassMetadata class
 */
interface ClassMetadataInterface
{
    /**
     * Retrieve a list of the object's properties that have filters attached
     * to them
     *
     * @return string[]
     */
    public function getFilteredProperties(): array;

    /**
     * Retrieve s list of filtering rules attached to a property
     *
     * @return Rule[]|null
     */
    public function getPropertyRules(string $property): ?array;

    /**
     * Merges rules from another metadata object into this one
     */
    public function mergeRules(ClassMetadataInterface $metadata): void;

    /**
     * Get name of class represented in this Metadata object
     */
    public function getClassName(): string;

    /**
     * Returns a ReflectionClass instance for this class.
     */
    public function getReflectionClass(): ReflectionClass;

    /**
     * Adds a new rule to a property
     */
    public function addPropertyRule(string $property, Rule $rule): void;
}
