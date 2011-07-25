<?php

namespace DMS\Filter;

/**
 * Filter Object, responsible for retrieving the filtering rules
 * for the object and applying them
 * 
 * @package DMS
 * @subpackage Filter
 * 
 */
class Filter implements FilterInterface
{
    /**
     *
     * @var Mapping\ClassMetadataFactory 
     */
    protected $metadataFactory;
    
    /**
     * Constructor
     * 
     * @param Mapping\ClassMetadataFactory $metadataFactory 
     */
    public function __construct(Mapping\ClassMetadataFactory $metadataFactory) 
    {
        $this->metadataFactory = $metadataFactory;
    }
    
    /**
     * {@inheritDoc}
     */
    public function filter($object)
    {
        $this->walkObject($object);
    }

    /**
     * {@inheritDoc}
     */
    public function filterProperty($object, $property)
    {
        $this->walkObject($object, $property);
    }
    
    /**
     * {@inheritDoc}
     */
    public function filterValue($value, $filter)
    {
        
        if ($filter instanceof Rules\Rule) {
            return $filter->applyFilter($value);
        }
        
        return $this->walkRuleChain($value, $filter);
    }

    /**
     * {@inheritDoc}
     */
    public function getMetadataFactory()
    {
        return $this->metadataFactory;
    }
    
    /**
     * Iterates over annotated properties in an object filtering the selected
     * values
     * 
     * @param object $object
     * @param string $limitProperty
     */
    protected function walkObject($object, $limitProperty = null) {
        
        if ( $object === null ) {
            return;
        }
        
        $metadata = $this->metadataFactory->getClassMetadata(get_class($object));
        
        //Get a Object Handler/Walker
        $walker = new ObjectWalker($object);
        
        //Get all filtered properties or limit with selected
        $properties = ($limitProperty !== null)? array($limitProperty) : $metadata->getFilteredProperties();
        
        //Iterate over properties with filters
        foreach( $properties as $property ) {
            
            $walker->applyFilterRules($property, $metadata->getPropertyRules($property));
            
        }
        
    }
    
    /**
     * Iterates over an array of filters applying all to the value
     * 
     * @param mixed $value
     * @param array $filters
     * @return mixed 
     */
    protected function walkRuleChain($value, $filters)
    {
        
        foreach($filters as $filter) {
            $value = $filter->applyFilter($value);
        }
        
        return $value;
    }
    
}