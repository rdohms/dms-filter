<?php

namespace DMS\Filter\Filters\Loader;

use DMS\Filter\Rules\StripTags;
use DMS\Tests\Dummy\Rules\NoOptionsRule;
use DMS\Tests\FilterTestCase;

class FilterLoaderTest extends FilterTestCase
{
    /**
     * @var FilterLoader
     */
    protected $loader;

    public function setUp(): void
{
        parent::setUp();

        $this->loader = new FilterLoader();
    }

    public function tearDown(): void
{
        parent::tearDown();
    }

    /**
     * @param $rule
     * @param $return
     * @param $expectException
     *
     * @dataProvider provideForGetFilter
     */
    public function testGetFilterForRule($rule, $return, $expectException)
    {
        if ($expectException) {
            $this->expectException(\UnexpectedValueException::class);
        }

        $this->assertEquals($return, $this->loader->getFilterForRule($rule));
    }

    public function provideForGetFilter()
    {
        return array(
            array(new StripTags(), new \DMS\Filter\Filters\StripTags(), false),
            array(new NoOptionsRule(), new \DMS\Filter\Filters\StripTags(), true),
        );
    }
}
