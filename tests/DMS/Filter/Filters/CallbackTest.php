<?php

namespace DMS\Filter\Filters;

use DMS\Filter\Exception\FilterException;
use DMS\Filter\Exception\InvalidCallbackException;
use DMS\Tests\Dummy\Classes\AnnotatedClass;
use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\Callback as CallbackRule;
use PHPUnit\Framework\MockObject\MockObject;

class CallbackTest extends FilterTestCase
{
    /**
     * @var CallbackRule | MockObject
     */
    protected $rule;

    /**
     * @var \DMS\Filter\Filters\Callback
     */
    protected $filter;

    public function setUp(): void
{
        parent::setUp();

        $this->rule = $this->getMockBuilder(CallbackRule::class)->getMock();
        $this->filter = new Callback();
    }

    public function testRuleWithObjectMethod(): void
    {
        $this->rule->expects($this->once())->method('getInputType')->willReturn(
            CallbackRule::SELF_METHOD_TYPE
        );
        $this->rule->callback = 'callbackMethod';

        $obj = new AnnotatedClass();

        $this->filter->setCurrentObject($obj);
        $result = $this->filter->apply($this->rule, 'value');

        $this->assertEquals('called_back', $result);
    }

    public function testRuleWithObjectMethodInvalid()
    {
        $this->expectException(InvalidCallbackException::class);
        $this->rule->expects($this->once())->method('getInputType')->willReturn(
            CallbackRule::SELF_METHOD_TYPE
        );
        $this->rule->callback = 'callbackMissingMethod';

        $obj = new AnnotatedClass();

        $this->filter->setCurrentObject($obj);
        $this->filter->apply($this->rule, 'value');
    }

    public function testRuleWithObjectMethodButNoObject()
    {
        $this->expectException(FilterException::class);
        $this->rule->expects($this->once())->method('getInputType')->willReturn(
            CallbackRule::SELF_METHOD_TYPE
        );
        $this->rule->callback = 'callbackMissingMethod';

        $this->filter->apply($this->rule, 'value');
    }

    public function testRuleWithCallable()
    {
        $this->rule->expects($this->once())->method('getInputType')->willReturn(
            CallbackRule::CALLABLE_TYPE
        );
        $this->rule->callback = array(AnnotatedClass::class, 'anotherCallback');

        $result = $this->filter->apply($this->rule, 'value');

        $this->assertEquals('called_back', $result);
    }

    public function testRuleWithNonStaticCallable()
    {
        $this->rule->expects($this->once())->method('getInputType')->willReturn(
            CallbackRule::CALLABLE_TYPE
        );
        $this->rule->callback = array(new AnnotatedClass(), 'callbackMethod');

        $result = $this->filter->apply($this->rule, 'value');

        $this->assertEquals('called_back', $result);
    }

    public function testRuleWithCallableInvalid()
    {
        $this->expectException(InvalidCallbackException::class);
        $this->rule->expects($this->once())->method('getInputType')->willReturn(
            CallbackRule::CALLABLE_TYPE
        );
        $this->rule->callback = array(AnnotatedClass::class, 'callbackMissingMethod');

        $result = $this->filter->apply($this->rule, 'value');
    }

    public function testRuleWithClosure()
    {
        $closure = function ($value) {
            return 'called_back';
        };

        $this->rule->expects($this->once())->method('getInputType')->willReturn(
            CallbackRule::CLOSURE_TYPE
        );
        $this->rule->callback = $closure;

        $result = $this->filter->apply($this->rule, 'value');

        $this->assertEquals('called_back', $result);
    }

    public function testRuleWithNonClosure()
    {
        $this->expectException(InvalidCallbackException::class);
        $this->rule->expects($this->once())->method('getInputType')->willReturn(
            CallbackRule::CLOSURE_TYPE
        );
        $this->rule->callback = "i'm not a closure";

        $result = $this->filter->apply($this->rule, 'value');
    }
}
