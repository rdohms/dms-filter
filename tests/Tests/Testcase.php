<?php

namespace Tests;

use DMS\Filter\Mapping,
    Doctrine\Common\Annotations;

class Testcase extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    
    public function tearDown()
    {
        parent::tearDown();
    }
    
    protected function buildMetadataFactory()
    {
        $reader = new Annotations\AnnotationReader();
        $reader->setEnableParsePhpImports(true);
        
        $loader = new Mapping\Loader\AnnotationLoader($reader);
        
        $metadataFactory = new Mapping\ClassMetadataFactory($loader);
        
        return $metadataFactory;
    }
}