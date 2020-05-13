<?php


namespace DMS\Filter\Filters;

use DMS\Filter\Exception\InvalidZendFilterException;
use DMS\Filter\Rules\Zend as ZendRule;
use DMS\Tests\FilterTestCase;

class ZendTest extends FilterTestCase
{

    public function testFilterShortname()
    {
        $rule = $this->buildRule('Boolean', array('casting' => false));
        $filter = new Zend();
        $filter->apply($rule, '0');
        $this->expectNotToPerformAssertions();
    }

    public function testFilterFullname()
    {
        $rule = $this->buildRule('Zend\Filter\Boolean', array('casting' => false));
        $filter = new Zend();
        $filter->apply($rule, '0');
        $this->expectNotToPerformAssertions();
    }

    public function testInvalidFilter()
    {
        $this->expectException(InvalidZendFilterException::class);
        $rule = $this->buildRule('MissingFilter');
        $filter = new Zend();
        $filter->apply($rule, '0');
    }

    protected function buildRule($class, $options = array())
    {
        return new ZendRule(
            array(
                'class'   => $class,
                'zendOptions' => $options,
            )
        );
    }
}
