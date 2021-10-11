<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\StripNewlines as StripNewLinesRule;

class StripNewlinesTest extends FilterTestCase
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
        $rule   = new StripNewLinesRule($options);
        $filter = new StripNewlines();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function provideForRule(): array
    {
        return [
            [null, "My \n Text", "My  Text"],
            [null, "My \n\r Text", "My  Text"],
            [null, "My \r\n Text", "My  Text"],
            [
                null, "My
Text", "MyText"
            ],
            [null, null, null],
        ];
    }
}
