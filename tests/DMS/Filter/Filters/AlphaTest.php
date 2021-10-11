<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\Alpha as AlphaRule;
use ReflectionProperty;

class AlphaTest extends FilterTestCase
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
        $rule   = new AlphaRule($options);
        $filter = new Alpha();

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
            [true, "My Text21!", "My Text", true],
            [true, "My Text21!", "My Text", false],
            [true, "João 2Sorrisão", "João Sorrisão", true],
            [true, "João 2Sorrisão", "Joo Sorriso", false],
            [true, "Helgi Þormar Þorbjörnsson", "Helgi Þormar Þorbjörnsson", true],
            [true, "Helgi Þormar Þorbjörnsson", "Helgi ormar orbjrnsson", false],
            [true, "Helgi Þormar!@#$&*( )(*&%$#@Þorbjörnsson", "Helgi Þormar Þorbjörnsson", true],
            [true, "Helgi Þormar!@#$&*( )(*&%$#@Þorbjörnsson", "Helgi ormar orbjrnsson", false],
            [true, null, null, false],
        ];
    }
}
