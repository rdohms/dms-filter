<?php

namespace DMS\Filter;

use DMS\Filter\Filters\Loader\FilterLoader;
use DMS\Tests\FilterTestCase;
use DMS\Tests\Dummy;

class FilterTest extends FilterTestCase
{
    /**
     * @var \DMS\Filter\Filter
     */
    protected $filter;

    public function setUp(): void
    {
        parent::setUp();

        $this->filter = new Filter($this->buildMetadataFactory(), new FilterLoader());
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function testFilter()
    {
        $class = new Dummy\Classes\AnnotatedClass();
        $class->name = "Sir Isaac<script></script> Newton";
        $class->nickname = "justaname";
        $class->description = "This is <b>an apple</b>. <p>Isn't it?</p>";

        $classClone = clone $class;

        $this->filter->filterEntity($class);

        $this->assertNotEquals($classClone->name, $class->name);
        $this->assertEquals($classClone->nickname, $class->nickname);
        $this->assertNotEquals($classClone->description, $class->description);

        $this->assertStringNotContainsString("<script>", $class->name);
        $this->assertStringNotContainsString("<p>", $class->description);
    }

    public function testFilterWithParent()
    {
        $class = new Dummy\Classes\ChildAnnotatedClass();
        $class->name = "Sir Isaac<script></script> Newton";
        $class->nickname = "justaname";
        $class->description = "This is <b>an apple</b>. <p>Isn't it?</p>";
        $class->surname = " Surname";

        $classClone = clone $class;

        $this->filter->filterEntity($class);

        $this->assertNotEquals($classClone->name, $class->name);
        $this->assertEquals($classClone->nickname, $class->nickname);
        $this->assertNotEquals($classClone->description, $class->description);
        $this->assertNotEquals($classClone->surname, $class->surname);

        $this->assertStringNotContainsString("<script>", $class->name);
        $this->assertStringNotContainsString("<p>", $class->description);
        $this->assertStringNotContainsString(" ", $class->surname);
    }

    public function testFilterProperty()
    {
        $class = new Dummy\Classes\AnnotatedClass();
        $class->name = "Sir Isaac<script></script> Newton";
        $class->description = "This is <b>an apple</b>. <p>Isn't it?</p>";

        $classClone = clone $class;

        $this->filter->filterProperty($class, 'description');

        $this->assertEquals($classClone->name, $class->name);
        $this->assertNotEquals($classClone->description, $class->description);

        $this->assertStringContainsString("<script>", $class->name);
        $this->assertStringNotContainsString("<p>", $class->description);
    }

    public function testFilterValue()
    {
        $value = "this is <b> a string<p> with<b> tags</p> and malformed";

        $filtered = $this->filter->filterValue($value, new Rules\StripTags());

        $this->assertNotEquals($value, $filtered);

        $this->assertStringNotContainsString('<b>', $filtered);
        $this->assertStringNotContainsString('<p>', $filtered);
    }

    public function testFilterValueWithArray()
    {
        $value = "this is <b> a string<p> with<b> tags</p> and\n malformed";

        $filters = array(new Rules\StripTags(), new Rules\StripNewlines());
        $filtered = $this->filter->filterValue($value, $filters);

        $this->assertNotEquals($value, $filtered);

        $this->assertStringNotContainsString('<b>', $filtered);
        $this->assertStringNotContainsString('<p>', $filtered);
        $this->assertStringNotContainsString('\n', $filtered);
    }

    public function testNotFailOnNull()
    {
        $this->expectNotToPerformAssertions();
        $this->filter->filterEntity(null);
    }

    public function testGetMetadataFactory()
    {
        $this->assertInstanceOf('DMS\Filter\Mapping\ClassMetadataFactory', $this->filter->getMetadataFactory());
    }
}
