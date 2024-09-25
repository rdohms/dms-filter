<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\IntScalar as IntRule;
use PHPUnit\Framework\Attributes\DataProvider;

class IntTest extends FilterTestCase
{
    #[DataProvider('provideForRule')]
    public function testRule(IntRule $rule, $value, $expectedResult): void
    {
        $filter = new IntScalar();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public static function provideForRule(): array
    {
        return [
            [new IntRule(), "My Text", 0],
            [new IntRule(), true, 1],
            [new IntRule(), "21", 21],
            [new IntRule(), "21.2", 21],
            [new IntRule(), "21.9", 21],
            [new IntRule(), 21.9, 21],
            [new IntRule(), null, null],
        ];
    }
}
