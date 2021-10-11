<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\Alnum as AlnumRule;
use ReflectionProperty;

class AlnumTest extends FilterTestCase
{

    /**
     * @dataProvider provideForRule
     *
     * @param      $options
     * @param      $value
     * @param      $expectedResult
     * @param null $unicodeSetting
     *
     * @throws \ReflectionException
     */
    public function testRule($options, $value, $expectedResult, $unicodeSetting = null): void
    {
        $rule   = new AlnumRule($options);
        $filter = new Alnum();

        if ($unicodeSetting !== null) {
            $property = new ReflectionProperty($filter, 'unicodeEnabled');
            $property->setAccessible(true);
            $property->setValue($filter, $unicodeSetting);
        }

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function provideForRule(): array
    {
        return [
            [false, "My Text", "MyText", true],
            [false, "My Text", "MyText", false],
            [true, "My Text", "My Text", true],
            [true, "My Text", "My Text", false],
            [true, "My Text!", "My Text", true],
            [true, "My Text!", "My Text", false],
            [true, "My Text21!", "My Text21", true],
            [true, "My Text21!", "My Text21", false],
            [true, "João Sorrisão", "João Sorrisão", true],
            [true, "João Sorrisão", "Joo Sorriso", false],
            [true, "GRΣΣK", "GRΣΣK", true],
            [true, "GRΣΣK", "GRK", false],
            [true, "Helgi Þormar Þorbjörnsson", "Helgi Þormar Þorbjörnsson", true],
            [true, "Helgi Þormar Þorbjörnsson", "Helgi ormar orbjrnsson", false],
            [true, "Helgi Þormar!@#$&*( )(*&%$#@Þorbjörnsson", "Helgi Þormar Þorbjörnsson", true],
            [true, "Helgi Þormar!@#$&*( )(*&%$#@Þorbjörnsson", "Helgi ormar orbjrnsson", false],
            [true, null, null, false],
        ];
    }
}
