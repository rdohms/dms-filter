<?php


namespace DMS\Filter\Filters;

use DMS\Filter\Exception\InvalidZendFilterException;
use DMS\Filter\Rules\Zend as ZendRule;
use DMS\Tests\FilterTestCase;

class ZendTest extends FilterTestCase
{

    public function testFilterShortname(): void
    {
        $rule = $this->buildRule('Boolean', ['casting' => false]);
        $filter = new Zend();
        $filter->apply($rule, '0');
        $this->expectNotToPerformAssertions();
    }

    public function testFilterFullname(): void
    {
        $rule = $this->buildRule('Zend\Filter\Boolean', ['casting' => false]);
        $filter = new Zend();
        $filter->apply($rule, '0');
        $this->expectNotToPerformAssertions();
    }

    public function testInvalidFilter(): void
    {
        $this->expectException(InvalidZendFilterException::class);
        $rule = $this->buildRule('MissingFilter');
        $filter = new Zend();
        $filter->apply($rule, '0');
    }

    protected function buildRule($class, $options = []): ZendRule
    {
        return new ZendRule(
            [
                'class'   => $class,
                'zendOptions' => $options,
            ]
        );
    }
}
