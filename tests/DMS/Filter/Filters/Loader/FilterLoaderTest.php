<?php

namespace DMS\Filter\Filters\Loader;

use DMS\Filter\Rules\StripTags;
use DMS\Tests\Dummy\Rules\NoOptionsRule;
use DMS\Tests\FilterTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use UnexpectedValueException;

class FilterLoaderTest extends FilterTestCase
{
    protected FilterLoaderInterface $loader;

    public function setUp(): void
    {
        parent::setUp();

        $this->loader = new FilterLoader();
    }

    #[DataProvider('provideForGetFilter')]
    public function testGetFilterForRule($rule, $return, $expectException): void
    {
        if ($expectException) {
            $this->expectException(UnexpectedValueException::class);
        }

        $this->assertEquals($return, $this->loader->getFilterForRule($rule));
    }

    public static function provideForGetFilter(): array
    {
        return [
            [new StripTags(), new \DMS\Filter\Filters\StripTags(), false],
            [new NoOptionsRule(), new \DMS\Filter\Filters\StripTags(), true],
        ];
    }
}
