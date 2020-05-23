<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\BooleanScalar as BooleanRule;

class BooleanTest extends FilterTestCase
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
        $rule = new BooleanRule($options);
        $filter = new BooleanScalar();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function provideForRule(): array
    {
        return [
            [null, "My Text", true],
            [null, "", false],
            [null, null, false],
            [null, 21.9, true],
            [null, 21, true],
            [null, 0, false],
        ];
    }
}
