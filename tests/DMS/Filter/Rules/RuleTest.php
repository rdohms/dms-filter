<?php

namespace DMS\Filter\Rules;

use DMS\Filter\Exception\InvalidOptionsException;
use DMS\Filter\Exception\MissingOptionsException;
use DMS\Filter\Exception\RuleDefinitionException;
use DMS\Tests\Dummy\Rules\DefaultOptionRule;
use DMS\Tests\Dummy\Rules\InvalidDefaultOptionRule;
use DMS\Tests\Dummy\Rules\MultipleOptionsRule;
use DMS\Tests\Dummy\Rules\NoOptionsRule;
use DMS\Tests\Dummy\Rules\RequiredOptionsRule;
use DMS\Tests\FilterTestCase;

class RuleTest extends FilterTestCase
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
        $rule = new NoOptionsRule();

        $this->assertInstanceOf('DMS\Filter\Rules\Rule', $rule);
    }

    public function testConstructorDefaultOption()
    {
        $rule = new DefaultOptionRule('value');

        $this->assertInstanceOf('DMS\Filter\Rules\Rule', $rule);
    }

    public function testConstructorDefaultOptionInArray()
    {
        $rule = new DefaultOptionRule(array('value' => 'optionvalue'));

        $this->assertInstanceOf('DMS\Filter\Rules\Rule', $rule);
    }

    public function testConstructorHappyPathWithRequired()
    {
        $rule = new RequiredOptionsRule(array('config' => 'value', 'path' => '/path/to/'));

        $this->assertInstanceOf('DMS\Filter\Rules\Rule', $rule);
    }

    /**
     * @expectedException DMS\Filter\Exception\RuleDefinitionException
     */
    public function testConstructorNoDefinedDefaultOption()
    {
        $rule = new NoOptionsRule('value');

        $this->assertInstanceOf('DMS\Filter\Rules\Rule', $rule);
    }

    /**
     * @expectedException DMS\Filter\Exception\InvalidOptionsException
     */
    public function testConstructorInvalidOption()
    {
        $rule = new MultipleOptionsRule(array('invalid' => 'option'));
    }

    /**
     * @expectedException DMS\Filter\Exception\InvalidOptionsException
     */
    public function testConstructorInvalidDefaultOption()
    {
        $rule = new InvalidDefaultOptionRule('value');
    }

    /**
     * @expectedException DMS\Filter\Exception\MissingOptionsException
     */
    public function testConstructorMissingOption()
    {
        $rule = new RequiredOptionsRule(array('config' => 'option'));
    }

    public function testOptionExceptionInformation()
    {
        try {
            $rule = new MultipleOptionsRule(array('invalid' => 'option'));
        } catch (InvalidOptionsException $e) {

            $this->assertInternalType('array', $e->getOptions());

            $this->assertContains('invalid', $e->getOptions());

        }
    }
}
