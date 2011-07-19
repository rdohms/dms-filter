<?php

namespace DMS\Filter;

use Tests\Dummy;

class FilterTest extends \Tests\Testcase
{
    /**
     * @var DMS\Filter\Filter
     */
    protected $filter;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->filter = new Filter($this->buildMetadataFactory());
    }
    
    public function tearDown()
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
        
        $this->filter->Filter($class);
        
        $this->assertNotEquals($classClone->name, $class->name);
        $this->assertEquals($classClone->nickname, $class->nickname);
        $this->assertNotEquals($classClone->description, $class->description);
        
        $this->assertNotContains("<script>", $class->name);
        $this->assertNotContains("<p>", $class->description);
    }
}
