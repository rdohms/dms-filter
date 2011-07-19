<?php

namespace DMS\Filter\Rules;

use Tests;

class StripTagsRule extends Tests\Testcase
{
    
    public function setUp()
    {
        parent::setUp();
    }
    
    public function tearDown()
    {
        parent::tearDown();
    }
    
    /**
     * @dataProvider provideForRule
     */
    public function testRule($options, $value, $expectedResult)
    {
        $rule = new StripTags($options);
        
        $result = $rule->applyFilter($value);
        
        $this->assertEquals($expectedResult, $result);
    }
    
    public function provideForRule()
    {
        return array(
            array(array(), "<b>my text</b>", "my text"),
            array(array('allowed' => "<p>"), "<b><p>my text</p></b>", "<p>my text</p>"),
            array("<p>", "<b><p>my text</p></b>", "<p>my text</p>"),
        );
    }
}