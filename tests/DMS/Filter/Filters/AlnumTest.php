<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\Alnum as AlnumRule;
use PHPUnit\Framework\Attributes\DataProvider;
use ReflectionException;
use ReflectionProperty;

class AlnumTest extends FilterTestCase
{
    /**
     * @throws ReflectionException
     */
    #[DataProvider('provideForRule')]
    public function testRule(AlnumRule $rule, $value, $expectedResult, $unicodeSetting = null): void
    {
        $filter = new Alnum();

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
            [new AlnumRule(false), "My Text", "MyText", true],
            [new AlnumRule(false), "My Text", "MyText", false],
            [new AlnumRule(true), "My Text", "My Text", true],
            [new AlnumRule(true), "My Text", "My Text", false],
            [new AlnumRule(true), "My Text!", "My Text", true],
            [new AlnumRule(true), "My Text!", "My Text", false],
            [new AlnumRule(true), "My Text21!", "My Text21", true],
            [new AlnumRule(true), "My Text21!", "My Text21", false],
            [new AlnumRule(true), "João Sorrisão", "João Sorrisão", true],
            [new AlnumRule(true), "João Sorrisão", "Joo Sorriso", false],
            [new AlnumRule(true), "GRΣΣK", "GRΣΣK", true],
            [new AlnumRule(true), "GRΣΣK", "GRK", false],
            [new AlnumRule(true), "Helgi Þormar Þorbjörnsson", "Helgi Þormar Þorbjörnsson", true],
            [new AlnumRule(true), "Helgi Þormar Þorbjörnsson", "Helgi ormar orbjrnsson", false],
            [new AlnumRule(true), "Helgi Þormar!@#$&*( )(*&%$#@Þorbjörnsson", "Helgi Þormar Þorbjörnsson", true],
            [new AlnumRule(true), "Helgi Þormar!@#$&*( )(*&%$#@Þorbjörnsson", "Helgi ormar orbjrnsson", false],
            [new AlnumRule(true), null, null, false],
        ];
    }
}
