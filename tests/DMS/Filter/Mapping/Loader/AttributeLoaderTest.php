<?php

declare(strict_types=1);

namespace DMS\Filter\Mapping\Loader;

use DMS\Filter\Mapping\ClassMetadata;
use DMS\Tests\Dummy\Classes\AttributedClass;
use DMS\Tests\FilterTestCase;
use ReflectionProperty;

final class AttributeLoaderTest extends FilterTestCase
{
    public function testLoadMetadata(): void
    {
        $loader   = new AttributeLoader();
        $metadata = new ClassMetadata(AttributedClass::class);

        $loadMetadataResult = $loader->loadClassMetadata($metadata);

        $this->assertTrue($loadMetadataResult);

        $classProperties = array_map(
            fn (ReflectionProperty $property) => $property->getName(),
            $metadata->getReflectionClass()->getProperties()
        );

        $this->assertSame($classProperties, $metadata->getFilteredProperties());
    }
}
