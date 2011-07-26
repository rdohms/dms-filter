<?php

namespace DMS\Filter\Rules;

use Tests;

class ToLowerTest extends Tests\Testcase
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
    public function testRule($options, $value, $expectedResult, $useEncoding)
    {
        if ($useEncoding && !function_exists('mb_strtolower')) {
            $this->markTestSkipped ('mbstring extension not enabled');
        }
        
        $rule = new ToLower($options);
        
        $result = $rule->applyFilter($value);
        
        $this->assertEquals($expectedResult, $result);
    }
    
    /**
     * @expectedException \DMS\Filter\Exception\FilterException
     */
    public function testInvalidEncoding()
    {
        if ( ! function_exists('mb_strtolower')) {
            $this->markTestSkipped ('mbstring extension not enabled');
        }
        
        $rule = new ToLower(array('encoding' => 'invalid'));
        $result = $rule->applyFilter('x');
    }
    
    public function provideForRule()
    {
        return array(
            array(array('encoding' => 'utf-8'), "MY TEXT", "my text", true),
            array(array('encoding' => 'utf-8'), "MY Ã TEXT", "my ã text", true),
            array(array('encoding' => 'utf-8'), "MY Á TEXT", "my á text", true),
            array('utf-8', "MY Á TEXT", "my á text", true),
            array(array(), "MY TEXT", "my text", false ),
            array(array(), "MY TEXT", "my text", false ),
        );
    }
}