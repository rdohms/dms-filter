<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\StripTags as StripTagsRule;

class StripTagsTest extends FilterTestCase
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
        $rule   = new StripTagsRule($options);
        $filter = new StripTags();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function provideForRule(): array
    {
        return [
            [[], "<b>my text</b>", "my text"],
            [[], "<b>my < not an html tag> text</b>", "my < not an html tag> text"],
            [[], "<b>in this case a < 2 a > 3;</b>", "in this case a < 2 a > 3;"],
            [['allowed' => "<p>"], "<b><p>my text</p></b>", "<p>my text</p>"],
            ["<p>", "<b><p>my text</p></b>", "<p>my text</p>"],
            [[], null, null],
        ];
    }
}
