<?php

namespace DMS\Filter\Filters\Loader;

use DMS\Filter\Rules\StripTags;
use DMS\Tests\FilterTestCase;

class FilterLoaderTest extends FilterTestCase
{
    /**
     * @var FilterLoader
     */
    protected $loader;

    public function setUp()
    {
        parent::setUp();

        $this->loader = new FilterLoader();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @param $rule
     * @param $container
     * @param $return
     *
     * @dataProvider provideForGetFilter
     */
    public function testGetFilterForRule($rule, $container, $return)
    {
        $this->loader->setContainer($container);

        $this->assertEquals($return, $this->loader->getFilterForRule($rule));
    }

    public function provideForGetFilter()
    {
        return array(
            array(new StripTags(), null, new \DMS\Filter\Filters\StripTags()),
        );
    }
}
