<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\Alpha as AlphaRule;
use PHPUnit\Framework\Attributes\DataProvider;
use ReflectionException;
use ReflectionProperty;

class AlphaTest extends FilterTestCase
{
    /**
     * @throws ReflectionException
     */
    #[DataProvider('provideForRule')]
    public function testRule(AlphaRule $rule, $value, $expectedResult, $unicodeSetting = null): void
    {
        $filter = new Alpha();

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
            [new AlphaRule(false), "My Text", "MyText", true],
            [new AlphaRule(false), "My Text", "MyText", false],
            [new AlphaRule(true), "My Text", "My Text", true],
            [new AlphaRule(true), "My Text", "My Text", false],
            [new AlphaRule(true), "My Text!", "My Text", true],
            [new AlphaRule(true), "My Text!", "My Text", false],
            [new AlphaRule(true), "My Text21!", "My Text", true],
            [new AlphaRule(true), "My Text21!", "My Text", false],
            [new AlphaRule(true), "João 2Sorrisão", "João Sorrisão", true],
            [new AlphaRule(true), "João 2Sorrisão", "Joo Sorriso", false],
            [new AlphaRule(true), "Helgi Þormar Þorbjörnsson", "Helgi Þormar Þorbjörnsson", true],
            [new AlphaRule(true), "Helgi Þormar Þorbjörnsson", "Helgi ormar orbjrnsson", false],
            [new AlphaRule(true), "Helgi Þormar!@#$&*( )(*&%$#@Þorbjörnsson", "Helgi Þormar Þorbjörnsson", true],
            [new AlphaRule(true), "Helgi Þormar!@#$&*( )(*&%$#@Þorbjörnsson", "Helgi ormar orbjrnsson", false],
            [new AlphaRule(true), null, null, false],
        ];
    }
}
