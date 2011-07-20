<?php

namespace DMS\Filter\Rules;

use Tests;

class AlnumTest extends Tests\Testcase
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
        $rule = new Alnum($options);
        
        $result = $rule->applyFilter($value);
        
        $this->assertEquals($expectedResult, $result);
    }
    
    public function provideForRule()
    {
        return array(
            array(false, "My Text", "MyText"),
            array(true, "My Text", "My Text"),
            array(true, "My Text!", "My Text"),
            array(true, "My Text21!", "My Text21"),
            array(true, "João Sorrisão", "João Sorrisão"),
            array(true, "Helgi Þormar Þorbjörnsson", "Helgi Þormar Þorbjörnsson"),
            array(true, "Helgi Þormar!@#$&*( )(*&%$#@Þorbjörnsson", "Helgi Þormar Þorbjörnsson"),
        );
    }
}