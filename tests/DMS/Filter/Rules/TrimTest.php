<?php

namespace DMS\Filter\Rules;

use Tests;

class TrimTest extends Tests\Testcase
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
        $rule = new Trim($options);
        
        $result = $rule->applyFilter($value);
        
        $this->assertEquals($expectedResult, $result);
    }
    
    public function provideForRule()
    {
        return array(
            array(array(), " my text", "my text"),
            array(array(), " my text ", "my text"),
            array(array(), "my text ", "my text"),
            array(array('charlist' => "\\"), "\my text", "my text"),
            array("\\", "\my text", "my text"),
            array("x", "xmy textx", "my text"),
        );
    }
}