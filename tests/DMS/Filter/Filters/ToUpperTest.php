<?php

namespace DMS\Filter\Filters;

use DMS\Filter\Exception\FilterException;
use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\ToUpper as ToUpperRule;
use PHPUnit\Framework\Attributes\DataProvider;

class ToUpperTest extends FilterTestCase
{
    #[DataProvider('provideForRule')]
    public function testRule(ToUpperRule $rule, $value, $expectedResult, $useEncoding): void
    {
        if ($useEncoding && !function_exists('mb_strtoupper')) {
            $this->markTestSkipped('mbstring extension not enabled');
        }

        $filter = new ToUpper();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public function testInvalidEncoding(): void
    {
        $this->expectException(FilterException::class);
        if (! function_exists('mb_strtoupper')) {
            $this->markTestSkipped('mbstring extension not enabled');
        }

        $rule   = new ToUpperRule(encoding :'invalid');
        $filter = new ToUpper();

        $r = $filter->apply($rule, 'x');
    }

    public static function provideForRule(): array
    {
        return [
            [new ToUpperRule(encoding: 'utf-8'), "my text", "MY TEXT", true],
            [new ToUpperRule(encoding: 'utf-8'), "my ã text", "MY Ã TEXT", true],
            [new ToUpperRule(encoding: 'utf-8'), "my á text", "MY Á TEXT", true],
            [new ToUpperRule(encoding: 'utf-8'), "my à text", "MY À TEXT", true],
            [new ToUpperRule(), "my text", "MY TEXT", false],
            [new ToUpperRule(), "my text", "MY TEXT", false],
            [new ToUpperRule(), null, null, false],
        ];
    }
}
