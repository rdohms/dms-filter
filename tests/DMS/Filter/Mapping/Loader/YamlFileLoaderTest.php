<?php

namespace DMS\Filter\Filters\Mapping\Loader;

use DMS\Filter\Mapping\Loader\YamlFileLoader;
use DMS\Filter\Mapping\ClassMetadata;
use DMS\Filter\Rules\Callback;
use DMS\Filter\Rules\StripTags;
use DMS\Filter\Rules\Zend;

class YamlFileLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadClassMetadataReturnsFalseIfEmpty()
    {
        $loader = new YamlFileLoader(__DIR__.'/empty-mapping.yml');
        $metadata = new ClassMetadata('DMS\Tests\Dummy\Classes\AnnotatedClass');

        $this->assertFalse($loader->loadClassMetadata($metadata));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLoadClassMetadataThrowsExceptionIfNotAnArray()
    {
        $loader = new YamlFileLoader(__DIR__.'/nonvalid-mapping.yml');
        $metadata = new ClassMetadata('DMS\Tests\Dummy\Classes\AnnotatedClass');
        $loader->loadClassMetadata($metadata);
    }

    public function testLoadClassMetadataReturnsTrueIfSuccessful()
    {
        $loader = new YamlFileLoader(__DIR__.'/filter-mapping.yml');
        $metadata = new ClassMetadata('DMS\Tests\Dummy\Classes\AnnotatedClass');

        $this->assertTrue($loader->loadClassMetadata($metadata));
    }

    public function testLoadClassMetadataReturnsFalseIfNotSuccessful()
    {
        $loader = new YamlFileLoader(__DIR__.'/filter-mapping.yml');
        $metadata = new ClassMetadata('\stdClass');

        $this->assertFalse($loader->loadClassMetadata($metadata));
    }

    public function testLoadClassMetadata()
    {
        $loader = new YamlFileLoader(__DIR__.'/filter-mapping.yml');
        $metadata = new ClassMetadata('DMS\Tests\Dummy\Classes\AnnotatedClass');

        $loader->loadClassMetadata($metadata);

        $expected = new ClassMetadata('DMS\Tests\Dummy\Classes\AnnotatedClass');
        $expected->addPropertyRule('name', new StripTags());
        $expected->addPropertyRule('nickname', new StripTags());
        $expected->addPropertyRule('description', new StripTags('<b><i>'));
        $expected->addPropertyRule('callback', new Callback('callbackMethod'));
        $expected->addPropertyRule('callback2', new Callback(array("DMS\\Tests\\Dummy\\Classes\\AnnotatedClass", "anotherCallback")));
        $expected->addPropertyRule('zend', new Zend('StringToLower'));
        $expected->addPropertyRule('zendalternate', new Zend(array(
            'class' => 'Boolean',
            'zendOptions' => array('casting' => false),
        )));

        $this->assertEquals($expected, $metadata);
    }
}