<?php

namespace DMS\Filter\Filters;

use DMS\Filter\Exception\FilterException;
use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\ToLower as ToLowerRule;

class ToLowerTest extends FilterTestCase
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
        if ($useEncoding && !function_exists('mb_strtolower')) {
            $this->markTestSkipped('mbstring extension not enabled');
        }

        $rule   = new ToLowerRule($options);
        $filter = new ToLower();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function testInvalidEncoding(): void
    {
        $this->expectException(FilterException::class);
        if (! function_exists('mb_strtolower')) {
            $this->markTestSkipped('mbstring extension not enabled');
        }

        $rule = new ToLowerRule(['encoding' => 'invalid']);
        $filter = new ToLower();

        $result = $filter->apply($rule, 'x');
    }

    public function provideForRule(): array
    {
        return [
            [['encoding' => 'utf-8'], "MY TEXT", "my text", true],
            [['encoding' => 'utf-8'], "MY Ã TEXT", "my ã text", true],
            [['encoding' => 'utf-8'], "MY Á TEXT", "my á text", true],
            ['utf-8', "MY Á TEXT", "my á text", true],
            [[], "MY TEXT", "my text", false],
            [[], "MY TEXT", "my text", false],
            [[], null, null, false],
        ];
    }
}
