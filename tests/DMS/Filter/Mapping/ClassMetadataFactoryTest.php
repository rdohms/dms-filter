<?php

namespace DMS\Filter\Mapping;

use DMS\Tests\FilterTestCase;
use Doctrine\Common\Cache\ArrayCache;

class ClassMetadataFactoryTest extends FilterTestCase
{

    /**
     * @var ClassMetadataFactory
     */
    protected $factory;

    public function setUp(): void
{
        parent::setUp();

        $this->factory = $this->buildMetadataFactory();
    }

    public function tearDown(): void
{
        parent::tearDown();
    }

    public function testGetClassMetadata()
    {
        $metadata = $this->factory->getClassMetadata('DMS\Tests\Dummy\Classes\AnnotatedClass');

        $this->assertInstanceOf('DMS\Filter\Mapping\ClassMetadataInterface', $metadata);
    }

    public function testParsedMetadataFromFactory()
    {
        $metadata = $this->factory->getClassMetadata('DMS\Tests\Dummy\Classes\AnnotatedClass');

        $metadataReparsed = $this->factory->getClassMetadata('DMS\Tests\Dummy\Classes\AnnotatedClass');

        $this->assertSame($metadata, $metadataReparsed);
    }

    public function testCachedMetadataFromFactory()
    {
        $cache = new ArrayCache();

        $this->factory = new ClassMetadataFactory($this->loader, $cache);

        $metadata = $this->factory->getClassMetadata('DMS\Tests\Dummy\Classes\AnnotatedClass');

        $this->assertTrue($cache->contains(ltrim('DMS\Tests\Dummy\Classes\AnnotatedClass', '\\')));

        //Get new Factory to retrieve from cache
        $this->factory = new ClassMetadataFactory($this->loader, $cache);
        $metadataCached = $this->factory->getClassMetadata('DMS\Tests\Dummy\Classes\AnnotatedClass');

        $this->assertEquals($metadata, $metadataCached);
    }
}
