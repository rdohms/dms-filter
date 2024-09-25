<?php

namespace DMS\Tests;

use DMS\Filter\Mapping;
use DMS\Filter\Mapping\ClassMetadataFactory;
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

    protected static function buildMetadataFactoryWithAttributeLoader(): ClassMetadataFactory
    {
        $loader = new Mapping\Loader\AttributeLoader();

        return new ClassMetadataFactory($loader);
    }
}
