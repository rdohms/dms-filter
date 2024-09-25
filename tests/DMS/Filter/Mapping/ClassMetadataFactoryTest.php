<?php

namespace DMS\Filter\Mapping;

use DMS\Filter\Mapping\Loader\AttributeLoader;
use DMS\Filter\Mapping\Loader\LoaderInterface;
use DMS\Tests\Dummy\Classes\AttributedClass;
use DMS\Tests\FilterTestCase;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

class ClassMetadataFactoryTest extends FilterTestCase
{
    #[DataProvider('factoryDataProvider')]
    public function testGetClassMetadata(ClassMetadataFactory $factory, $class): void
    {
        $metadata = $factory->getClassMetadata($class);

        $this->assertInstanceOf(ClassMetadataInterface::class, $metadata);
    }

    /**
     * @throws InvalidArgumentException
     */
    #[DataProvider('factoryDataProvider')]
    public function testParsedMetadataFromFactory(ClassMetadataFactory $factory, $class): void
    {
        $metadata = $factory->getClassMetadata($class);

        $metadataReparsed = $factory->getClassMetadata($class);

        $this->assertSame($metadata, $metadataReparsed);
    }

    /**
     * @throws InvalidArgumentException
     */
    #[DataProvider('loaderDataProvider')]
    public function testCachedMetadataFromFactory(LoaderInterface $loader, $class): void
    {
        $cache = new ArrayAdapter();
        $factory = new ClassMetadataFactory($loader, $cache);

        $metadata = $factory->getClassMetadata($class);

        $this->assertTrue($cache->getItem(ltrim($class, '\\'))->isHit());

        //Get new Factory to retrieve from cache
        $factory = new ClassMetadataFactory($loader, $cache);
        $metadataCached = $factory->getClassMetadata($class);

        $this->assertEquals($metadata, $metadataCached);
    }

    public static function factoryDataProvider(): Generator
    {
        yield 'Attribute' => [
            self::buildMetadataFactoryWithAttributeLoader(),
            AttributedClass::class,
        ];
    }

    public static function loaderDataProvider(): Generator
    {
        yield 'Attribute' => [
            new AttributeLoader(),
            AttributedClass::class,
        ];
    }
}
