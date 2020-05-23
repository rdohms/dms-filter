<?php

namespace DMS\Filter;

use DMS\Filter\Filters\Loader\FilterLoaderInterface;
use DMS\Filter\Filters\ObjectAwareFilter;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use UnexpectedValueException;

/**
 * Walks over the properties of an object applying the filters
 * that were defined for them
 *
 * @package DMS
 * @subpackage Filter
 */
class ObjectWalker
{
    /**
     * @var object
     */
    protected object $object;

    /**
     * @var ReflectionClass
     */
    protected ReflectionClass $reflClass;

    /**
     * @var FilterLoaderInterface
     */
    protected FilterLoaderInterface $filterLoader;

    /**
     * Constructor
     *
     * @param object                $object
     * @param FilterLoaderInterface $filterLoader
     *
     * @throws ReflectionException
     * @throws ReflectionException
     */
    public function __construct($object, $filterLoader)
    {
        $this->object       = $object;
        $this->reflClass    = new ReflectionClass($object);
        $this->filterLoader = $filterLoader;
    }

    /**
     * Applies the selected rules to a property in the object
     *
     * @param string $property
     * @param array  $filterRules
     *
     * @throws ReflectionException
     */
    public function applyFilterRules($property, $filterRules = []): void
    {
        foreach ($filterRules as $rule) {
            $this->applyFilterRule($property, $rule);
        }
    }

    /**
     * Applies a Filtering Rule to a property
     *
     * @param string     $property
     * @param Rules\Rule $filterRule
     *
     * @throws UnexpectedValueException
     * @throws ReflectionException
     */
    public function applyFilterRule($property, Rules\Rule $filterRule): void
    {
        if ($this->filterLoader === null) {
            throw new UnexpectedValueException("A FilterLoader must be provided");
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
     * @param string $propertyName
     *
     * @return mixed
     * @throws ReflectionException
     * @throws ReflectionException
     */
    private function getPropertyValue($propertyName)
    {
        return $this->getAccessibleReflectionProperty($propertyName)
               ->getValue($this->object);
    }

    /**
     * Overrides the value of a property, overcoming visibility problems
     *
     * @param string $propertyName
     * @param mixed  $value
     *
     * @throws ReflectionException
     * @throws ReflectionException
     */
    private function setPropertyValue($propertyName, $value): void
    {
        $this->getAccessibleReflectionProperty($propertyName)
        ->setValue($this->object, $value);
    }

    /**
     * Retrieves a property from the object and makes it visible
     *
     * @param string $propertyName
     *
     * @return ReflectionProperty
     * @throws ReflectionException
     * @throws ReflectionException
     */
    private function getAccessibleReflectionProperty($propertyName): ReflectionProperty
    {
        $property = $this->reflClass->getProperty($propertyName);
        $property->setAccessible(true);

        return $property;
    }
}
