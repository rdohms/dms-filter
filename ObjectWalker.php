<?php

namespace DMS\Filter;

class ObjectWalker
{
    
    protected $object;
    
    public function __construct( $object )
    {
        $this->object = $object;
    }
    
    /**
     *
     * @param string $property
     * @param array $filterRules 
     */
    public function applyFilterRules($property, $filterRules = array())
    {
        foreach($filterRules as $rule ) {
            $this->applyFilterRule($property, $rule);
        }
    }
    
    /**
     *
     * @param string $property
     * @param Rules\Rule $filterRule
     */
    public function applyFilterRule($property, Rules\Rule $filterRule) 
    {
                
        $value = $this->getPropertyValue($property);
        
        $filteredValue = $filterRule->applyFilter($value);
        
        $this->setPropertyValue($property, $filteredValue);
        
    }
    
    private function getPropertyValue($property)
    {
        //make property accessible and read
        return $value;
    }
    
    private function setPropertyValue($property, $value)
    {
        //make property accessible and override
    }
}