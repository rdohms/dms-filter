<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\Digits as DigitsRule;
use ReflectionProperty;

class DigitsTest extends FilterTestCase
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
        $rule   = new DigitsRule($options);
        $filter = new Digits();

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
            [false, "My Text", ""],
            [false, "001 t55", "00155"],
            [true, "My 23 dogs", " 23 "],
            [false, "My 23 dogs", "23"],
            [true, "233 055", "233 055", true],
            [true, "233 055", "233 055", false],
            [true, "233 t055s", "233 055"],
            [true, "My Text21!", " 21"], //TODO verify this.
            [true, "João Sorrisão", " ", true],
            [true, "João Sorrisão", " ", false],
            [true, "001Helgi Þormar Þorbjörnsson", "001  ", true],
            [true, "001Helgi Þormar Þorbjörnsson", "001  ", false],
        ];
    }
}
