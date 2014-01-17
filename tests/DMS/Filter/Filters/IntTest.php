<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\Int as IntRule;

class IntTest extends FilterTestCase
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
        $rule   = new IntRule($options);
        $filter = new Int();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function provideForRule()
    {
        return array(
            array(null, "My Text", 0),
            array(null, true, 1),
            array(null, "21", 21),
            array(null, "21.2", 21),
            array(null, "21.9", 21),
            array(null, 21.9, 21),
        );
    }
}
