<?php


namespace DMS\Filter\Rules;

use DMS\Tests\Dummy\Classes\AnnotatedClass;
use DMS\Tests\FilterTestCase;
use DMS\Filter\Exception\InvalidCallbackException;
use stdClass;

class CallbackTest extends FilterTestCase
{

    /**
     * @param $input
     * @param $expectedOutput
     * @param $expectException
     *
     * @dataProvider provideInputs
     */
    public function testGetInputType($input, $expectedOutput, $expectException): void
    {
        if ($expectException) {
            $this->expectException(InvalidCallbackException::class);
        }

        $rule = new Callback($input);

        $this->assertEquals($expectedOutput, $rule->getInputType());
    }

    public function provideInputs(): array
    {
        $closure = static function ($v) {};

        return [
            ['objMethod', Callback::SELF_METHOD_TYPE, false],
            [[AnnotatedClass::class, 'anotherCallback'], Callback::CALLABLE_TYPE, false],
            [[AnnotatedClass::class, 'missingCallback'], null, true],
            [[new AnnotatedClass(), 'callbackMethod'], Callback::CALLABLE_TYPE, false],
            ['strlen', Callback::CALLABLE_TYPE, false],
            [$closure, Callback::CLOSURE_TYPE, false],
            [1, null, true],
            [new stdClass(), null, true],
        ];
    }
}
