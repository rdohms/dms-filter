<?php

namespace DMS\Filter\Filters;

use DMS\Tests\Dummy\Classes\AnnotatedClass;
use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\Callback as CallbackRule;

class CallbackTest extends FilterTestCase
{
    /**
     * @var CallbackRule | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $rule;

    /**
     * @var \DMS\Filter\Filters\Callback
     */
    protected $filter;

    public function setUp()
    {
        parent::setUp();

        $this->rule = $this->getMock('DMS\Filter\Rules\Callback');
        $this->filter = new Callback();
    }

    public function testRuleWithObjectMethod()
    {
        $this->rule->expects($this->once())->method('getInputType')->will(
            $this->returnValue(CallbackRule::SELF_METHOD_TYPE)
        );
        $this->rule->callback = 'callbackMethod';

        $obj = new AnnotatedClass();

        $this->filter->setCurrentObject($obj);
        $result = $this->filter->apply($this->rule, 'value');

        $this->assertEquals('called_back', $result);
    }

    /**
     * @expectedException \DMS\Filter\Exception\InvalidCallbackException
     */
    public function testRuleWithObjectMethodInvalid()
    {
        $this->rule->expects($this->once())->method('getInputType')->will(
            $this->returnValue(CallbackRule::SELF_METHOD_TYPE)
        );
        $this->rule->callback = 'callbackMissingMethod';

        $obj = new AnnotatedClass();

        $this->filter->setCurrentObject($obj);
        $this->filter->apply($this->rule, 'value');
    }

    /**
     * @expectedException \DMS\Filter\Exception\FilterException
     */
    public function testRuleWithObjectMethodButNoObject()
    {
        $this->rule->expects($this->once())->method('getInputType')->will(
            $this->returnValue(CallbackRule::SELF_METHOD_TYPE)
        );
        $this->rule->callback = 'callbackMissingMethod';

        $this->filter->apply($this->rule, 'value');
    }

    public function testRuleWithCallable()
    {
        $this->rule->expects($this->once())->method('getInputType')->will(
            $this->returnValue(CallbackRule::CALLABLE_TYPE)
        );
        $this->rule->callback = array('DMS\Tests\Dummy\Classes\AnnotatedClass', 'anotherCallback');

        $result = $this->filter->apply($this->rule, 'value');

        $this->assertEquals('called_back', $result);
    }

    public function testRuleWithNonStaticCallable()
    {
        $this->rule->expects($this->once())->method('getInputType')->will(
            $this->returnValue(CallbackRule::CALLABLE_TYPE)
        );
        $this->rule->callback = array(new AnnotatedClass(), 'callbackMethod');

        $result = $this->filter->apply($this->rule, 'value');

        $this->assertEquals('called_back', $result);
    }

    /**
     * @expectedException \DMS\Filter\Exception\InvalidCallbackException
     */
    public function testRuleWithCallableInvalid()
    {
        $this->rule->expects($this->once())->method('getInputType')->will(
            $this->returnValue(CallbackRule::CALLABLE_TYPE)
        );
        $this->rule->callback = array('DMS\Tests\Dummy\Classes\AnnotatedClass', 'callbackMissingMethod');

        $result = $this->filter->apply($this->rule, 'value');
    }

    public function testRuleWithClosure()
    {
        $closure = function ($value) {
            return 'called_back';
        };

        $this->rule->expects($this->once())->method('getInputType')->will(
            $this->returnValue(CallbackRule::CLOSURE_TYPE)
        );
        $this->rule->callback = $closure;

        $result = $this->filter->apply($this->rule, 'value');

        $this->assertEquals('called_back', $result);
    }

    /**
     * @expectedException \DMS\Filter\Exception\InvalidCallbackException
     */
    public function testRuleWithNonClosure()
    {
        $this->rule->expects($this->once())->method('getInputType')->will(
            $this->returnValue(CallbackRule::CLOSURE_TYPE)
        );
        $this->rule->callback = "i'm not a closure";

        $result = $this->filter->apply($this->rule, 'value');
    }
}
