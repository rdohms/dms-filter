<?php

namespace DMS\Filter\Rules;

use Tests;

class StripNewlinesTest extends Tests\Testcase
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
        $rule = new StripNewlines($options);
        
        $result = $rule->applyFilter($value);
        
        $this->assertEquals($expectedResult, $result);
    }
    
    public function provideForRule()
    {
        return array(
            array(null, "My \n Text", "My  Text"),
            array(null, "My \n\r Text", "My  Text"),
            array(null, "My \r\n Text", "My  Text"),
            array(null, "My
Text", "MyText"),
        );
    }
}