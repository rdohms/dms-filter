<?php

namespace DMS\Filter\Rules;

use DMS\Tests\Dummy\Classes\AttributedClass;
use DMS\Tests\FilterTestCase;
use DMS\Filter\Exception\InvalidCallbackException;
use PHPUnit\Framework\Attributes\DataProvider;
use stdClass;

class CallbackTest extends FilterTestCase
{
    #[DataProvider('provideInputs')]
    public function testGetInputType($input, $expectedOutput, $expectException): void
    {
        if ($expectException) {
            $this->expectException(InvalidCallbackException::class);
        }

        $rule = new Callback($input);

        $this->assertEquals($expectedOutput, $rule->getInputType());
    }

    public static function provideInputs(): array
    {
        $closure = static function ($v) {
        };

        return [
            ['objMethod', Callback::SELF_METHOD_TYPE, false],
            [[AttributedClass::class, 'anotherCallback'], Callback::CALLABLE_TYPE, false],
            [[AttributedClass::class, 'missingCallback'], null, true],
            [[new AttributedClass(), 'callbackMethod'], Callback::CALLABLE_TYPE, false],
            ['strlen', Callback::CALLABLE_TYPE, false],
            [$closure, Callback::CLOSURE_TYPE, false],
            [1, null, true],
            [new stdClass(), null, true],
        ];
    }
}
