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
use DMS\Filter\Rules\Rule;

class RuleTest extends FilterTestCase
{

    public function testConstructorHappyPath(): void
    {
        $rule = new NoOptionsRule();

        $this->assertInstanceOf(Rule::class, $rule);
    }

    public function testConstructorDefaultOption(): void
    {
        $rule = new DefaultOptionRule('value');

        $this->assertInstanceOf(Rule::class, $rule);
    }

    public function testConstructorDefaultOptionInArray(): void
    {
        $rule = new DefaultOptionRule(['value' => 'optionvalue']);

        $this->assertInstanceOf(Rule::class, $rule);
    }

    public function testConstructorHappyPathWithRequired(): void
    {
        $rule = new RequiredOptionsRule(['config' => 'value', 'path' => '/path/to/']);

        $this->assertInstanceOf(Rule::class, $rule);
    }

    public function testConstructorNoDefinedDefaultOption(): void
    {
        $this->expectException(RuleDefinitionException::class);
        $rule = new NoOptionsRule('value');

        $this->assertInstanceOf(Rule::class, $rule);
    }

    public function testConstructorInvalidOption(): void
    {
        $this->expectException(InvalidOptionsException::class);
        $rule = new MultipleOptionsRule(['invalid' => 'option']);
    }

    public function testConstructorInvalidDefaultOption(): void
    {
        $this->expectException(InvalidOptionsException::class);
        $rule = new InvalidDefaultOptionRule('value');
    }

    public function testConstructorMissingOption(): void
    {
        $this->expectException(MissingOptionsException::class);
        $rule = new RequiredOptionsRule(['config' => 'option']);
    }

    public function testOptionExceptionInformation(): void
    {
        try {
            $rule = new MultipleOptionsRule(['invalid' => 'option']);
        } catch (InvalidOptionsException $e) {
            $this->assertIsArray($e->getOptions());

            $this->assertContains('invalid', $e->getOptions());
        }
    }
}
