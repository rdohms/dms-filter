<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\ToLower as ToLowerRule;

class ToLowerTest extends FilterTestCase
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
    public function testRule($options, $value, $expectedResult, $useEncoding)
    {
        if ($useEncoding && !function_exists('mb_strtolower')) {
            $this->markTestSkipped('mbstring extension not enabled');
        }

        $rule   = new ToLowerRule($options);
        $filter = new ToLower();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function testInvalidEncoding()
    {
        $this->expectException(\DMS\Filter\Exception\FilterException::class);
        if (! function_exists('mb_strtolower')) {
            $this->markTestSkipped('mbstring extension not enabled');
        }

        $rule = new ToLowerRule(array('encoding' => 'invalid'));
        $filter = new ToLower();

        $result = $filter->apply($rule, 'x');
    }

    public function provideForRule()
    {
        return array(
            array(array('encoding' => 'utf-8'), "MY TEXT", "my text", true),
            array(array('encoding' => 'utf-8'), "MY Ã TEXT", "my ã text", true),
            array(array('encoding' => 'utf-8'), "MY Á TEXT", "my á text", true),
            array('utf-8', "MY Á TEXT", "my á text", true),
            array(array(), "MY TEXT", "my text", false ),
            array(array(), "MY TEXT", "my text", false ),
        );
    }
}
