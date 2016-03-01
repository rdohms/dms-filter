<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\FloatScalar as FloatRule;

class FloatTest extends FilterTestCase
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
        $rule   = new FloatRule($options);
        $filter = new FloatScalar();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function provideForRule()
    {
        return array(
            array(null, "My Text", 0.0),
            array(null, "21", 21.0),
            array(null, "21.2", 21.2),
            array(null, 21.9, 21.9),
        );
    }
}
