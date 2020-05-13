<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\HtmlEntities as HtmlEntitiesRule;

class HtmlEntitiesTest extends FilterTestCase
{

    public function setUp(): void
{
        parent::setUp();
    }

    public function tearDown(): void
{
        parent::tearDown();
    }

    /**
     * @dataProvider provideForRule
     */
    public function testRule($options, $value, $expectedResult)
    {
        $rule   = new HtmlEntitiesRule($options);
        $filter = new HtmlEntities();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function provideForRule()
    {
        return array(
            array(array(), "This is some téxt &", "This is some t&eacute;xt &amp;"),
            array(array(), "This &amp; is a &", "This &amp;amp; is a &amp;"),
            array(array('doubleEncode' => false), "This &amp; is a &", "This &amp; is a &amp;"),
            array(array('flags' => ENT_IGNORE), "With '\" quotes", "With '\" quotes"),
            array(array(), "With '\" quotes", "With '&quot; quotes"),
            array(array('flags' => ENT_QUOTES), "With '\" quotes", "With &#039;&quot; quotes"),
        );
    }
}
