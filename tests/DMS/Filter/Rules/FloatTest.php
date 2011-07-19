<?php

namespace DMS\Filter\Rules;

use Tests;

class FloatTest extends Tests\Testcase
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
        $rule = new Float($options);
        
        $result = $rule->applyFilter($value);
        
        $this->assertEquals($expectedResult, $result);
    }
    
    public function provideForRule()
    {
        return array(
            array(null, "My Text", 0.0),
            array(null, "21", 21.0),
            array(null, "21.2", 21.2),
            array(null, 21.9, 21.9),
        );
    }
}