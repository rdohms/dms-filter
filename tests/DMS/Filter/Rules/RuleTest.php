<?php

namespace DMS\Filter\Rules;

use DMS\Tests\Dummy\Rules\DefaultOptionRule;
use DMS\Tests\Dummy\Rules\NoOptionsRule;
use DMS\Tests\Dummy\Rules\RequiredOptionsRule;
use DMS\Tests\FilterTestCase;

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
}
