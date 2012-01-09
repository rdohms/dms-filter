<?php

namespace DMS\Bundles\FilterBundle\Service;

/**
 * Filter Service
 * 
 * Provides filtering result based on annotation in the class.
 * 
 * @package DMS
 * @subpackage Bundles
 */
class Filter
{
    
    /**
     * @var DMS\Filter\Filter
     */
    private $filterExecutor;
    
    /**
     * Instantiates the Filter Service
     */
    public function __construct()
    {
        //Get Doctrine Reader
        $reader = new \Doctrine\Common\Annotations\AnnotationReader();
        //$reader->setEnableParsePhpImports(true);

        //Load AnnotationLoader
        $loader = new \DMS\Filter\Mapping\Loader\AnnotationLoader($reader);
        $this->loader = $loader;

        //Get a MetadataFactory
        $metadataFactory = new \DMS\Filter\Mapping\ClassMetadataFactory($loader);

        //Get a Filter
        $this->filterExecutor = new \DMS\Filter\Filter($metadataFactory);
    }
   
    /**
     * Filter an object based on its annotations
     * 
     * @param object $object 
     */
    public function filter($object)
    {
        $this->filterExecutor->filter($object);
    }
    
    /**
     * Retrieve the actual filter executor instance
     * 
     * @return DMS\Filter\Filter
     */
    public function getFilterExecutor()
    {
        return $this->filterExecutor;
    }
}