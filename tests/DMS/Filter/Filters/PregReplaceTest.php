<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\PregReplace as PregReplaceRule;

class PregReplaceTest extends FilterTestCase
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
        $rule   = new PregReplaceRule($options);
        $filter = new PregReplace();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function provideForRule()
    {
        return array(
            array(array('regexp' => '/(old )/'), "the crazy old fox", "the crazy fox"),
            array(array('regexp' => '/(old)/', 'replacement' => 'new'), "the crazy old fox", "the crazy new fox"),
            array(array('regexp' => '/([0-9]*)/'), "this is day 21", "this is day "),
            array(array('regexp' => '/(style=\"[^\"]*\")/'), "<table style=\"width: 23px\" class=\"myclass\">", "<table  class=\"myclass\">"),
        );
    }
}
