<?php

namespace DMS\Filter\Mapping;

use DMS\Filter\Rules\Rule;

/**
 * Represents a class that has Annotations
 *
 * @package DMS
 * @subpackage Filter
 */
class ClassMetadata implements ClassMetadataInterface
{
    /**
     * @var string
     */
    public $className;

    /**
     * Properties that contain filtering rules
     * @var array
     */
    public $filteredProperties = array();

    /**
     * @var \ReflectionClass
     */
    private $reflClass;

    /**
     * Constructor
     *
     * @param string $class
     */
    public function __construct($class)
    {
        $this->className = $class;
    }

    /**
     * {@inheritDoc}
     */
    public function getFilteredProperties()
    {
        return array_keys($this->filteredProperties);
    }

    /**
     * {@inheritDoc}
     */
    public function getPropertyRules($property)
    {
        if (! isset($this->filteredProperties[$property])) {
            return null;
        }

        return $this->filteredProperties[$property]['rules'];
    }

    /**
     * {@inheritDoc}
     *
     * @todo bend this method into calesthenics
     */
    public function mergeRules(ClassMetadataInterface $metadata)
    {
        foreach ($metadata->getFilteredProperties() as $property) {
            foreach ($metadata->getPropertyRules($property) as $rule) {
                $this->addPropertyRule($property, clone $rule);
            }
        }
    }

    /**
     * {@inheritDoc}
     *
     * @todo check for duplicate rules
     */
    public function addPropertyRule($property, Rule $rule)
    {
        if (!isset ($this->filteredProperties[$property])) {
            $this->filteredProperties[$property] = array('rules' => array());
        }

        $this->filteredProperties[$property]['rules'][] = $rule;
    }

    /**
     * {@inheritDoc}
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * {@inheritDoc}
     */
    public function getReflectionClass()
    {
        if (!$this->reflClass) {
            $this->reflClass = new \ReflectionClass($this->getClassName());
        }

        return $this->reflClass;
    }





}
