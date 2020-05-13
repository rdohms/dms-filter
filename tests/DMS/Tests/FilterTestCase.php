<?php

namespace DMS\Tests;

use DMS\Filter\Mapping;
use Doctrine\Common\Annotations;
use PHPUnit\Framework\TestCase;

class FilterTestCase extends TestCase
{
    protected $loader;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
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
