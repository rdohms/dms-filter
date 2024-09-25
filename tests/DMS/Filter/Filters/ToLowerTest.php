<?php

namespace DMS\Filter\Filters;

use DMS\Filter\Exception\FilterException;
use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\ToLower as ToLowerRule;
use PHPUnit\Framework\Attributes\DataProvider;

class ToLowerTest extends FilterTestCase
{
    #[DataProvider('provideForRule')]
    public function testRule(ToLowerRule $rule, $value, $expectedResult, $useEncoding): void
    {
        if ($useEncoding && !function_exists('mb_strtolower')) {
            $this->markTestSkipped('mbstring extension not enabled');
        }

        $filter = new ToLower();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function testInvalidEncoding(): void
    {
        $this->expectException(FilterException::class);
        if (! function_exists('mb_strtolower')) {
            $this->markTestSkipped('mbstring extension not enabled');
        }

        $rule = new ToLowerRule(encoding : 'invalid');
        $filter = new ToLower();

        $filter->apply($rule, 'x');
    }

    public static function provideForRule(): array
    {
        return [
            [new ToLowerRule(encoding: 'utf-8'), "MY TEXT", "my text", true],
            [new ToLowerRule(encoding: 'utf-8'), "MY Ã TEXT", "my ã text", true],
            [new ToLowerRule(encoding: 'utf-8'), "MY Á TEXT", "my á text", true],
            [new ToLowerRule(encoding: 'utf-8'), "MY À TEXT", "my à text", true],
            [new ToLowerRule(), "MY TEXT", "my text", false],
            [new ToLowerRule(), "MY TEXT", "my text", false],
            [new ToLowerRule(), null, null, false],
        ];
    }
}
