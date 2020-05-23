<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\FloatScalar as FloatRule;

class FloatTest extends FilterTestCase
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
        $rule   = new FloatRule($options);
        $filter = new FloatScalar();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function provideForRule(): array
    {
        return [
            [null, "My Text", 0.0],
            [null, "21", 21.0],
            [null, "21.2", 21.2],
            [null, 21.9, 21.9],
        ];
    }
}
