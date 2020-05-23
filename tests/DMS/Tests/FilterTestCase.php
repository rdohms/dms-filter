<?php

namespace DMS\Tests;

use DMS\Filter\Mapping;
use DMS\Filter\Mapping\ClassMetadataFactory;
use Doctrine\Common\Annotations;
use PHPUnit\Framework\TestCase;

class FilterTestCase extends TestCase
{
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->buildMetadataFactory();
    }

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    protected function buildMetadataFactory(): ClassMetadataFactory
    {
        $reader = new Annotations\AnnotationReader();

        $loader = new Mapping\Loader\AnnotationLoader($reader);

        return new ClassMetadataFactory($loader);
    }
}
