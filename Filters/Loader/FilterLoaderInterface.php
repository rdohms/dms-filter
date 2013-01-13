<?php
namespace DMS\Filter\Filters\Loader;

use DMS\Filter\Filters\BaseFilter;
use DMS\Filter\Rules\Rule;
use Symfony\Component\DependencyInjection\ContainerInterface;

interface FilterLoaderInterface
{
    /**
     * Finds the filter responsible for executing a specific rule
     *
     * @param Rule $rule
     *
     * @throws \UnexpectedValueException If filter can't be located
     * @return BaseFilter
     */
    public function getFilterForRule(Rule $rule);
}
