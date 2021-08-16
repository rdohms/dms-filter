<?php


namespace DMS\Filter\Filters;

use DMS\Filter\Exception\InvalidZendFilterException;
use DMS\Filter\Rules\Laminas as LaminasRule;
use DMS\Tests\FilterTestCase;

class LaminasTest extends FilterTestCase
{

    public function testFilterShortname(): void
    {
        $rule = $this->buildRule('Boolean', ['casting' => false]);
        $filter = new Laminas();
        $filter->apply($rule, '0');
        $this->expectNotToPerformAssertions();
    }

    public function testFilterFullname(): void
    {
        $rule = $this->buildRule('Laminas\Filter\Boolean', ['casting' => false]);
        $filter = new Laminas();
        $filter->apply($rule, '0');
        $this->expectNotToPerformAssertions();
    }

    public function testInvalidFilter(): void
    {
        $this->expectException(InvalidZendFilterException::class);
        $rule = $this->buildRule('MissingFilter');
        $filter = new Laminas();
        $filter->apply($rule, '0');
    }

    protected function buildRule($class, $options = []): LaminasRule
    {
        return new LaminasRule(
            [
                'class'   => $class,
                'laminasOptions' => $options,
            ]
        );
    }
}
