<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\Alnum as AlnumRule;

class AlnumTest extends FilterTestCase
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
    public function testRule($options, $value, $expectedResult, $unicodeSetting = null)
    {
        $rule   = new AlnumRule($options);
        $filter = new Alnum();

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
            array(true, "My Text21!", "My Text21", true),
            array(true, "My Text21!", "My Text21", false),
            array(true, "João Sorrisão", "João Sorrisão", true),
            array(true, "João Sorrisão", "Joo Sorriso", false),
            array(true, "GRΣΣK", "GRΣΣK", true),
            array(true, "GRΣΣK", "GRK", false),
            array(true, "Helgi Þormar Þorbjörnsson", "Helgi Þormar Þorbjörnsson", true),
            array(true, "Helgi Þormar Þorbjörnsson", "Helgi ormar orbjrnsson", false),
            array(true, "Helgi Þormar!@#$&*( )(*&%$#@Þorbjörnsson", "Helgi Þormar Þorbjörnsson", true),
            array(true, "Helgi Þormar!@#$&*( )(*&%$#@Þorbjörnsson", "Helgi ormar orbjrnsson", false),
        );
    }
}
