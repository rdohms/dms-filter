<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\StripTags as StripTagsRule;

class StripTagsTest extends FilterTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @dataProvider provideForRule
     */
    public function testRule($options, $value, $expectedResult)
    {
        $rule   = new StripTagsRule($options);
        $filter = new StripTags();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function provideForRule()
    {
        return array(
            array(array(), "<b>my text</b>", "my text"),
            array(array('allowed' => "<p>"), "<b><p>my text</p></b>", "<p>my text</p>"),
            array("<p>", "<b><p>my text</p></b>", "<p>my text</p>"),
        );
    }
}
