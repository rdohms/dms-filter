<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\Digits as DigitsRule;
use PHPUnit\Framework\Attributes\DataProvider;
use ReflectionException;
use ReflectionProperty;

class DigitsTest extends FilterTestCase
{
    /**
     * @throws ReflectionException
     */
    #[DataProvider('provideForRule')]
    public function testRule(DigitsRule $rule, $value, $expectedResult, $unicodeSetting = null): void
    {
        $filter = new Digits();

        if ($unicodeSetting !== null) {
            $property = new ReflectionProperty($filter, 'unicodeEnabled');
            $property->setAccessible(true);
            $property->setValue($filter, $unicodeSetting);
        }

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public static function provideForRule(): array
    {
        return [
            [new DigitsRule(false), "My Text", ""],
            [new DigitsRule(false), "001 t55", "00155"],
            [new DigitsRule(true), "My 23 dogs", " 23 "],
            [new DigitsRule(false), "My 23 dogs", "23"],
            [new DigitsRule(true), "233 055", "233 055", true],
            [new DigitsRule(true), "233 055", "233 055", false],
            [new DigitsRule(true), "233 t055s", "233 055"],
            [new DigitsRule(true), "My Text21!", " 21"], //TODO verify this.
            [new DigitsRule(true), "João Sorrisão", " ", true],
            [new DigitsRule(true), "João Sorrisão", " ", false],
            [new DigitsRule(true), "001Helgi Þormar Þorbjörnsson", "001  ", true],
            [new DigitsRule(true), "001Helgi Þormar Þorbjörnsson", "001  ", false],
        ];
    }
}
