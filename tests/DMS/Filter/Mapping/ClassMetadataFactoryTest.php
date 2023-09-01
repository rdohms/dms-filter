<?php

namespace DMS\Filter\Mapping;

use DMS\Filter\Mapping\Loader\AnnotationLoader;
use DMS\Filter\Mapping\Loader\AttributeLoader;
use DMS\Filter\Mapping\Loader\LoaderInterface;
use DMS\Tests\Dummy\Classes\AttributedClass;
use DMS\Tests\FilterTestCase;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\ArrayCache;
use DMS\Tests\Dummy\Classes\AnnotatedClass;
use Generator;

class ClassMetadataFactoryTest extends FilterTestCase
{
    /**
     * @dataProvider factoryDataProvider
     */
    public function testGetClassMetadata(ClassMetadataFactory $factory, $class): void
    {
        $metadata = $factory->getClassMetadata($class);

        $this->assertInstanceOf(ClassMetadataInterface::class, $metadata);
    }

    /**
     * @dataProvider factoryDataProvider
     */
    public function testParsedMetadataFromFactory(ClassMetadataFactory $factory, $class): void
    {
        $metadata = $factory->getClassMetadata($class);

        $metadataReparsed = $factory->getClassMetadata($class);

        $this->assertSame($metadata, $metadataReparsed);
    }

    /**
     * @dataProvider loaderDataProvider
     */
    public function testCachedMetadataFromFactory(LoaderInterface $loader, $class): void
    {
        $cache = new ArrayCache();
        $factory = new ClassMetadataFactory($loader, $cache);

        $metadata = $factory->getClassMetadata($class);

        $this->assertTrue($cache->contains(ltrim($class, '\\')));

        //Get new Factory to retrieve from cache
        $factory = new ClassMetadataFactory($loader, $cache);
        $metadataCached = $factory->getClassMetadata($class);

        $this->assertEquals($metadata, $metadataCached);
    }

    public function factoryDataProvider(): Generator
    {
        yield 'Annotation' => [
            $this->buildMetadataFactoryWithAnnotationLoader(),
            AnnotatedClass::class,
        ];

        yield 'Attribute' => [
            $this->buildMetadataFactoryWithAttributeLoader(),
            AttributedClass::class,
        ];
    }
    
    public function loaderDataProvider(): Generator
    {
        yield 'Annotation' => [
            new AnnotationLoader(new AnnotationReader()),
            AnnotatedClass::class,
        ];

        yield 'Attribute' => [
            new AttributeLoader(),
            AttributedClass::class,
        ];
    }
}
