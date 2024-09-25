<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\FloatScalar as FloatRule;
use PHPUnit\Framework\Attributes\DataProvider;

class FloatTest extends FilterTestCase
{
    #[DataProvider('provideForRule')]
    public function testRule(FloatRule $rule, $value, $expectedResult): void
    {
        $filter = new FloatScalar();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public static function provideForRule(): array
    {
        return [
            [new FloatRule(), "My Text", 0.0],
            [new FloatRule(), "21", 21.0],
            [new FloatRule(), "21.2", 21.2],
            [new FloatRule(), 21.9, 21.9],
        ];
    }
}
