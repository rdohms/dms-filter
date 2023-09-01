<?php

namespace DMS\Tests;

use DMS\Filter\Mapping;
use DMS\Filter\Mapping\ClassMetadataFactory;
use Doctrine\Common\Annotations;
use PHPUnit\Framework\TestCase;

class FilterTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    protected function buildMetadataFactoryWithAnnotationLoader(): ClassMetadataFactory
    {
        $reader = new Annotations\AnnotationReader();

        $loader = new Mapping\Loader\AnnotationLoader($reader);

        return new ClassMetadataFactory($loader);
    }

    protected function buildMetadataFactoryWithAttributeLoader(): ClassMetadataFactory
    {
        $loader = new Mapping\Loader\AttributeLoader();

        return new ClassMetadataFactory($loader);
    }
}
