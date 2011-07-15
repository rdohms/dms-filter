<?php

namespace DMS\Filter;

/**
 * 
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
    public function filterValue($value, Rules\Rule $filter)
    {
        return $filter->applyFilter($value);
    }

    /**
     * {@inheritDoc}
     */
    public function getMetadataFactory()
    {
        return $this->metadataFactory;
    }
    
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
    
}