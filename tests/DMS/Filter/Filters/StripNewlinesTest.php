<?php

namespace DMS\Filter\Filters;

use DMS\Tests\FilterTestCase;
use DMS\Filter\Rules\StripNewlines as StripNewLinesRule;
use PHPUnit\Framework\Attributes\DataProvider;

class StripNewlinesTest extends FilterTestCase
{
    #[DataProvider('provideForRule')]
    public function testRule(StripNewLinesRule $rule, $value, $expectedResult): void
    {
        $filter = new StripNewlines();

        $result = $filter->apply($rule, $value);

        $this->assertEquals($expectedResult, $result);
    }

    public static function provideForRule(): array
    {
        return [
            [new StripNewLinesRule(), "My \n Text", "My  Text"],
            [new StripNewLinesRule(), "My \n\r Text", "My  Text"],
            [new StripNewLinesRule(), "My \r\n Text", "My  Text"],
            [new StripNewLinesRule(), "MyText", "MyText"],
            [new StripNewLinesRule(), null, null],
        ];
    }
}
