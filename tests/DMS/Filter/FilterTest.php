<?php

namespace DMS\Filter;

use DMS\Filter\Filters\Loader\FilterLoader;
use DMS\Tests\FilterTestCase;
use DMS\Tests\Dummy;
use DMS\Filter\Mapping\ClassMetadataFactory;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;

class FilterTest extends FilterTestCase
{
    #[DataProvider('filterClassDataProvider')]
    public function testFilter(Filter $filter, $class): void
    {
        $class->name = "Sir Isaac<script></script> Newton";
        $class->nickname = "justaname";
        $class->description = "This is <b>an apple</b>. <p>Isn't it?</p>";

        $classClone = clone $class;

        $filter->filterEntity($class);

        $this->assertNotEquals($classClone->name, $class->name);
        $this->assertEquals($classClone->nickname, $class->nickname);
        $this->assertNotEquals($classClone->description, $class->description);

        $this->assertStringNotContainsString("<script>", $class->name);
        $this->assertStringNotContainsString("<p>", $class->description);
    }

    #[DataProvider('filterChildClassDataProvider')]
    public function testFilterWithParent(Filter $filter, $class): void
    {
        $class->name = "Sir Isaac<script></script> Newton";
        $class->nickname = "justaname";
        $class->description = "This is <b>an apple</b>. <p>Isn't it?</p>";
        $class->surname = " Surname";

        $classClone = clone $class;

        $filter->filterEntity($class);

        $this->assertNotEquals($classClone->name, $class->name);
        $this->assertEquals($classClone->nickname, $class->nickname);
        $this->assertNotEquals($classClone->description, $class->description);
        $this->assertNotEquals($classClone->surname, $class->surname);

        $this->assertStringNotContainsString("<script>", $class->name);
        $this->assertStringNotContainsString("<p>", $class->description);
        $this->assertStringNotContainsString(" ", $class->surname);
    }

    #[DataProvider('filterClassDataProvider')]
    public function testFilterProperty(Filter $filter, $class): void
    {
        $class->name = "Sir Isaac<script></script> Newton";
        $class->description = "This is <b>an apple</b>. <p>Isn't it?</p>";

        $classClone = clone $class;

        $filter->filterProperty($class, 'description');

        $this->assertEquals($classClone->name, $class->name);
        $this->assertNotEquals($classClone->description, $class->description);

        $this->assertStringContainsString("<script>", $class->name);
        $this->assertStringNotContainsString("<p>", $class->description);
    }

    #[DataProvider('filterDataProvider')]
    public function testFilterValue(Filter $filter): void
    {
        $value = "this is <b> a string<p> with<b> tags</p> and malformed";

        $filtered = $filter->filterValue($value, new Rules\StripTags());

        $this->assertNotEquals($value, $filtered);

        $this->assertStringNotContainsString('<b>', $filtered);
        $this->assertStringNotContainsString('<p>', $filtered);
    }

    #[DataProvider('filterDataProvider')]
    public function testFilterValueWithArray(Filter $filter): void
    {
        $value = "this is <b> a string<p> with<b> tags</p> and\n malformed";

        $filters = [new Rules\StripTags(), new Rules\StripNewlines()];
        $filtered = $filter->filterValue($value, $filters);

        $this->assertNotEquals($value, $filtered);

        $this->assertStringNotContainsString('<b>', $filtered);
        $this->assertStringNotContainsString('<p>', $filtered);
        $this->assertStringNotContainsString('\n', $filtered);
    }

    #[DataProvider('filterDataProvider')]
    public function testNotFailOnNull(Filter $filter): void
    {
        $this->expectNotToPerformAssertions();
        $filter->filterEntity(null);
    }

    #[DataProvider('filterDataProvider')]
    public function testGetMetadataFactory(Filter $filter): void
    {
        $this->assertInstanceOf(ClassMetadataFactory::class, $filter->getMetadataFactory());
    }

    public static function filterClassDataProvider(): Generator
    {
        yield 'Attribute' => [
            new Filter(self::buildMetadataFactoryWithAttributeLoader(), new FilterLoader()),
            new Dummy\Classes\AttributedClass(),
        ];
    }

    public static function filterChildClassDataProvider(): Generator
    {
        yield 'Attribute' => [
            new Filter(self::buildMetadataFactoryWithAttributeLoader(), new FilterLoader()),
            new Dummy\Classes\ChildAttributedClass(),
        ];
    }

    public static function filterDataProvider(): Generator
    {
        yield 'Attribute' => [
            new Filter(self::buildMetadataFactoryWithAttributeLoader(), new FilterLoader()),
        ];
    }
}
