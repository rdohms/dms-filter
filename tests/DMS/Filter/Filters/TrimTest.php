<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\Trim as TrimRule;

class TrimTest extends FilterTestCase
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
        $rule   = new TrimRule($options);
        $filter = new Trim();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function provideForRule()
    {
        return array(
            array(array(), " my text", "my text"),
            array(array(), " my text ", "my text"),
            array(array(), "my text ", "my text"),
            array(array('charlist' => "\\"), "\my text", "my text"),
            array("\\", "\my text", "my text"),
            array("x", "xmy textx", "my text"),
        );
    }
}
