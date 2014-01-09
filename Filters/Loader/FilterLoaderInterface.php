<?php
namespace DMS\Filter\Filters\Loader;

use DMS\Filter\Filters\BaseFilter;
use DMS\Filter\Rules\Rule;

/**
 * Interface FilterLoaderInterface
 *
 * Defines the required interface for a loader capable of finding the executor of a specific rule.
 *
 * @package DMS\Filter\Filters\Loader
 */
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
