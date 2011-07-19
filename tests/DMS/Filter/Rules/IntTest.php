<?php

namespace DMS\Filter\Rules;

use Tests;

class IntTest extends Tests\Testcase
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
        $rule = new Int($options);
        
        $result = $rule->applyFilter($value);
        
        $this->assertEquals($expectedResult, $result);
    }
    
    public function provideForRule()
    {
        return array(
            array(null, "My Text", 0),
            array(null, true, 1),
            array(null, "21", 21),
            array(null, "21.2", 21),
            array(null, "21.9", 21),
            array(null, 21.9, 21),
        );
    }
}