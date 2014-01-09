<?php

namespace DMS\Filter;

use DMS\Filter\Filters\Loader\FilterLoaderInterface;

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
    protected $object;

    /**
     * @var \ReflectionClass
     */
    protected $reflClass;

    /**
     * @var FilterLoaderInterface
     */
    protected $filterLoader;

    /**
     * Constructor
     *
     * @param object $object
     * @param FilterLoaderInterface $filterLoader
     */
    public function __construct($object, $filterLoader)
    {
        $this->object       = $object;
        $this->reflClass    = new \ReflectionClass($object);
        $this->filterLoader = $filterLoader;
    }

    /**
     * Applies the selected rules to a property in the object
     *
     * @param string $property
     * @param array $filterRules
     */
    public function applyFilterRules($property, $filterRules = array())
    {
        foreach ($filterRules as $rule) {
            $this->applyFilterRule($property, $rule);
        }
    }

    /**
     * Applies a Filtering Rule to a property
     *
     * @param string $property
     * @param Rules\Rule $filterRule
     *
     * @throws \UnexpectedValueException
     */
    public function applyFilterRule($property, Rules\Rule $filterRule)
    {

        if ($this->filterLoader === null) {
            throw new \UnexpectedValueException("A FilterLoader must be provided");
        }

        $value = $this->getPropertyValue($property);

        $filter = $this->filterLoader->getFilterForRule($filterRule);
        $filteredValue = $filter->apply($filterRule, $value);

        $this->setPropertyValue($property, $filteredValue);

    }

    /**
     * Retrieves the value of the property, overcoming visibility problems
     *
     * @param string $propertyName
     * @return mixed
     */
    private function getPropertyValue($propertyName)
    {
        return $this->getAccessibleReflectionProperty($propertyName)
               ->getValue($this->object);
    }

    /**
     * Overrides the value of a property, overcoming visibility problems
     *
     * @param string$propertyName
     * @param mixed $value
     */
    private function setPropertyValue($propertyName, $value)
    {
        $this->getAccessibleReflectionProperty($propertyName)
        ->setValue($this->object, $value);
    }

    /**
     * Retrieves a property from the object and makes it visible
     *
     * @param string $propertyName
     * @return \ReflectionProperty
     */
    private function getAccessibleReflectionProperty($propertyName)
    {
        $property = $this->reflClass->getProperty($propertyName);
        $property->setAccessible(true);

        return $property;
    }
}
