<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\BooleanScalar as BooleanRule;
use PHPUnit\Framework\Attributes\DataProvider;

class BooleanTest extends FilterTestCase
{
    #[DataProvider('provideForRule')]
    public function testRule(BooleanRule $rule, $value, $expectedResult): void
    {
        $filter = new BooleanScalar();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public static function provideForRule(): array
    {
        return [
            [new BooleanRule(), "My Text", true],
            [new BooleanRule(), "", false],
            [new BooleanRule(), null, false],
            [new BooleanRule(), 21.9, true],
            [new BooleanRule(), 21, true],
            [new BooleanRule(), 0, false],
        ];
    }
}
