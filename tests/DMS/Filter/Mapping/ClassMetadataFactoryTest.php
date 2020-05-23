<?php

namespace DMS\Filter\Mapping;

use DMS\Filter\Mapping\Loader\AnnotationLoader;
use DMS\Tests\FilterTestCase;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\ArrayCache;
use DMS\Tests\Dummy\Classes\AnnotatedClass;
use DMS\Filter\Mapping\ClassMetadataInterface;

class ClassMetadataFactoryTest extends FilterTestCase
{

    /**
     * @var ClassMetadataFactory
     */
    protected ClassMetadataFactory $factory;

    public function setUp(): void
{
        parent::setUp();

        $this->factory = $this->buildMetadataFactory();
    }

    public function testGetClassMetadata(): void
    {
        $metadata = $this->factory->getClassMetadata(AnnotatedClass::class);

        $this->assertInstanceOf(ClassMetadataInterface::class, $metadata);
    }

    public function testParsedMetadataFromFactory(): void
    {
        $metadata = $this->factory->getClassMetadata(AnnotatedClass::class);

        $metadataReparsed = $this->factory->getClassMetadata(AnnotatedClass::class);

        $this->assertSame($metadata, $metadataReparsed);
    }

    public function testCachedMetadataFromFactory(): void
    {
        $cache = new ArrayCache();
        $reader = new AnnotationReader();
        $loader = new AnnotationLoader($reader);
        $this->factory = new ClassMetadataFactory($loader, $cache);

        $metadata = $this->factory->getClassMetadata(AnnotatedClass::class);

        $this->assertTrue($cache->contains(ltrim(AnnotatedClass::class, '\\')));

        //Get new Factory to retrieve from cache
        $this->factory = new ClassMetadataFactory($loader, $cache);
        $metadataCached = $this->factory->getClassMetadata(AnnotatedClass::class);

        $this->assertEquals($metadata, $metadataCached);
    }
}
