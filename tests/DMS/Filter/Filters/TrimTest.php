<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\Trim as TrimRule;
use PHPUnit\Framework\Attributes\DataProvider;

class TrimTest extends FilterTestCase
{
    #[DataProvider('provideForRule')]
    public function testRule(TrimRule $rule, $value, $expectedResult): void
    {
        $filter = new Trim();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public static function provideForRule(): array
    {
        return [
            [new TrimRule(), " my text", "my text"],
            [new TrimRule(), " my text ", "my text"],
            [new TrimRule(), "my text ", "my text"],
            [new TrimRule(charlist: '\\'), "\my text", "my text"],
            [new TrimRule(charlist: "#"), "#my text##", "my text"],
            [new TrimRule(charlist: 'x'), "xmy textx", "my text"],
            [new TrimRule(), null, null],
        ];
    }
}
