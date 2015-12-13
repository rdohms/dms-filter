<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\BooleanScalar as BooleanRule;

class BooleanTest extends FilterTestCase
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
        $rule = new BooleanRule($options);
        $filter = new BooleanScalar();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function provideForRule()
    {
        return array(
            array(null, "My Text", true),
            array(null, "", false),
            array(null, NULL, false),
            array(null, 21.9, true),
            array(null, 21, true),
            array(null, 0, false),
        );
    }
}
