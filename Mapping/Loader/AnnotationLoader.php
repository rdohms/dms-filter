<?php

namespace DMS\Filter\Mapping\Loader;

use Doctrine\Common\Annotations\Reader,
    Doctrine\Common\Annotations\AnnotationRegistry,
    DMS\Filter\Rules,
    DMS\Filter\Mapping;

/**
 * Loader that reads filtering data from Annotations
 * 
 * @package DMS
 * @subpackage Filter
 */
class AnnotationLoader implements LoaderInterface
{
    /**
     *
     * @var Doctrine\Common\Annotations\Reader 
     */
    protected $reader;
    
    /**
     * Constructor
     * 
     * @param Doctrine\Common\Annotations\Reader $reader 
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
        
        //Register Filter Rules Annotation Namespace
        AnnotationRegistry::registerAutoloadNamespace('DMS\Filter\Rules', __DIR__ . '/../../../../');
        
    }
    
    /**
     * Loads annotations data present in the class, using a Doctrine
     * annotation reader
     * 
     * @param ClassMetadata $metadata 
     */
    public function loadClassMetadata(Mapping\ClassMetadataInterface $metadata)
    {
        
        $reflClass = $metadata->getReflectionClass();
        
        //Iterate over properties to get annotations
        foreach($reflClass->getProperties() as $property) {
            
            $this->readProperty($property, $metadata);
            
        }
        
    }
    
    /**
     * Reads annotations for a selected property in the class
     * 
     * @param ReflectionProperty $property
     * @param ClassMetadata $metadata
     */
    private function readProperty($property, $metadata)
    {
        $reflClass = $metadata->getReflectionClass();
        
        // Skip if this property is not from this class
        if ($property->getDeclaringClass()->getName()
            != $metadata->getClassName()
        ) {
            return;
        }

        //Iterate over all annotations
        foreach($this->reader->getPropertyAnnotations($property) as $rule) {

            //Skip is its not a rule
            if ( ! $rule instanceof Rules\Rule ) continue;
            
            //Add Rule
            $metadata->addPropertyRule($property->getName(), $rule);

        }

    }

}