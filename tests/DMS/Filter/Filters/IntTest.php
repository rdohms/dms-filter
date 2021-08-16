<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\IntScalar as IntRule;

class IntTest extends FilterTestCase
{

    /**
     * @dataProvider provideForRule
     *
     * @param $options
     * @param $value
     * @param $expectedResult
     */
    public function testRule($options, $value, $expectedResult): void
    {
        $rule   = new IntRule($options);
        $filter = new IntScalar();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function provideForRule(): array
    {
        return [
            [null, "My Text", 0],
            [null, true, 1],
            [null, "21", 21],
            [null, "21.2", 21],
            [null, "21.9", 21],
            [null, 21.9, 21],
            [null, null, null],
        ];
    }
}
