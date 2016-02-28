<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\Alpha as AlphaRule;

class AlphaTest extends FilterTestCase
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
    public function testRule($options, $value, $expectedResult, $unicodeSetting = null)
    {
        $rule   = new AlphaRule($options);
        $filter = new Alpha();

        if ($unicodeSetting !== null) {
            $property = new \ReflectionProperty($filter, 'unicodeEnabled');
            $property->setAccessible(true);
            $property->setValue($filter, $unicodeSetting);
        }

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function provideForRule()
    {
        return array(
            array(false, "My Text", "MyText", true),
            array(false, "My Text", "MyText", false),
            array(true, "My Text", "My Text", true),
            array(true, "My Text", "My Text", false),
            array(true, "My Text!", "My Text", true),
            array(true, "My Text!", "My Text", false),
            array(true, "My Text21!", "My Text", true),
            array(true, "My Text21!", "My Text", false),
            array(true, "João 2Sorrisão", "João Sorrisão", true),
            array(true, "João 2Sorrisão", "Joo Sorriso", false),
            array(true, "Helgi Þormar Þorbjörnsson", "Helgi Þormar Þorbjörnsson", true),
            array(true, "Helgi Þormar Þorbjörnsson", "Helgi ormar orbjrnsson", false),
            array(true, "Helgi Þormar!@#$&*( )(*&%$#@Þorbjörnsson", "Helgi Þormar Þorbjörnsson", true),
            array(true, "Helgi Þormar!@#$&*( )(*&%$#@Þorbjörnsson", "Helgi ormar orbjrnsson", false),
        );
    }
}
