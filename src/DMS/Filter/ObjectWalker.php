<?php
declare(strict_types=1);

namespace DMS\Filter;

use DMS\Filter\Filters\Loader\FilterLoaderInterface;
use DMS\Filter\Filters\ObjectAwareFilter;
use DMS\Filter\Rules\Rule;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use UnexpectedValueException;

/**
 * Walks over the properties of an object applying the filters
 * that were defined for them
 */
class ObjectWalker
{
    protected object $object;

    protected ReflectionClass $reflClass;

    protected FilterLoaderInterface $filterLoader;

    /**
     * Constructor
     *
     * @throws ReflectionException
     * @throws ReflectionException
     */
    public function __construct(object $object, FilterLoaderInterface $filterLoader)
    {
        $this->object       = $object;
        $this->reflClass    = new ReflectionClass($object);
        $this->filterLoader = $filterLoader;
    }

    /**
     * Applies the selected rules to a property in the object
     *
     * @param Rule[] $filterRules
     *
     * @throws ReflectionException
     */
    public function applyFilterRules(string $property, array $filterRules = []): void
    {
        foreach ($filterRules as $rule) {
            $this->applyFilterRule($property, $rule);
        }
    }

    /**
     * Applies a Filtering Rule to a property
     *
     * @throws UnexpectedValueException
     * @throws ReflectionException
     */
    public function applyFilterRule(string $property, Rules\Rule $filterRule): void
    {
        if ($this->filterLoader === null) {
            throw new UnexpectedValueException('A FilterLoader must be provided');
        }

        $value = $this->getPropertyValue($property);

        $filter = $this->filterLoader->getFilterForRule($filterRule);

        if ($filter instanceof ObjectAwareFilter) {
            $filter->setCurrentObject($this->object);
        }

        $filteredValue = $filter->apply($filterRule, $value);

        $this->setPropertyValue($property, $filteredValue);
    }

    /**
     * Retrieves the value of the property, overcoming visibility problems
     *
     * @return mixed
     *
     * @throws ReflectionException
     * @throws ReflectionException
     */
    private function getPropertyValue(string $propertyName)
    {
        return $this->getAccessibleReflectionProperty($propertyName)
               ->getValue($this->object);
    }

    /**
     * Overrides the value of a property, overcoming visibility problems
     *
     * @param mixed $value
     *
     * @throws ReflectionException
     * @throws ReflectionException
     */
    private function setPropertyValue(string $propertyName, $value): void
    {
        $this->getAccessibleReflectionProperty($propertyName)
        ->setValue($this->object, $value);
    }

    /**
     * Retrieves a property from the object and makes it visible
     *
     * @throws ReflectionException
     * @throws ReflectionException
     */
    private function getAccessibleReflectionProperty(string $propertyName): ReflectionProperty
    {
        $property = $this->reflClass->getProperty($propertyName);
        $property->setAccessible(true);

        return $property;
    }
}
