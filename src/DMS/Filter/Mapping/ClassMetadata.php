<?php
declare(strict_types=1);

namespace DMS\Filter\Mapping;

use DMS\Filter\Rules\Rule;
use ReflectionClass;
use ReflectionException;

use function array_keys;

/**
 * Represents a class that has Annotations
 */
class ClassMetadata implements ClassMetadataInterface
{
    public string $className;

    /**
     * Properties that contain filtering rules
     *
     * @var string[]
     */
    public array $filteredProperties = [];

    /**
     * Constructor
     */
    public function __construct(string $class)
    {
        $this->className = $class;
    }

    /**
     * {@inheritDoc}
     */
    public function getFilteredProperties(): array
    {
        return array_keys($this->filteredProperties);
    }

    /**
     * {@inheritDoc}
     */
    public function getPropertyRules($property): ?array
    {
        if (! isset($this->filteredProperties[$property])) {
            return null;
        }

        return $this->filteredProperties[$property]['rules'];
    }

    public function mergeRules(ClassMetadataInterface $metadata): void
    {
        foreach ($metadata->getFilteredProperties() as $property) {
            foreach ($metadata->getPropertyRules($property) as $rule) {
                $this->addPropertyRule($property, clone $rule);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function addPropertyRule($property, Rule $rule): void
    {
        if (! isset($this->filteredProperties[$property])) {
            $this->filteredProperties[$property] = ['rules' => []];
        }

        $this->filteredProperties[$property]['rules'][] = $rule;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * {@inheritDoc}
     *
     * @throws ReflectionException
     */
    public function getReflectionClass(): ReflectionClass
    {
        return new ReflectionClass($this->getClassName());
    }
}
