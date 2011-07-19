<?php

namespace DMS\Filter\Rules;

use Tests;

class BooleanTest extends Tests\Testcase
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
        $rule = new Boolean($options);
        
        $result = $rule->applyFilter($value);
        
        $this->assertEquals($expectedResult, $result);
    }
    
    public function provideForRule()
    {
        return array(
            array(null, "My Text", true),
            array(null, "", false),
            array(null, NULL, false),
            array(null, 21.9, true),
            array(null, 21, true),
            array(null, 0, false),
        );
    }
}