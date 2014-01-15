<?php


namespace DMS\Filter\Rules;

use DMS\Tests\Dummy\Classes\AnnotatedClass;
use DMS\Tests\FilterTestCase;

class CallbackTest extends FilterTestCase
{

    /**
     * @param $input
     * @param $expectedOutput
     * @param $expectException
     *
     * @dataProvider provideInputs
     */
    public function testGetInputType($input, $expectedOutput, $expectException)
    {
        if ($expectException) {
            $this->setExpectedException('DMS\Filter\Exception\InvalidCallbackException');
        }

        $rule = new Callback($input);

        $this->assertEquals($expectedOutput, $rule->getInputType());
    }

    public function provideInputs()
    {
        $closure = function ($v) {
            return;
        };

        return array(
            array('objMethod', Callback::SELF_METHOD_TYPE, false),
            array(array('DMS\Tests\Dummy\Classes\AnnotatedClass', 'anotherCallback'), Callback::CALLABLE_TYPE, false),
            array(array('DMS\Tests\Dummy\Classes\AnnotatedClass', 'missingCallback'), null, true),
            array(array(new AnnotatedClass(), 'callbackMethod'), Callback::CALLABLE_TYPE, false),
            array('strlen', Callback::CALLABLE_TYPE, false),
            array($closure, Callback::CLOSURE_TYPE, false),
            array(1, null, true),
            array(new \stdClass(), null, true),
        );
    }
}
