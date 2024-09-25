<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\StripTags as StripTagsRule;
use PHPUnit\Framework\Attributes\DataProvider;

class StripTagsTest extends FilterTestCase
{
    #[DataProvider('provideForRule')]
    public function testRule(StripTagsRule $rule, $value, $expectedResult): void
    {
        $filter = new StripTags();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public static function provideForRule(): array
    {
        return [
            [new StripTagsRule(), "<b>my text</b>", "my text"],
            [new StripTagsRule(), "<b>my < not an html tag> text</b>", "my < not an html tag> text"],
            [new StripTagsRule(), "<b>in this case a < 2 a > 3;</b>", "in this case a < 2 a > 3;"],
            [new StripTagsRule(allowed : "<p>"), "<b><p>my text</p></b>", "<p>my text</p>"],
            [new StripTagsRule(allowed: "<b>"), "<b><p>my text</p></b>", "<b>my text</b>"],
            [new StripTagsRule(), null, null],
        ];
    }
}
