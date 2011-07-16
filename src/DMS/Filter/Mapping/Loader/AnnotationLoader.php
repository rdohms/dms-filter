<?php

namespace DMS\Filter\Mapping\Loader;

use Doctrine\Common\Annotations\Reader,
    DMS\Filter\Rules;

/**
 * @todo document
 */
class AnnotationLoader implements LoaderInterface
{
    
    protected $reader;
    
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }
    
    /**
     *
     * @param ClassMetadata $metadata 
     * 
     * @todo calesthenics
     */
    public function loadClassMetadata(ClassMetadata $metadata)
    {
        
        $reflClass = $metadata->getReflectionClass();
        
        //Iterate over properties to get annotations
        foreach($reflClass->getProperties() as $property) {
            if ($property->getDeclaringClass()->getName() == $reflClass->getClassName()) {
                
                foreach($this->reader->getPropertyAnnotations($property) as $rule) {
                    
                    if ( $rule instanceof Rules\Rule ) {
                        $metadata->addPropertyRule($property->getName(), $rule);
                    }
                    
                }
                
            }
        }
        
    }

}