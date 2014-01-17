<?php

namespace DMS\Tests;

use DMS\Filter\Mapping;
use Doctrine\Common\Annotations;

class FilterTestCase extends \PHPUnit_Framework_TestCase
{
    protected $loader;

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

        $loader = new Mapping\Loader\AnnotationLoader($reader);
        $this->loader = $loader;

        $metadataFactory = new Mapping\ClassMetadataFactory($loader);

        return $metadataFactory;
    }
}
