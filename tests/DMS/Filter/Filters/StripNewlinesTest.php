<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\StripNewlines as StripNewLinesRule;

class StripNewlinesTest extends FilterTestCase
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
        $rule   = new StripNewLinesRule($options);
        $filter = new StripNewlines();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function provideForRule()
    {
        return array(
            array(null, "My \n Text", "My  Text"),
            array(null, "My \n\r Text", "My  Text"),
            array(null, "My \r\n Text", "My  Text"),
            array(null, "My
Text", "MyText"),
        );
    }
}
