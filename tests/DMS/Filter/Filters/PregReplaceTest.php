<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\PregReplace as PregReplaceRule;
use PHPUnit\Framework\Attributes\DataProvider;

class PregReplaceTest extends FilterTestCase
{
    #[DataProvider('provideForRule')]
    public function testRule(PregReplaceRule $rule, $value, $expectedResult): void
    {
        $filter = new PregReplace();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public static function provideForRule(): array
    {
        return [
            [new PregReplaceRule(regexp : '/(old )/'), "the crazy old fox", "the crazy fox"],
            [new PregReplaceRule(regexp : '/(old)/', replacement : 'new'), "the crazy old fox", "the crazy new fox"],
            [new PregReplaceRule(regexp : '/([0-9]*)/'), "this is day 21", "this is day "],
            [new PregReplaceRule(regexp : '/(style=\"[^\"]*\")/'),
                "<table style=\"width: 23px\" class=\"myclass\">", "<table  class=\"myclass\">"
            ],
            [new PregReplaceRule(regexp : '/(style=\"[^\"]*\")/'), null, null],
        ];
    }
}
