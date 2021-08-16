<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\Trim as TrimRule;

class TrimTest extends FilterTestCase
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
        $rule   = new TrimRule($options);
        $filter = new Trim();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function provideForRule(): array
    {
        return [
            [[], " my text", "my text"],
            [[], " my text ", "my text"],
            [[], "my text ", "my text"],
            [['charlist' => "\\"], "\my text", "my text"],
            ["\\", "\my text", "my text"],
            ["x", "xmy textx", "my text"],
            [[], null, null],
        ];
    }
}
