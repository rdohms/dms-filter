<?php

namespace DMS\Filter\Rules;

use Tests,
    Tests\Dummy;

class RuleTest extends Tests\Testcase
{
    
    public function setUp()
    {
        parent::setUp();
    }
    
    public function tearDown()
    {
        parent::tearDown();
    }
    
    public function testConstructorHappyPath()
    {
        $rule = new Dummy\Rules\HappyPathRule();
        
        $this->assertInstanceOf('DMS\Filter\Rules\Rule', $rule);
    }

    /**
     * @expectedException DMS\Filter\Exception\InvalidOptionsException
     */
    public function testConstructorInvalidOption()
    {
        $rule = new Dummy\Rules\HappyPathRule(array('invalid' => 'option'));
    }
    
}