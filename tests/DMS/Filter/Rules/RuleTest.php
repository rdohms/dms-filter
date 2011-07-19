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
        $rule = new Dummy\Rules\NoOptionsRule();
        
        $this->assertInstanceOf('DMS\Filter\Rules\Rule', $rule);
    }
    
    public function testConstructorDefaultOption()
    {
        $rule = new Dummy\Rules\DefaultOptionRule('value');
        
        $this->assertInstanceOf('DMS\Filter\Rules\Rule', $rule);
    }
    
    public function testConstructorDefaultOptionInArray()
    {
        $rule = new Dummy\Rules\DefaultOptionRule(array('value' => 'optionvalue'));
        
        $this->assertInstanceOf('DMS\Filter\Rules\Rule', $rule);
    }
    
    public function testConstructorHappyPathWithRequired()
    {
        $rule = new Dummy\Rules\RequiredOptionsRule(array('config' => 'value', 'path' => '/path/to/'));
        
        $this->assertInstanceOf('DMS\Filter\Rules\Rule', $rule);  
    }
    
    /**
     * @expectedException DMS\Filter\Exception\RuleDefinitionException
     */
    public function testConstructorNoDefinedDefaultOption()
    {
        $rule = new Dummy\Rules\NoOptionsRule('value');
        
        $this->assertInstanceOf('DMS\Filter\Rules\Rule', $rule);
    }

    /**
     * @expectedException DMS\Filter\Exception\InvalidOptionsException
     */
    public function testConstructorInvalidOption()
    {
        $rule = new Dummy\Rules\MultipleOptionsRule(array('invalid' => 'option'));
    }

    /**
     * @expectedException DMS\Filter\Exception\InvalidOptionsException
     */
    public function testConstructorInvalidDefaultOption()
    {
        $rule = new Dummy\Rules\InvalidDefaultOptionRule('value');
    }

    /**
     * @expectedException DMS\Filter\Exception\MissingOptionsException
     */
    public function testConstructorMissingOption()
    {
        $rule = new Dummy\Rules\RequiredOptionsRule(array('config' => 'option'));
    }
    
    
    public function testOptionExceptionInformation()
    {
        try {
            $rule = new Dummy\Rules\MultipleOptionsRule(array('invalid' => 'option'));
        } catch (\DMS\Filter\Exception\InvalidOptionsException $e) {
            
            $this->assertInternalType('array', $e->getOptions());
            
            $this->assertContains('invalid', $e->getOptions());
            
        }
    }
}