<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\HtmlEntities as HtmlEntitiesRule;
use PHPUnit\Framework\Attributes\DataProvider;

class HtmlEntitiesTest extends FilterTestCase
{
    #[DataProvider('provideForRule')]
    public function testRule(HtmlEntitiesRule $rule, $value, $expectedResult): void
    {
        $filter = new HtmlEntities();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public static function provideForRule(): array
    {
        return [
            [new HtmlEntitiesRule(), "This is some téxt &", "This is some t&eacute;xt &amp;"],
            [new HtmlEntitiesRule(), "This &amp; is a &", "This &amp;amp; is a &amp;"],
            [new HtmlEntitiesRule(doubleEncode: false), "This &amp; is a &", "This &amp; is a &amp;"],
            [new HtmlEntitiesRule(flags : ENT_IGNORE), "With '\" quotes", "With '\" quotes"],
            [new HtmlEntitiesRule(), "With '\" quotes", "With '&quot; quotes"],
            [new HtmlEntitiesRule(flags :ENT_QUOTES), "With '\" quotes", "With &#039;&quot; quotes"],
        ];
    }
}
