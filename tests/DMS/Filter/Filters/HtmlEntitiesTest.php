<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\HtmlEntities as HtmlEntitiesRule;

class HtmlEntitiesTest extends FilterTestCase
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
        $rule   = new HtmlEntitiesRule($options);
        $filter = new HtmlEntities();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function provideForRule(): array
    {
        return [
            [[], "This is some téxt &", "This is some t&eacute;xt &amp;"],
            [[], "This &amp; is a &", "This &amp;amp; is a &amp;"],
            [['doubleEncode' => false], "This &amp; is a &", "This &amp; is a &amp;"],
            [['flags' => ENT_IGNORE], "With '\" quotes", "With '\" quotes"],
            [[], "With '\" quotes", "With '&quot; quotes"],
            [['flags' => ENT_QUOTES], "With '\" quotes", "With &#039;&quot; quotes"],
        ];
    }
}
