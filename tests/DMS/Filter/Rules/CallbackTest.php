<?php


namespace DMS\Filter\Rules;

use DMS\Tests\Dummy\Classes\AnnotatedClass;
use DMS\Tests\FilterTestCase;
use DMS\Filter\Exception\InvalidCallbackException;

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
            $this->expectException(InvalidCallbackException::class);
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
            array(array(AnnotatedClass::class, 'anotherCallback'), Callback::CALLABLE_TYPE, false),
            array(array(AnnotatedClass::class, 'missingCallback'), null, true),
            array(array(new AnnotatedClass(), 'callbackMethod'), Callback::CALLABLE_TYPE, false),
            array('strlen', Callback::CALLABLE_TYPE, false),
            array($closure, Callback::CLOSURE_TYPE, false),
            array(1, null, true),
            array(new \stdClass(), null, true),
        );
    }
}
