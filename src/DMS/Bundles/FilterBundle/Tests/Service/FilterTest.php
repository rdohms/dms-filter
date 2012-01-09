<?php

namespace DMS\Bundles\FilterBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FilterTest extends WebTestCase
{
    public function testLoadFilterTest()
    {
        $client = $this->createClient();
        
        $service = $client->getContainer()->get('dms.filter');
        
        $this->assertInstanceOf('DMS\Bundles\FilterBundle\Service\Filter', $service);
        
        $filter = $service->getFilterExecutor();
        
        $this->assertInstanceOf('DMS\Filter\Filter', $filter);
        
    }
}