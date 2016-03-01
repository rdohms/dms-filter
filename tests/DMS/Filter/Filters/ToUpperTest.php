<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\ToUpper as ToUpperRule;

class ToUpperTest extends FilterTestCase
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
    public function testRule($options, $value, $expectedResult, $useEncoding)
    {
        if ($useEncoding && !function_exists('mb_strtoupper')) {
            $this->markTestSkipped('mbstring extension not enabled');
        }

        $rule   = new ToUpperRule($options);
        $filter = new ToUpper();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @expectedException \DMS\Filter\Exception\FilterException
     */
    public function testInvalidEncoding()
    {
        if (! function_exists('mb_strtoupper')) {
            $this->markTestSkipped('mbstring extension not enabled');
        }

        $rule   = new ToUpperRule(array('encoding' => 'invalid'));
        $filter = new ToUpper();

        $result = $filter->apply($rule, 'x');
    }

    public function provideForRule()
    {
        return array(
            array(array('encoding' => 'utf-8'), "my text", "MY TEXT", true),
            array(array('encoding' => 'utf-8'), "my ã text", "MY Ã TEXT", true),
            array(array('encoding' => 'utf-8'), "my á text", "MY Á TEXT", true),
            array('utf-8', "my á text", "MY Á TEXT", true),
            array(array(), "my text", "MY TEXT", false ),
            array(array(), "my text", "MY TEXT", false ),
        );
    }
}
