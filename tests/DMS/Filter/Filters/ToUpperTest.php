<?php

namespace DMS\Filter\Filters;

use DMS\Filter\Exception\FilterException;
use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\ToUpper as ToUpperRule;

class ToUpperTest extends FilterTestCase
{

    /**
     * @dataProvider provideForRule
     *
     * @param $options
     * @param $value
     * @param $expectedResult
     * @param $useEncoding
     */
    public function testRule($options, $value, $expectedResult, $useEncoding): void
    {
        if ($useEncoding && !function_exists('mb_strtoupper')) {
            $this->markTestSkipped('mbstring extension not enabled');
        }

        $rule   = new ToUpperRule($options);
        $filter = new ToUpper();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function testInvalidEncoding(): void
    {
        $this->expectException(FilterException::class);
        if (! function_exists('mb_strtoupper')) {
            $this->markTestSkipped('mbstring extension not enabled');
        }

        $rule   = new ToUpperRule(['encoding' => 'invalid']);
        $filter = new ToUpper();

        $result = $filter->apply($rule, 'x');
    }

    public function provideForRule(): array
    {
        return [
            [['encoding' => 'utf-8'], "my text", "MY TEXT", true],
            [['encoding' => 'utf-8'], "my ã text", "MY Ã TEXT", true],
            [['encoding' => 'utf-8'], "my á text", "MY Á TEXT", true],
            ['utf-8', "my á text", "MY Á TEXT", true],
            [[], "my text", "MY TEXT", false],
            [[], "my text", "MY TEXT", false],
            [[], null, null, false],
        ];
    }
}
