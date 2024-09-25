<?php

declare(strict_types=1);

namespace DMS\Filter\Filters;

use DMS\Filter\Exception\InvalidZendFilterException;
use DMS\Filter\Rules\Laminas as LaminasRule;
use DMS\Tests\FilterTestCase;

class LaminasTest extends FilterTestCase
{
    public function testFilterDenyList(): void
    {
        $rule = $this->buildRule(
            'Laminas\Filter\DenyList',
            ['list' => ['blocked@example.com', 'spam@example.com']]
        );

        $filter = new Laminas();
        $this->assertTrue(!is_null($filter->apply($rule, 'billy@example.com')));
        $this->assertTrue(is_null($filter->apply($rule, 'blocked@example.com')));
        $this->assertTrue(!is_null($filter->apply($rule, 'menphis@example.com')));
        $this->assertTrue(is_null($filter->apply($rule, 'spam@example.com')));
        $this->assertTrue(!is_null($filter->apply($rule, 'spam12@example.com')));
    }

    public function testFilterBaseName(): void
    {
        $rule = $this->buildRule('Laminas\Filter\BaseName');
        $filter = new Laminas();
        $this->assertSame('file.txt', $filter->apply($rule, '/path/to/file.txt'));
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
        return new LaminasRule($class, $options);
    }
}
