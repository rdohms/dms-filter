<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\PregReplace as PregReplaceRule;

class PregReplaceTest extends FilterTestCase
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
        $rule   = new PregReplaceRule($options);
        $filter = new PregReplace();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function provideForRule(): array
    {
        return [
            [['regexp' => '/(old )/'], "the crazy old fox", "the crazy fox"],
            [['regexp' => '/(old)/', 'replacement' => 'new'], "the crazy old fox", "the crazy new fox"],
            [['regexp' => '/([0-9]*)/'], "this is day 21", "this is day "],
            [['regexp' => '/(style=\"[^\"]*\")/'], "<table style=\"width: 23px\" class=\"myclass\">", "<table  class=\"myclass\">"],
            [['regexp' => '/(style=\"[^\"]*\")/'], null, null],
        ];
    }
}
